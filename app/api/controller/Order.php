<?php
// +----------------------------------------------------------------------
// | HaSog (幻神商城系统)
// +----------------------------------------------------------------------
// | 技术支持【幻神科技】: https://www.hasog.com
// +----------------------------------------------------------------------
// | 联系我们:  https://www.hasog.com
// +----------------------------------------------------------------------
// | gitee开源项目：https://gitee.com/orzice/hasog
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/orzice/hasog
// +----------------------------------------------------------------------
// | Author：王火火(王琰豪)  https://gitee.com/w321
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------


namespace app\api\controller;


use app\common\controller\ApiController;
use app\common\model\Dispatch;
use app\common\model\DispatchData;
use app\common\model\Member;
use app\common\model\MemberAddress;
use app\common\model\Goods;
use app\common\model\Order as OrderModel;

use think\Exception;
use think\facade\Config;
use think\facade\Db;
use think\facade\Event;

class Order extends ApiController
{
    // 订单生成请求
    /*public function add_order()
    {
//        $example = ['goods_data' => [
//                ['goods_id' => 1, 'goods_num' => 1],
//                ['goods_id' => 2, 'goods_num' => 3],
//                'address_id'=> 1,
//                'dispatch_type_id'=> 1,
//            ],
//        ];
//        print_r(json_encode($example));die();

        $post = $this->request->post();
        $rule = [
            'pid|pid' => 'require|number',
            'user_address|收货地址' => 'require|number',
        ];
        $validate = $this->validate($post, $rule);
//        print_r($post);die();
//        $user_id = $this->MemberId();
        $user_id = 1;
        $user = Member::find($user_id);
        $order_sn = OrderModel::createOrderSn('AC');
        $price = 0;
//        $goods_price = 0;
        $goods_total = 0;
        $goods_data = $post['goods_data'];
        $address_id = $post['address_id'];
        $dispatch_type_id = $post['dispatch_type_id'];
//        $goods_objs = Goods::whereIn('id', array_column($goods_data, 'goods_id'));
        $goods_objs = [];
        foreach ($goods_data as $goods_item){
            $goods_obj = Goods::where('id', $goods_item['goods_id'])
                ->where('status', 1)->find;
            empty($goods_obj) && $this->error('部分商品不存在或已下架');
            $goods_obj->stock === 0 && $this->error($goods_obj->title.'暂时无货');
            $price += $goods_obj->price * $goods_item['goods_num'];
            $goods_total += $goods_item['goods_num'];
            $goods_objs[] = ['obj'=>$goods_obj, 'num'=> $goods_item['goods_num'] ];
        }
        $order_data = [
            'uid' => $user_id,
            'order_sn' => $order_sn,
            'status' => 0,
//            'dispatch_type_id'=> ,
            'order_goods_price' => $user_id,
        ];
    }*/

