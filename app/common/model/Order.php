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
//use think\Collection;

class Order extends TimeModel
{

    const STATUS_ARRAY = [-2 => '申请退款', -1 => '已取消', 0 => '待付款', 1 => '已付款', 2 => '已发货', 3 => '已完成'];
    const MERCHANT_STATUS = [-1 => '已取消', 1 => '已付款', 2 => '已发货', 3 => '已完成'];
    const ORDER_ARRAY = [0 => '无需配送', 1 => '快递', 2 => '门店自提', 3 => '门店配送'];
    const ALLOW_FIELDS = [
//        'status',
        'change_price',
        'change_dispatch_price',
        'merchant_remark',
        'express_code',
        'express_company_name',
        'express_sn',
        'delete_time',
        'price'];

    /**
     * 生成唯一单号
     *
     * @param $prefix //前缀一般为两个大写字母
     * @param string $field //字段不为 order_sn 时需要参数field
     * @param int $length //日期后随机数长度
     * @param bool $numeric //受否为纯数字
     * @return string
     */
//    public static function createOrderSn($prefix, $field = 'order_sn', $length = 6, $numeric = true)
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

//    public function getStatusAttr($value)
//    {
//        return self::STATUS_ARRAY[$value];
//    }

    public function getISVirtualAttr($value)
    {
        return $value === 0 ? '否' : '是';
    }


    public function getCommentStatusAttr($value)
    {
        return $value === 0 ? '未评论' : '已评论';
    }

//    public static function generate_goods($goods_objs){
    public function generate_goods(&$goods_objs){
        $goods_array = [];
        foreach ($goods_objs as &$goods_item){
            $goods = $goods_item['goods_obj'];
            $goods_array[] = [
                'order_id'=> 1,
                'goods_id'=> $goods->id,
//                'goods_id'=> $goods->id,
                'total'=> $goods_item['goods_num'],
                'price'=> $goods->price,
                'goods_sn'=> $goods->goods_sn,
                'thumb'=> $goods->thumb,
                'title'=> $goods->title,
                'goods_price'=> $goods->price,
                'payment_amount'=> $goods->price,
                'deduction_amount'=> $goods->marcket_price - $goods->price,
                'goods_option_title'=> $goods->sku,
                'goods_market_price'=> $goods->marcket_price * $goods_item['goods_num'] ,
                'goods_cost_price'=> $goods->cost_price * $goods_item['goods_num'] ,
            ];
            // 是否减库存
            if ($goods_item['goods_obj']->reduce_stock_method === 0){
                $goods->stock -= 1;
            }
        }
        return $this->goods()->saveAll($goods_array);
    }

//    public static function generate_address($address_obj){
    public function generate_address($address_obj){
        $data = [
//            'order_id'=> $this->id,
            'address'=> $address_obj['area'],
            'mobile'=> $address_obj['connect_mobile'],
            'realname'=> $address_obj['name'],
            'province_id'=> $address_obj['province_id'],
            'city_id'=> $address_obj['city_id'],
            'district_id'=> $address_obj['district_id'],
            'street_id'=> $address_obj['street_id'],
            'note'=> $address_obj['note'],
        ];
//        return $data;
        $order_address = new OrderAddress($data);
        $this->address = $order_address;
    }


}