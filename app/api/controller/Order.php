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
use app\common\model\AdminsPayment;
use app\common\model\CreditType;
use app\common\model\Dispatch;
use app\common\model\DispatchData;
use app\common\model\FinaceBalancesub;
use app\common\model\Member;
use app\common\model\MemberAddress;
use app\common\model\FinaceOfflinepayment;
use app\common\model\Goods;
use app\common\model\Order as OrderModel;

use app\common\model\OrderPay;
use app\common\model\PayType;
use Carbon\Traits\Test;
use think\Exception;
use think\facade\Config;
use think\facade\Db;
use think\facade\Event;

class Order extends ApiController
{

    // 生成订单请求
    public function add_order()
    {
        $post = $this->request->post();
        $user_id = $this->MemberId();
        $user = Member::where('state', '0')->find($user_id);
        empty($user) && $this->error('用户数据错误');
        $order_sn = OrderModel::createOrderSn('AC');
        $goods_price = 0;
        $discount_price = 0;
        $order_goods_price = 0;
        $goods_total = 0;
        $cost_amount = 0;
        // 是否使用积分抵扣 默认否
        $is_deduction = isset($post['is_deduction']) ? $post['is_deduction'] : false;
        // 初始化 订单商品列表 地址id  重量 运费 等数据
        $goods_data = isset($post['goods_data']) ? $post['goods_data'] : [];
        $member_remark = isset($post['member_remark']) ? $post['member_remark'] : '';
        $request_address = isset($post['address_id']) ? $post['address_id'] : null;

        $request_address = $user->address()->where('id', $request_address)->find();
        if (empty($request_address)){
            $this->error("收货地址选择有误");
        }
        empty($request_address) && $this->error('没有收货地址请先添加收货地址');
        $weight = 0;
        $dispatch_price = 0;
        $goods_objs = [];

        // goods_data 去重
        $result = OrderModel::remove_repetition($goods_data);
        if($result['is_success']){
            $goods_data = $result['data'];
        }else {
            $this->error($result['msg']);
        }
        // 初始化积分抵扣数据
        $credit_type_array = [];
        // 计算 重量运费 等数据
        foreach ($goods_data as $goods_item) {
            $rule = [
                'goods_id|商品id' => 'require|number',
                'goods_num|商品数量' => 'number|between: 1,999999',
            ];
            $validate = $this->validate($goods_item, $rule);
            //验证失败
            if ($validate !== true) {
                return api_return(0, '商品数量只能为正整数');
            }
            !isset($goods_item['goods_id']) && $this->error('部分商品不存在或已下架');
            $goods_obj = Goods::where('id', $goods_item['goods_id'])
                ->where('status', 1)->find();
            empty($goods_obj) && $this->error('部分商品不存在或已下架');
            // 是否使用抵扣积分
            if($is_deduction === 1){
//                $goods_obj->use_deduction = 1;
                $use_deduction = 1;
                $credit_result = $goods_obj->calculate_credit($user, $credit_type_array,$goods_item['goods_num']);
                $credit_type_array = $credit_result['credit_type_array'];
                if ($credit_result === -1){
                    $this->error('商品积分类型已下架');
                }
                // 如果积分数据不存在则不能使用积分请联系技术支
//                if (in_array($credit_result['msg'], [1,2])){
//                if (in_array($credit_result['msg'], [1,2])){
//                }
            }else{
                $use_deduction = 0;
                $credit_result = $goods_obj->calculate_credit($user, $credit_type_array, $goods_item['goods_num'], 0 );
                $credit_type_array = $credit_result['credit_type_array'];
            }


            // 优惠价计算
//            $discount_price += ($goods_obj->market_price - $goods_obj->price) * $goods_item['goods_num'];
//            $discount_price += $goods_obj->total_discount;
            $discount_price += $goods_obj->transfer_amount;

            // 商品价总计
            $order_goods_price += ($goods_obj->market_price) * $goods_item['goods_num'];
//            $goods_price += round($goods_obj->price * $goods_item['goods_num'],2);
            // 折扣价后总计
            $goods_price += round($goods_obj->price,2);

//            $discount_price += ($goods_obj->market_price - $goods_obj->price) * $goods_item['goods_num'];
//            $order_goods_price += ($goods_obj->market_price) * $goods_item['goods_num'];
            // 库存处理
            $goods_obj->stock === 0 && $this->error($goods_obj->title . '暂时无货');
            $goods_obj->stock < $goods_item['goods_num'] && $this->error($goods_obj->title . '拍下数量大于库存');


            // 计算商品价格
//            $goods_price += $goods_obj->price * $goods_item['goods_num'];

            $goods_description = isset($goods_item['description']) ? $goods_item['description']: null;
            $option = $goods_obj->isset_description($goods_description);
            if($option === false){
                $this->error('商品规格选择错误或改规格已下架');
            }
            $goods_obj->option = $option;

            $goods_objs[] = ['goods_obj' => $goods_obj, 'goods_num' => $goods_item['goods_num']];
            $goods_total += $goods_item['goods_num'];
            // 成本价总计
            $cost_amount += $goods_obj['cost_price'] * $goods_item['goods_num'];
            // 计算重量
            $goods_weight = $goods_obj->weight * $goods_item['goods_num'];
            $weight += $goods_weight;
            // 计算运费
            $dispatch_obj = $goods_obj->dispatch_obj;
            $dispatch_datas = DispatchData::where('did', $dispatch_obj->id)->order('display_order')->select()->toArray();
            // 选出 收货地址 配对的 配送逻辑 并计算运费
            // 全国的优先权最小   其他的按照 优先权
            $goods_dispatch = 0;
            if (isset($request_address)) {
                // Orzice 重写配送费计算逻辑
                $yes_dis = false;
                $yes_dis_lj = [];

                for ($t=0; $t < count($dispatch_datas); $t++) {
                    $disp = $dispatch_datas[$t];
                    $disp_add = json_decode($disp['areas'],true);

                    $yes_dq = '';
                    //全国权限最低
                    if ($disp['areas_txt'] == '全国') {
                        if (!$yes_dis) {
                            $yes_dis = true;
                            $yes_dis_lj = $disp;
                        }
                    }else{
                        for ($s=0; $s < count($disp_add); $s++) {
                            $disp_addp = $disp_add[$s];
                            $disp_addp_lv = $disp_addp['lv'];

                            if ($disp_addp_lv == 0) {
                                $disp_addp_id = $request_address['province_id'];
                            }else if($disp_addp_lv == 1) {
                                $disp_addp_id = $request_address['city_id'];
                            }else if($disp_addp_lv == 2) {
                                $disp_addp_id = $request_address['district_id'];
                            }else if($disp_addp_lv == 3) {
                                $disp_addp_id = $request_address['street_id'];
                            }else{
                                $disp_addp_id = '';
                            }
                            if ($disp_addp_id == '' || $disp_addp_id == 0) {
                                break;
                            }
                            $yes_dq .= $disp_addp['name'];

                            if ($disp_addp['id'] == $disp_addp_id) {
                                $yes_dis = true;
                                $yes_dis_lj = $disp;
                            }
                        }
                    }

                    //黑名单
                    if ($disp['state'] == 1 && $yes_dis) {
                        $this->error($yes_dq.' 该区域禁止配送！');
                    }
                }
                if (!$yes_dis) {
                    $this->error('请更换收货地址，此收货地址不能发货！');
                }
                // 计算运费
                if (count($yes_dis_lj) !== 0) {
                    //默认价格
                    $dispatch_price += $yes_dis_lj['first_piece_price'];
                    if ($goods_item['goods_num'] > $yes_dis_lj['first_piece']) {
                        $sl = $goods_item['goods_num'] - $yes_dis_lj['first_piece'];
                        $zsl = $sl / $yes_dis_lj['another_piece'];
                        //不是整数则加一
                        if(!is_int($zsl)){
                            $zsl = intval($zsl)+1;
                        }
                        $dispatch_price += $zsl * $yes_dis_lj['another_piece_price'];
                    }

                }

            }
        }
        // 要返回的数据
        $price = $dispatch_price + $goods_price;
        $order_data = [
            'uid' => $user_id,
            'order_sn' => $order_sn,
            'status' => 0,
            'dispatch_price' => $dispatch_price,
            'goods_price' => $goods_price,       // 总现价
            'goods_total' => $goods_total,       // 总计数量
            'discount_price' => $discount_price, // 总折扣
            'order_goods_price' => $order_goods_price, // 总原价
            'price' => $price,                      // 总价(带运费)
            'cost_amount' => $cost_amount,
            'member_remark' => $member_remark,
            'is_deduction' => $use_deduction
        ];
        try {
            $msg = true;
            $order = new OrderModel($order_data);
            $order_save = $order->save();
            Db::startTrans();
            // 积分扣除
            $new_user = Member::where('id', $user->id)->find($user->id);
            foreach ($credit_type_array as $credit_item=>$credit_item_value){
                if($new_user->getAttr($credit_item) >= $credit_item_value['amount']){
                    Member::where('id', $user->id)->dec($credit_item, $credit_item_value['amount'])->update();
                }else{
                    $msg = $credit_item_value['title'].'不足';
                    break;
                }
            }
            $order_address = $order->generate_address($request_address);
            $address_save = $order_address->save();
            $save_goods = $order->generate_goods($goods_objs, $use_deduction);
            if ($order_save === false || $address_save === false || $save_goods === false) {
                throw new \Exception('添加失败');
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $order->delete();
            $this->error('生成订单失败，请稍后重试');
        }
        if($msg!==true){
            $this->error($msg);
        }
        $this->success('生成订单成功', ['order_id'=>$order->id,'pay_type' => OrderModel::PAY_TYPE_FRONT,]);
    }


    // 订单生成页面
    public function cache_order()
    {
        $post = $this->request->post();
        $user_id = $this->MemberId();
        $user = Member::where('state', '0')->find($user_id);
        empty($user) && $this->error('用户数据错误');
        $order_sn = OrderModel::createOrderSn('AC');
        $goods_price = 0;
        $discount_price = 0;
        $order_goods_price = 0;
        $goods_data = isset($post['goods_data']) ? $post['goods_data'] : [];
        empty($goods_data) && $this->error('请提交商品');
        // 请求的收货地址
        $request_address = isset($post['address_id']) ? $post['address_id'] : null;
        // 是否使用积分抵扣 默认否
        $is_deduction = isset($post['is_deduction']) ? $post['is_deduction'] : false;
        $request_address = $user->address()->where('id', $request_address)->find();
        // 如果没选择收货地址
        if (empty($request_address)) {
            $default_address = $user->address()->where('is_default', 1)->find();
            if(empty($default_address)){
                $request_address = $user->address()->select()->first();
            }else {
                $request_address = $default_address;
            }
        }
        $weight = 0;
        $dispatch_price = 0;
        $goods_objs = [];

        // goods_data 去重
        $result = OrderModel::remove_repetition($goods_data);
        if($result['is_success']){
            $goods_data = $result['data'];
        }else {
            $this->error($result['msg']);
        }
        // 初始化积分抵扣数据
        $credit_type_array = [];
        // 计算 重量运费 等数据
        foreach ($goods_data as $goods_item) {// 操作商品信息
            $rule = [
                'goods_id|商品id' => 'require|number',
                'goods_num|商品数量' => 'require|number|between: 1,999999',
            ];
            $validate = $this->validate($goods_item, $rule);
            //验证失败
            if ($validate !== true) {
                $this->error('商品信息有误');
            }
            $goods_obj = Goods::where('id', $goods_item['goods_id'])
                ->where('status', 1)->hidden(['cost_price', 'reduce_stock_method', 'real_sales', 'virtual_sales'])->find();
            empty($goods_obj) && $this->error('部分商品不存在或已下架');
            // 折扣价计算
            // 是否使用抵扣积分
            if($is_deduction === 1){
                $credit_result = $goods_obj->calculate_credit($user, $credit_type_array, $goods_item['goods_num'], 1);
                $credit_type_array = $credit_result['credit_type_array'];
                if ($credit_result === -1){
                    $this->error('商品积分类型已下架');
                }
                // 如果积分数据不存在则不能使用积分请联系技术支
//                if (in_array($credit_result['msg'], [1,2])){
//                if (in_array($credit_result['msg'], [1,2])){
//                }
            }else{
                $credit_result = $goods_obj->dont_calculate_credit($user, $credit_type_array, $goods_item['goods_num']);
                $credit_type_array = $credit_result['credit_type_array'];
            }
/*            // 判断数组中是否存在这个玩意 存在 相加不存在赋值
            if (empty($credit_type_array[$goods_obj->credit_type_value])){
                $credit_type_array[$goods_obj->credit_type_value] = ['amount'=>$goods_obj->credit_amount * $goods_item['goods_num'], 'title'=>$goods_obj->credit_type_title,
                    'id'=>$goods_obj->credit_type_id, 'could_amount'=>$goods_obj->transfer_amount * $goods_item['goods_num']];
            }else{
                $credit_type_array[$goods_obj->credit_type_value]['amount'] = $credit_type_array[$goods_obj->credit_type_value]['amount'] + ($goods_obj->credit_amount * $goods_item['goods_num']);
                $credit_type_array[$goods_obj->credit_type_value]['could_amount'] = $credit_type_array[$goods_obj->credit_type_value]['could_amount'] + ($goods_obj->transfer_amount * $goods_item['goods_num']);
            }*/

            // 优惠价计算
//            $discount_price += ($goods_obj->market_price - $goods_obj->price) * $goods_item['goods_num'];
//            $discount_price += $goods_obj->total_discount;
            $discount_price += $goods_obj->transfer_amount;
            // 商品价总计
            $order_goods_price += ($goods_obj->market_price) * $goods_item['goods_num'];
//            $goods_price += round($goods_obj->price * $goods_item['goods_num'],2);
            // 折扣价后总计
            $goods_price += round($goods_obj->price,2);
            // 库存计算
            $goods_obj->stock === 0 && $this->error($goods_obj->title . '暂时无货');
            $goods_obj->stock < $goods_item['goods_num'] && $this->error($goods_obj->title . '拍下数量大于库存');



            // 商品规格拆分 及判断
            $goods_description = isset($goods_item['description']) ? $goods_item['description']: null;
            $option = $goods_obj->isset_description($goods_description);
            if($option === false){
                $this->error('商品规格选择错误，或该规格已下架');
            }
            $goods_obj->option = $option;

            $goods_objs[] = ['goods_obj' => $goods_obj, 'goods_num' => $goods_item['goods_num']];
            // 计算重量
            $goods_weight = $goods_obj->weight * $goods_item['goods_num'];
            $weight += $goods_weight;
            // 计算运费
            $dispatch_obj = $goods_obj->dispatch_obj;
            $dispatch_datas = DispatchData::where('did', $dispatch_obj->id)->order('display_order')->select()->toArray();
            // 选出 收货地址 配对的 配送逻辑 并计算运费
            // 全国的优先权最小   其他的按照 优先权
            $goods_dispatch = 0;
            if (isset($request_address)) {
                // Orzice 重写配送费计算逻辑
                $yes_dis = false;
                $yes_dis_lj = [];

                for ($t=0; $t < count($dispatch_datas); $t++) {
                    $disp = $dispatch_datas[$t];
                    $disp_add = json_decode($disp['areas'],true);

                    $yes_dq = '';
                    //全国权限最低
                    if ($disp['areas_txt'] == '全国') {
                        if (!$yes_dis) {
                            $yes_dis = true;
                            $yes_dis_lj = $disp;
                        }
                    }else{
                        for ($s=0; $s < count($disp_add); $s++) {
                            $disp_addp = $disp_add[$s];
                            $disp_addp_lv = $disp_addp['lv'];

                            if ($disp_addp_lv == 0) {
                                $disp_addp_id = $request_address['province_id'];
                            }else if($disp_addp_lv == 1) {
                                $disp_addp_id = $request_address['city_id'];
                            }else if($disp_addp_lv == 2) {
                                $disp_addp_id = $request_address['district_id'];
                            }else if($disp_addp_lv == 3) {
                                $disp_addp_id = $request_address['street_id'];
                            }else{
                                $disp_addp_id = '';
                            }
                            if ($disp_addp_id == '' || $disp_addp_id == 0) {
                                break;
                            }
                            $yes_dq .= $disp_addp['name'];

                            if ($disp_addp['id'] == $disp_addp_id) {
                                $yes_dis = true;
                                $yes_dis_lj = $disp;
                            }
                        }
                    }

                    //黑名单
                    if ($disp['state'] == 1 && $yes_dis) {
                        $this->error($yes_dq.' 该区域禁止配送！');
                    }
                }
                if (!$yes_dis) {
                    $this->error('请更换收货地址，此收货地址不能发货！');
                }
                // 计算运费
                if (count($yes_dis_lj) !== 0) {
                    //默认价格
                    $dispatch_price += $yes_dis_lj['first_piece_price'];
                    if ($goods_item['goods_num'] > $yes_dis_lj['first_piece']) {
                        $sl = $goods_item['goods_num'] - $yes_dis_lj['first_piece'];
                        $zsl = $sl / $yes_dis_lj['another_piece'];
                        //不是整数则加一
                        if(!is_int($zsl)){
                            $zsl = intval($zsl)+1;
                        }
                        $dispatch_price += $zsl * $yes_dis_lj['another_piece_price'];
                    }

                }

            }
            // 返回配送类型---
        }
        // 浮点数取两位小数
        $goods_price = round($goods_price, 2);
        $dispatch_price = round($dispatch_price, 2);
        // 要返回的数据
        $price = $dispatch_price + $goods_price;
        $request_address_id =null;
        !empty($request_address) && $request_address_id = $request_address->id;
        $credit_type_list = array_values($credit_type_array);
        $data = [
            'goods' => $goods_objs,
            'weight' => $weight,
            'check_address_id' => $request_address_id,
            'user_address' => $user->address_string(),
            'pay_type' => OrderModel::PAY_TYPE_FRONT,
            'dispatch_price' => $dispatch_price,
            'goods_price' => $goods_price,       // 总现价
            'discount_price' => $discount_price, // 总折扣价
            'order_goods_price' => $order_goods_price, // 总原价
            'price' => $price,
//            'credit_type_array' => $credit_type_array,  // 商品积分
//            'credit_type_list' => $credit_type_list,  // 商品积分
            'credit_type_array' => $credit_type_list,  // 商品积分
        ];
        $this->success('请求成功', $data);
    }


    // 支付订单
    public function pay_order()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null;
        $pay_type_id = isset($post['pay_type_id']) ? $post['pay_type_id'] : null;
        empty($order_id) && $this->error('订单不存在');
        !array_key_exists($pay_type_id, OrderModel::PAY_TYPE_ID) && $this->error('请选择正确的支付方式');
        $user_id = $this->MemberId();
        $user = Member::find($user_id);
        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)->find();
        empty($order) && $this->error('订单不存在');
        // 获取支付逻辑
        /**
         * $order->is_paid === 1;  // 获取支付结果
         * $order->pay_type_id = 1;
         **/
        // 付款减库存
        if ($order->status === 0) {
            // 订单的统一操作
            $order->status = 1;
            $order->pay_time = time();
            $order->pay_type_id = $pay_type_id;
            Db::startTrans();
            // 余额支付
            if($pay_type_id == 4) {
                // 此处应该有支付逻辑并更改支付id
//                if($pay_type_id == 4){
                if ($user->credit2 < $order->price){
                    $this->error('余额不足请充值');
                }
                // 生成账户余额明细 记录
                $balance_change = new FinaceBalancesub([
                    'uid'=> $user->id,
                    'balance'=> $user->credit2,
                    'state'=> 0,
                    'money'=> $order->price,
                ]);
//                $user->credit2 -= $order->price;
//                $user_save = $user->save();
                $user_save = Member::where('id', $user->id)->dec('credit2', $order->price)->update();
                $change_save = $balance_change->save();
//                if ($change_save === false || $user_save === false){
                if ($change_save === false){
                    Db::rollback();
                    $this->error('支付失败请稍后重试');
                }

            }
            // 线下支付
            elseif ($pay_type_id == 3){
                $rule = [
                    'thumb|付款图片' =>'require|url',
                    'pay_id|线下付款方式' =>'require|number',
                ];
                $validate = $this->validate($post, $rule);
                //验证失败
                if($validate !== true){
                    $this->error($validate);
                }
//                $pay_obj = AdminsPayment::where('id',$post['pay_id'])->where('state',1)->find();
//                empty($pay_obj) && $this->error('该付款方式暂不可用');
                $order->status = 4;
                // 生成线下审核
                $balance_change = new FinaceOfflinepayment([
                    'uid'=> $user->id,
                    'order_id'=> $order->id,
                    'order_sn'=> $order->order_sn,
                    'money'=> $order->price,
                    'a_state'=> 1,
                    'state'=> 0,
                    'pay_id'=> $post['pay_id'],
                    'thumb'=> $post['thumb'],
                    'create_time'=>time(),
                ]);
                $change_save = $balance_change->save();
                if ($change_save === false){
                    Db::rollback();
                    $this->error('支付失败请稍后重试');
                }
            }
            else {
                $this->error('暂时只支持余额付款和线下支付');
            }
            $this->PluginApiCD('pay_order'.$user_id);

            // 记录的统一操作
            try {
                // 生成支付记录
                $order_pay = new OrderPay([
                    'uid'=> $user->id,
                    'order_id'=> $order->id,
                    'order_sn'=> $order->order_sn,
                    'status'=> 1,
                    'pay_type_id'=> $pay_type_id,
                    'pay_time'=> time(),
                    'amount'=> $order->price,
                ]);
                $pay_save = $order_pay->save();
                // 商品是否是支付时扣除库存 如果是则扣除
                $goods_array = $order->goods;
                $goods_result = true;
                foreach ($goods_array as &$goods_obj) {
                    $goods = $goods_obj->goods;
                    if ($goods->reduce_stock_method === 1) {
                        $goods->stock -= $goods_obj->total;
//                        $goods->show_sales += $goods_obj->total;
                        $goods->real_sales += $goods_obj->total;
//                        $goods->virtual_sales += $goods_obj->total;
                        $goods_result = $goods->save();
                        if (!$goods_result) {
                            break;
                        }
                    }
                }

                $save = $order->save();
                if ($save === false || $goods_result === false || $pay_save === false || $change_save === false  ) {
                    throw new \Exception('添加失败');
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $this->error('支付失败请稍后重试');
                // $this->tuikuan() // 退款操作
            }
            event('OrderPay',$order_id);
            $this->success('支付成功');

        }else{
            $this->error('该订单当前状态不能付款');
        }


    }