    // 生成订单请求
    public function add_order()
    {
        $post = $this->request->post();
        $rule = [
            'pid|pid' => 'require|number',
            'user_address|收货地址' => 'require|number',
        ];
        $validate = $this->validate($post, $rule);
        $user_id = $this->MemberId();
//        $user_id = 1;
        $user = Member::find($user_id);
        $order_sn = OrderModel::createOrderSn('AC');
        $goods_price = 0;
        $discount_price = 0;
        $order_goods_price = 0;
        $goods_total = 0;
        $cost_amount = 0;
        // 初始化 订单商品列表 地址id  重量 运费 等数据
        $goods_data = isset($post['goods_data']) ? $post['goods_data'] : [];
        $member_remark = isset($post['member_remark']) ? $post['member_remark'] : '';
        $request_address = isset($post['address_id']) ? $post['address_id'] : null ;
        $request_address = $user->address()->where('id', $request_address)->find();
        if (empty($request_address)){
            $default_address = $user->address()->where('is_default', 1)->find();
            empty($default_address) && $request_address =  $user->address()->select()->first();
        }
        $weight = 0;
        $dispatch_price = 0;
        $goods_objs = [];
        // 计算 重量运费 等数据
        foreach ($goods_data as $goods_item){
            $rule = [
                'goods_num|商品数量' => 'number|between: 1,999999',
            ];
            $validate = $this->validate($goods_item, $rule);
            //验证失败
            if($validate !== true){
                return api_return(0, '商品数量只能为正整数');
            }
            $goods_obj = Goods::where('id', $goods_item['goods_id'])
                ->where('status', 1)->find();
            empty($goods_obj) && $this->error('部分商品不存在或已下架');
            $discount_price += ($goods_obj->market_price - $goods_obj->price) * $goods_item['goods_num'];
            $order_goods_price += ($goods_obj->market_price) * $goods_item['goods_num'];
            $goods_obj->stock === 0 && $this->error($goods_obj->title.'暂时无货');
            $goods_price += $goods_obj->price * $goods_item['goods_num'];
            $goods_objs[] = ['goods_obj'=>$goods_obj, 'goods_num'=> $goods_item['goods_num'] ];
            $goods_total += $goods_item['goods_num'];
            $cost_amount += $goods_obj['cost_price'] * $goods_item['goods_num'];
            // 计算重量
            $goods_weight = $goods_obj->weight * $goods_item['goods_num'];
            $weight += $goods_weight;
            // 计算运费
            $dispatch_obj = $goods_obj->dispatch_obj;
            $dispatch_datas = DispatchData::where('did', $dispatch_obj->id)->order('display_order')->select();
            // 选出 收货地址 配对的 配送逻辑 并计算运费
            $goods_dispatch = null;
            foreach ($dispatch_datas as $dispatch_data) {
                $dispatch_address = json_decode($dispatch_data->area);
                if ($dispatch_address[0]['id'] == 91) {
                    $goods_dispatch = $dispatch_data;
                    break;
                } elseif ($dispatch_address[0]['id'] == $request_address->province_id) {
                    if (isset($dispatch_address[1]['id'])) {
                        if ($dispatch_address[1]['id'] == $request_address->city_id) {
                            if (isset($dispatch_address[2]['id'])) {
                                if ($dispatch_address[2]['id'] == $request_address->district_id) {
                                    if (isset($dispatch_address[3]['id'])) {
                                        if ($dispatch_address[3]['id'] == $request_address->street_id) {
                                        } else {
                                            $request_address = $dispatch_address;
                                            break;
                                        }
                                    }
                                } else {
                                    $goods_dispatch = $dispatch_data;
                                    break;
                                }
                            }
                        } else {
                            $goods_dispatch = $dispatch_data;
                            break;
                        }
                    }
                }
            }
            // 计算运费
            if ($goods_dispatch){
//                $dispatch_price += $first ;
                if ($goods_item['goods_num'] > $goods_dispatch->first_piece){
                    $remain_goods = $goods_item['goods_num'] - $goods_dispatch->first_piece;
                    $dispatch_price += $goods_dispatch->first_piece_price;
                    $remain_price = $goods_dispatch->another_piece === 0 ? 0 :ceil($remain_goods/$goods_dispatch->another_piece) * $goods_dispatch->another_piece_price;
                    $dispatch_price += $remain_price;
                }
            }
        }
        // 要返回的数据
        $price = $dispatch_price + $goods_price;
//        $this->success('请求成功', $data);
        $order_data = [
            'uid' => $user_id,
            'order_sn' => $order_sn,
            'status' => 0,
            'dispatch_price' => $dispatch_price,
            'goods_price' => $goods_price,       // 总现价
            'goods_total' => $goods_total,       // 总计数量
            'discount_price' => $discount_price, // 总折扣价
            'order_goods_price' => $order_goods_price, // 总原价
            'price' => $price,
            'cost_amount' => $cost_amount,
            'member_remark'=> $member_remark
        ];
        try{
            $order = new OrderModel($order_data);
//            $save_goods = $order->goods()->saveAll();
            $order_save = $order->save();
            Db::startTrans();
            $order->generate_address($request_address);
            $save = $order->together(['address'])->save();
            $save_goods = $order->generate_goods($goods_objs);
            if ($order_save=== false || $save === false || $save_goods=== false){
                $order->delete();
//                $this->success('生成订单成功');
                throw new \Exception('添加失败');
            }
            Db::commit();
        }catch (\Exception $e){
            Db::rollback();
            $this->error('生成订单失败，请稍后重试');
        }
/*        if ($order_save && $save && $save_goods){
            Db::commit();
            $this->success('生成订单成功');
        }*/
        $this->success('生成订单成功');
//        Db::rollback();
//        $order->delete();
//        $this->error('生成订单失败，请稍后重试');
    }


