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
// | Author：Orzice(小涛)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:22:57
// +----------------------------------------------------------------------

namespace app\common\model;


use app\common\model\TimeModel;
use think\Model;

//use think\Collection;

class Order extends TimeModel
{


    protected $type = [
            'finish_time'=> 'timestamp: Y-m-d H:i:s',
            'pay_time'=> 'timestamp: Y-m-d H:i:s',
            'send_time'=> 'timestamp: Y-m-d H:i:s',
            'cancel_time'=> 'timestamp: Y-m-d H:i:s',
            'cancel_pay_time'=> 'timestamp: Y-m-d H:i:s',
            'cancel_send_time'=> 'timestamp: Y-m-d H:i:s',
        ];

    protected $deleteTime = 'delete_time';
    const STATUS_ARRAY = [-3 => '已退款', -2 => '申请退款', -1 => '已取消', 0 => '待付款', 1 => '已付款', 2 => '已发货', 3 => '已完成', 4=>'线下待审核'];
    const PAY_TYPE_ID = [
            1=> '微信支付',
            2=> '支付宝支付',
            3=> '线下支付',
            4=> '余额支付',
        ];

    const PAY_TYPE_FRONT = [
            ['id'=>1,'name'=> '微信支付','icon'=>'/static/common/images/wechat.png'],
            ['id'=>2,'name'=> '支付宝支付','icon'=>'/static/common/images/ali.png'],
            ['id'=>3,'name'=> '线下支付','icon'=>'/static/common/images/xianxia.png'],
            ['id'=>4,'name'=> '余额支付','icon'=>'/static/common/images/balance.png'],
        ];

    const ALLOW_FIELDS = [
            'change_price',
            'change_dispatch_price',
            'merchant_remark',
            'express_code',
            'express_company_name',
            'express_sn',
            'delete_time',
            'price',
        ];

    /**
     * 生成唯一单号
     *
     * @param $prefix //前缀一般为两个大写字母
     * @param string $field //字段不为 order_sn 时需要参数field
     * @param int $length //日期后随机数长度
     * @param bool $numeric //受否为纯数字
     * @return string
     */
    public static function createOrderSn($prefix, $length = 6, $numeric = true)
    {
        $orderSn = createNo($prefix, $length, $numeric);
        if (!empty(self::where('order_sn', $orderSn)->find())) {
            $orderSn = self::createOrderSn($prefix, $length, $numeric);
        }
        return $orderSn;
    }

    public function member()
    {
        return $this->belongsTo('app\common\model\Member', 'uid');
    }

    public function address()
    {
        return $this->hasOne('app\common\model\OrderAddress', 'order_id', 'id');
    }

    public function goods()
    {
        return $this->hasMany('app\common\model\OrderGoods', 'order_id', 'id');
    }

    public function order_refund()
    {
        return $this->hasMany('app\common\model\OrderRefund', 'order_id', 'id');
    }

    public function getISVirtualAttr($value)
    {
        return $value === 0 ? '否' : '是';
    }


    public function getCommentStatusAttr($value)
    {
        return $value === 0 ? '未评论' : '已评论';
    }

    public function generate_goods(&$goods_objs, $use_deduction){
        $goods_array = [];
        // 总计使用积分,总计兑换的余额
        $user = $this->user;
//        $total_credit_amount = 0;
//        $total_transfer_amount = 0;
        foreach ($goods_objs as &$goods_item){
            $goods = $goods_item['goods_obj'];
            $option = $goods->option;
            $array_item = [
                'goods_id'=> $goods->id,
                'total'=> $goods_item['goods_num'],
//                'price'=> $goods->price,
                'price'=> $goods->price * $goods_item['goods_num'],
                'goods_sn'=> $goods->goods_sn,
                'thumb'=> $goods->thumb,
                'title'=> $goods->title,
                'payment_amount'=> $goods->price * $goods_item['goods_num'],
                'goods_price'=> $goods->price,
                'deduction'=> $goods->deduction,
                'deduction_rate'=> $goods->deduction_rate,
                'deduction_most_amount'=> $goods->deduction_amount,
                'deduction_status'=> $goods->deduction_status,
//                'deduction_amount'=> $goods->marcket_price - $goods->price,
                'goods_option_title'=> $goods->sku,
                'goods_market_price'=> $goods->marcket_price * $goods_item['goods_num'] ,
                'goods_cost_price'=> $goods->cost_price * $goods_item['goods_num'] ,
                'goods_option'=> json_encode($option),
                'create_time'=> time(),
            ];
            if ($use_deduction === 1 && $goods->deduction_status === 1){
                $array_item['credit_amount'] = $goods->credit_amount; //使用积分数量
                $array_item['deduction_amount'] = $goods->transfer_amount; // 积分抵扣的总金额
                $array_item['is_deduction'] = 1; // 是否使用抵扣
                $array_item['price'] = $goods->old_price * $goods_item['goods_num']; // 商品未抵扣应得总价
                $array_item['goods_price'] = $goods->old_price; // 商品快照单价
                $array_item['payment_amount'] = $goods->price; // 支付价格(抵扣后价格)
            }
            // 是否减库存
            $goods_array[] = $array_item;
            if ($goods_item['goods_obj']->reduce_stock_method === 0){
                $goods->stock -= $goods_item['goods_num'];
//                $goods->show_sales += $goods_item['goods_num'];
                $goods->real_sales += $goods_item['goods_num'];
//                $goods->virtual_sales += $goods_item['goods_num'];
                $goods->allowField(['stock', 'real_sales'])->save();
            }
        }
        return $this->goods()->saveAll($goods_array);
    }