    // 确认收货
    public function confirm_receipt()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null;
        empty($order_id) && $this->error('订单不存在');
        $user_id = $this->MemberId();
        $user = Member::find($user_id);
        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)->find();
        empty($order) && $this->error('订单不存在');
        $order->status = 3;
        $order->finish_time = time();
        try {
            event('OrderReceiving',$order_id);
            $save = $order->save();
        } catch (\Exception $e) {
            $this->error('确认收货失败请稍后重试');
        }
        if ($save) {
            $this->success('确认收货成功');
        }
        $this->error('确认收货失败请稍后重试');
    }

    // 退款申请
    public function apply_refund()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null;
        empty($order_id) && $this->error('订单不存在');
        $user_id = $this->MemberId();
        $user = Member::find($user_id);
        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)
            ->where('type', 0)
            ->find();
        empty($order) && $this->error('订单不存在或该订单类型不支持退款');
        if (in_array($order->status, [1, 2, 3,])) {
            $order->status = -2;
            Db::startTrans();
            try {
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
                if ($save_refund === false || $save === false) {
                    throw new \Exception('添加失败');
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $this->error('申请失败');
            }
            event('OrderRefund',$order_id);
            $this->success('申请成功');
        }
        $this->error('该订单当前状态不能申请退款');
    }


    // 取消订单
    public function cancel_order()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null;
        empty($order_id) && $this->error('订单不存在');
        $user_id = $this->MemberId();
        $user = Member::find($user_id);

        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)->find();
        empty($order) && $this->error('订单不存在');

        if ($order->status === 0 ) {
            $order->status = -1;
            try {
                // 积分退款
                $goods_objs = $order->goods;
                foreach ($goods_objs as $goods_obj){
                    if ($goods_obj->is_deduction == 1 ){
                        $credit_type = CreditType::find($goods_obj->deduction);
                        Member::where('id', $user->id)->inc($credit_type->value, $goods_obj->credit_amount)->update();
                    };
                }
                $save = $order->save();
                if ($save === false) {
                    throw new \Exception('取消订单失败');
                }
            } catch (\Exception $e) {
                $this->error('取消订单失败');
            }
            event('OrderDelete',$order_id);
            $this->success('取消订单成功');
        }
        $this->error('该订单当前状态不能申请退款');
    }

    // 删除订单
    public function delete_order()
    {
        $post = $this->request->post();
        $order_id = isset($post['order_id']) ? $post['order_id'] : null;
        empty($order_id) && $this->error('订单不存在');
        $user_id = $this->MemberId();
        $user = Member::find($user_id);
        $order = OrderModel::where('uid', $user_id)->where('id', $order_id)->find();
        empty($order) && $this->error('订单不存在');
        if ($order->status === -1 || $order->status === 3) {
            try {
                $save = $order->delete();
                if ($save === false) {
                    throw new \Exception('删除订单失败');
                }
            } catch (\Exception $e) {
                $this->error('删除订单失败');
            }
            $this->success('删除订单成功');
        }
        $this->error('该订单当前状态不能删除订单');
    }

    // 用户地址列表及选择
    public function user_address()
    {
        $user_id = $this->MemberId();
        $user_address = MemberAddress::where('uid', $user_id)->select()
            ->hidden(['create_time', 'update_time', 'delete_time'])
            ->toArray();
        $this->success('请求成功', $user_address->toArray());
    }

    // 订单详情 get order_id
    public function order_detail()
    {
        $user_id = $this->MemberId();
        $get = $this->request->get();
        $order_id = isset($get['order_id']) ? $get['order_id'] : null;
        (empty($order_id) || !is_numeric($order_id)) && $this->error('该订单不存在');
        // 判断订单是否存在以及是否是该用户的订单
        $order = OrderModel::where('uid', $user_id)
            ->where('id', $order_id)
            ->find();
        empty($order) && $this->error('订单不存在');
        // 返回订单字段
        $order->address;
        // 判断所有的积分
        $credit_type_array = [];
        if ($order->is_deduction){
            $goods_objs = $order->goods;
            foreach ($goods_objs as $goods_obj){
                if($goods_obj->is_deduction === 1){
                    $credit_type = CreditType::find($goods_obj->deduction);
                    $goods_obj->credit_title = $credit_type->title;
                    if (empty($credit_type_array[$credit_type->value])){
                        $credit_type_array[$credit_type->value] = ['amount'=>$goods_obj->credit_amount, 'title'=>$credit_type->title,
                            'id'=>$credit_type->id, 'could_amount'=>$goods_obj->deduction_amount];
                    }else{
                        $credit_type_array[$credit_type->value]['amount'] = $credit_type_array[$credit_type->value]['amount'] + $goods_obj->credit_amount;
                        $credit_type_array[$credit_type->value]['could_amount'] = $credit_type_array[$credit_type->value]['could_amount'] + $goods_obj->deduction_amount;
                    }
                }
            }
            $order->goods = $goods_objs;
        }else{
            $order->goods;
        }
        $order->credit_type_array = array_values($credit_type_array);

        $order->address_string();
//        $order->status = OrderModel::STATUS_ARRAY[$order->status];
//        $order->enable_refund = in_array($order->status, [1,2,3,]) ? true : false ;
        $order->enable_refund = in_array($order->status, [1,2,3]) && $order->type === 0  ? true : false ;
        $order->enable_cancel = $order->status === 0 ? true : false ;
        $order->enable_delete = in_array($order->status, [-1, 3]) ? true : false ;
        $this->success('返回订单成功', ['order' => $order, 'status_array' => OrderModel::STATUS_ARRAY,]);

    }


    // 订单列表 get status
    public function order_list()
    {
        $user_id = $this->MemberId();
//        $user_id = 1;
        $get = $this->request->get();
        $request_status = isset($get['status']) ? $get['status'] : null;
        $order_list = OrderModel::where('uid', $user_id)->order('id', 'desc')
            ->paginatefront($get)
            ->select();
        if (array_key_exists($request_status, OrderModel::STATUS_ARRAY)) {
//            if (!key_exists($request_status,[-3,-2])){
            if ($request_status != -1){
                $order_list = OrderModel::where('uid', $user_id)
                    ->where('status', $request_status)
                    ->order('id', 'desc')
                    ->paginatefront($get)
                    ->select();
            }else{
                $order_list = OrderModel::where('uid', $user_id)
                    ->whereIn('status', [-2, -3])
                    ->order('id', 'desc')
                    ->paginatefront($get)
                    ->select();
            }
        }
        foreach ($order_list as &$item) {
            $item->enable_refund = in_array($item->status, [1,2,3]) && $item->type === 0  ? true : false ;
            $item->enable_cancel = $item->status === 0 ? true : false ;
            $item->enable_delete = in_array($item->status, [-1, 3]) ? true : false ;
            $item->goods;
        }
        $this->success('请求成功', ['order_list' => $order_list, 'status_array' => OrderModel::STATUS_ARRAY]);
    }

    // 订单状态
    public function order_status()
    {
        $user_id = 1;
        $status = OrderModel::STATUS_ARRAY;
        $this->success('请求成功', ['status' => $status]);
    }

    // 支付类型
    public function pay_type()
    {
        $user_id = 1;
//        $pay_type = OrderModel::PAY_TYPE_FRONT;
//        $pay_type = [
//            ['id'=>3,'name'=> '线下支付','icon'=>'/static/common/images/xianxia.png'],
//        ];
        $pay_type = PayType::where('status', 1)->select();
        $this->success('请求成功', ['pay_type' => $pay_type]);
    }




}