    // 订单生成页面
    public function cache_order()
    {
        $post = $this->request->post();
//        print_r($post);die();
        $user_id = $this->MemberId();
//        $user_id = 1;
        $user = Member::find($user_id);
        $order_sn = OrderModel::createOrderSn('AC');
//        $price = 0;
        $goods_price = 0;
        $discount_price = 0;
        $order_goods_price = 0;
//        $goods_price = 0;
        // 初始化 订单商品列表 地址id  重量 运费 等数据
        $goods_data = isset($post['goods_data']) ? $post['goods_data'] : [];
        empty($goods_data) && $this->error('请提交商品');
//        $user_address = $user->address();
        $request_address = isset($post['address_id']) ? $post['address_id'] : null ;
        $request_address = $user->address()->where('id', $request_address)->find();
//        print_r($request_address);die();
        if (empty($request_address)){
            $default_address = $user->address()->where('is_default', 1)->find();
            empty($default_address) && $request_address =  $user->address()->select()->first();
//            print_r($request_address->toArray());die();
        }
        // 直接获取 goods 数组 但是还需要 计算相关东西 所以不使用whereIn
//        $goods_objs = Goods::whereIn('id', array_column($goods_data, 'goods_id'));
//        $dispatch_type_id = isset($post['dispatch_type_id']) ? $post['dispatch_type_id'] : null ;
        $weight = 0;
        $dispatch_price = 0;
        $goods_objs = [];
        // 计算 重量运费 等数据
        foreach ($goods_data as $goods_item){
            $rule = [
                'goods_num|商品数量' => 'number|between: 1,999999',
            ];
            $validate = $this->validate($goods_item, $rule);
            //验证失败
            if($validate !== true){
                return api_return(0, '商品数量只能为正整数');
            }
            $goods_obj = Goods::where('id', $goods_item['goods_id'])
                ->where('status', 1)->hidden(['cost_price','reduce_stock_method', 'real_sales', 'virtual_sales' ])->find();
            empty($goods_obj) && $this->error('部分商品不存在或已下架');
            $discount_price += ($goods_obj->market_price - $goods_obj->price) * $goods_item['goods_num'];
            $order_goods_price += ($goods_obj->market_price) * $goods_item['goods_num'];
            $goods_obj->stock === 0 && $this->error($goods_obj->title.'暂时无货');
            $goods_price += $goods_obj->price * $goods_item['goods_num'];
            $goods_objs[] = ['goods_obj'=>$goods_obj, 'goods_num'=> $goods_item['goods_num'] ];
            // 计算重量
            $goods_weight = $goods_obj->weight * $goods_item['goods_num'];
            $weight += $goods_weight;
            // 计算运费
            $dispatch_obj = $goods_obj->dispatch_obj;
//            $dispatch_obj->dispatch_data;
            $dispatch_datas = DispatchData::where('did', $dispatch_obj->id)->order('display_order')->select();
//            $dispatch_datas = !empty($dispatch_obj->dispatch_data) ? $dispatch_obj->dispatch_data()->order('display_order'): [] ;

            // 选出 收货地址 配对的 配送逻辑 并计算运费
            $goods_dispatch = 0;
            foreach ($dispatch_datas as $dispatch_data) {
                $dispatch_address = json_decode($dispatch_data->area);
                if ($dispatch_address[0]['id'] == 91) {
                    $goods_dispatch = $dispatch_data;
                    break;
                } elseif ($dispatch_address[0]['id'] == $request_address->province_id) {
                    if (isset($dispatch_address[1]['id'])) {
                        if ($dispatch_address[1]['id'] == $request_address->city_id) {
                            if (isset($dispatch_address[2]['id'])) {
                                if ($dispatch_address[2]['id'] == $request_address->district_id) {
                                    if (isset($dispatch_address[3]['id'])) {
                                        if ($dispatch_address[3]['id'] == $request_address->street_id) {
                                        } else {
                                            $request_address = $dispatch_address;
                                            break;
                                        }
                                    }
                                } else {
                                    $goods_dispatch = $dispatch_data;
                                    break;
                                }
                            }
                        } else {
                            $goods_dispatch = $dispatch_data;
                            break;
                        }
                    }
                }
            }
            // 计算运费
            if ($goods_dispatch){
//                $dispatch_price += $first ;
                if ($goods_item['goods_num'] > $goods_dispatch->first_piece){
                    $remain_goods = $goods_item['goods_num'] - $goods_dispatch->first_piece;
                    $dispatch_price += $goods_dispatch->first_piece_price;
                    $remain_price = $goods_dispatch->another_piece === 0 ? 0 :ceil($remain_goods/$goods_dispatch->another_piece) * $goods_dispatch->another_piece_price;
                    $dispatch_price += $remain_price;
                }
            }

            // 返回配送类型---
        }
        // 要返回的数据
        $price = $dispatch_price + $goods_price;
        $data = [
            'goods' => $goods_objs,
            'weight' => $weight,
            'check_address' => $request_address->id,
            'user_address' => $user->address,
            'pay_type' => OrderModel::PAY_TYPE_ID,
            'dispatch_price' => $dispatch_price,
            'goods_price' => $goods_price,       // 总现价
            'discount_price' => $discount_price, // 总折扣价
            'order_goods_price' => $order_goods_price, // 总原价
//            'order_goods_price' => $user_id,
            'price' => $price,
        ];
        $this->success('请求成功', $data);
    }