    public function generate_pintuan_goods($goods_item){
//        $goods_array = [];
//        foreach ($goods_objs as &$goods_item){
            $goods = $goods_item['goods_obj'];
            $option = $goods->option;
            $goods_array[] = [
                'goods_id'=> $goods->id,
                'total'=> $goods_item['goods_num'],
                'type' => 1,  // 类型为拼团类型
                'price'=> $goods->price, //真实价格
                'goods_sn'=> '', //商品码
                'thumb'=> $goods->pic,   // 商品图片
                'title'=> $goods->title,  // 商品标题
                'goods_price'=> $goods->price,  // 快照价格
                'payment_amount'=> 0, //实际支付总金额
                'deduction_amount'=> 0, // 优惠总金额
                'goods_option_title'=> '', // 规格标题
                'goods_market_price'=> 0, // 商品总市场价
                'goods_cost_price'=> 0, //商品成功总价
                'goods_option'=> '',  // 商品规格
            ];
//        }
        return $this->goods()->saveAll($goods_array);
    }

    public function generate_address($address_obj){
        $data = [
            'order_id'=> $this->id,
            'address'=> $address_obj['area'],
            'mobile'=> $address_obj['connect_mobile'],
            'realname'=> $address_obj['name'],
            'province_id'=> $address_obj['province_id'],
            'city_id'=> $address_obj['city_id'],
            'district_id'=> $address_obj['district_id'],
            'street_id'=> $address_obj['street_id'],
            'note'=> $address_obj['note'],
        ];
        $order_address = new OrderAddress($data);
        return $order_address;
    }

    public function address_string(){
        $address = $this->address;
        if (!empty($address)){
            $address->area_name();
        }
        return $address;
    }

    public static function remove_repetition($goods_data){
        $ids = [];
        $data_result = [];
        $result = ['is_success'=>false, 'data'=>[]];

        foreach ($goods_data as $item){
            $goods_id = isset($item['goods_id']) && is_numeric($item['goods_id']) ? $item['goods_id']: null;
            $goods_num = isset($item['goods_num']) && is_numeric($item['goods_num']) ? $item['goods_num']: null;
            $description = isset($item['description']) && is_array($item['description']) ? $item['description']: null;
            if(empty($goods_id) || empty($goods_num) || empty($description)) {
                $result['msg'] = '商品信息有误';
                return $result;
            }
            // goods_is 已经存在 判断是否存在同一规格
            if(key_exists($goods_id, $ids)){
                // 设立标记判断是否存在
                $is_this = true;
                foreach ($ids[$goods_id] as &$goods_description){
                    if(count($description) == count($goods_description['description'])){
                        foreach ($description as $des){
                            if(!in_array($des, $goods_description['description'])){
                                $is_this = false;
                                break;
                            }
                        }
                        // 已经存在 只需加上数量
                        if($is_this){
                            $goods_description['goods_num'] += $goods_num;
                            break;
                        }
                    }
                }
                $is_this===false && $ids[$goods_id][] = ['goods_num'=> $goods_num, 'description'=>$description];
            }else{ // 不存在 则添加至ids
                $ids[$goods_id] = [['goods_num'=> $goods_num, 'description'=>$description]];
            }
        }
        foreach ($ids as $k=>$v){
            foreach ($v as $item_data){
                $data_result[] = ['goods_id'=>$k, 'goods_num'=> $item_data['goods_num'], 'description'=>$item_data['description']];
            }
        }
        return ['is_success'=>true, 'msg'=>'获取商品信息成功', 'data'=>$data_result];
    }
}