    // 支付订单
    public function pay_order()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null ;
        $pay_type_id = isset($post['pay_type_id']) ? $post['pay_type_id'] : null ;
        empty($order_id) && $this->error('订单不存在');
        !array_key_exists($pay_type_id, OrderModel::PAY_TYPE_ID) && $this->error('请选择正确的支付方式');
        $user_id = $this->MemberId();
//        $user_id = 1;
        $user = Member::find($user_id);
        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)->find();
        empty($order_id) && $this->error('订单不存在');
        // 获取支付逻辑
        /**
         $order->is_paid === 1;  // 获取支付结果
         $order->pay_type_id = 1;
        **/
        // 付款减库存

        if($order->status === 0){
            $order->status = 1;
            $order->pay_time = time();
            // 此处应该有支付逻辑并更改支付id
            $order->pay_type_id = $pay_type_id;
            try{
                Db::startTrans();
                $goods_array = $order->goods;
                foreach ($goods_array as &$goods_obj){
                    if ($goods_obj->reduce_stock_method === 1){
                        $goods_obj->stock -= 1;
                        $goods_obj->save();
                    }
                }
                $save = $order->save();

                if ($save === false){
//                    $this->success('支付成功');
                    throw new \Exception('添加失败');
                }
                Db::commit();
            }catch(\Exception $e){
                Db::rollback();
                $this->error('支付失败请稍后重试');
                // $this->tuikuan() // 退款操作
            }
//            if ($save){
//                $this->success('支付成功');
//            }
//            Db::rollback();
//            $this->error('支付失败请稍后重试');
            $this->success('支付成功');

        }
        $this->error('该订单当前状态不能付款');

    }

    // 确认收货
    public function confirm_receipt()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null ;
        empty($order_id) && $this->error('订单不存在');
        $user_id = $this->MemberId();
//        $user_id = 1;
        $user = Member::find($user_id);
        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)->find();
        empty($order_id) && $this->error('订单不存在');
//        if($order->status == 2){
            $order->status = 3;
            $order->finish_time = time();
            try{
                $save = $order->save();
            }catch(\Exception $e){
                $this->error('确认收货失败请稍后重试');
                // $this->tuikuan() // 退款操作
            }
            if ($save){
                $this->success('确认收货成功');
            }
            $this->error('确认收货失败请稍后重试');
//        }
//        $this->error('还未发货,不能确认收货');
    }

    // 退款申请
    public function apply_refund()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null ;
        empty($order_id) && $this->error('订单不存在');
        $user_id = $this->MemberId();
//        $user_id = 1;
        $user = Member::find($user_id);
        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)->find();
        empty($order_id) && $this->error('订单不存在');
        if(!in_array($order->status, [-2,-1,0,])){
            $order->status = -2;
            Db::startTrans();
            try{
                $data = [
                    'uid' => $order->uid,
                    'order_id' => $order->id,
                    'price' => $order->price,
                    'order_sn' => $order->order_sn,
                    'status' => 0,
                ];
                $save_refund = $order->order_refund()->save($data);
                $order->status = -2;
                $save = $order->save();
                if ($save_refund === false || $save === false){
                    throw new \Exception('添加失败');
                }
                Db::commit();
            }catch (\Exception $e){
                Db::rollback();
                $this->error('申请失败');
            }
//        $save ? $this->success('申请成功', ['status'=>Order::STATUS_ARRAY[$order->status]]) : $this->error('订单错误') ;
/*            if ($save_refund && $save){
                Db::rollback();
                $this->success('申请成功');
            }
            $this->error('申请失败请稍后重试');*/
            $this->success('申请成功');
        }
        $this->error('该订单当前状态不能申请退款');
    }

/*    // 返回订单页面所需信息
    public function dispatchs()
    {
        $dispatch_objs = Dispatch::select();
        foreach ($dispatch_objs as &$dispatch_obj){
            $dispatch_obj->dispatch_data;
        }
//        $data = ['dispatch_objs'=> $dispatch_objs, 'user_address' => $user_address ];
        $this->success('请求成功', $dispatch_objs->toArray());
    }*/

    // 用户地址列表及选择
    public function user_address(){
        $user_id = $this->MemberId();
//        $user_id = 1;
        $user_address = MemberAddress::where('uid', $user_id)->select()
            ->hidden(['create_time', 'update_time', 'delete_time'])
            ->toArray();
        $this->success('请求成功', $user_address->toArray());
    }


    // 订单详情 get order_id
    public function order_detail()
    {
        $user_id = $this->MemberId();
//        $user_id = 1;
        $get = $this->request->get();
        $order_id = $get['order_id'];
        // 判断订单是否存在以及是否是该用户的订单
        $order = OrderModel::where('uid', $user_id)
            ->where('id', $order_id)
/*            ->field([
                'id',
                'order_sn', // 订单号
                'create_time', // 下单时间
                'goods_price', // 订单价格
                'price',   // 实际价格
                'dispatch_price', // 运费
                'discount_price',])*/
            ->find();
        empty($order) && $this->error('订单不存在');
        // 返回订单字段
//        $order->   //折扣价格
        $order->address;
        $order->goods;
        $this->success('返回订单成功', $order);

    }


    // 订单列表 get status
    public function order_list()
    {
        $user_id = $this->MemberId();
//        $user_id = 1;
        $get = $this->request->get();
        $request_status = isset($get['status'])? $get['status'] : null ;
        $order_list = OrderModel::where('uid', $user_id)->select();
        if(array_key_exists($request_status, OrderModel::STATUS_ARRAY)){
            $order_list = OrderModel::where('uid', $user_id)
                ->where('status', $request_status)
                ->order('id', 'desc')
                ->paginatefront($get)
                ->select;
        }
        $this->success('请求成功', ['order_list'=>$order_list, 'status_array'=>OrderModel::STATUS_ARRAY]);
    }

    // 订单状态
    public function order_status()
    {
//        $user_id = $this->MemberId();
        $user_id = 1;
        $status = OrderModel::STATUS_ARRAY;
        $this->success('请求成功', ['status'=>$status]);
    }


    // 支付类型
    public function pay_type()
    {
//        $user_id = $this->MemberId();
        $user_id = 1;
        $pay_type = OrderModel::PAY_TYPE_ID;
        $this->success('请求成功', ['pay_type'=>$pay_type]);
    }




}