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
use Complex\Exception;

class Goods extends TimeModel
{
    protected $deleteTime = 'delete_time';



    public function dispatchObj(){
        return $this->belongsTo('app\common\model\Dispatch', 'dispatch');
    }

    public function carts(){
        return $this->hasMany('app\common\model\Cart', 'goods_id');
    }

    public function favors(){
        return $this->hasMany('app\common\model\GoodsFavor', 'goods_id');
    }

    public function setIsHotAttr($value){

        if(!empty($value)){
            return 1;
        }
        return 0;
    }

    public function setIsNewAttr($value){
//        print_r(222222);
//        exit();
        if(!empty($value)){
            return 1;
        }
        return 0;
    }

    public function setIsDiscountAttr($value){
//        print_r(333333);
//        exit();
        if(!empty($value)){
            return 1;
        }
        return 0;
    }

    public function getDeductionRateAttr($value){
        return $value*100;
    }

    // 判断商品属性是否存在并返回
    public function isset_description($datas){
        if(empty($datas)){
            return false;
        }
        if(isset($datas['title']) && isset($datas['value'])){
            $goods_description = json_decode($this->description, true);
            foreach ($goods_description as $item){
                if ($item['title'] == $datas['title'] && $item['value'] == $datas['value']){
                    return [['title'=>$item['title'], 'value'=>$item['value']]];
                }
            }
            return false;
        }
        $result = [];
        $count = 0;
        foreach ($datas as $item){
            if (!isset($item['title']) || !isset($item['value'])){
                return false;
            }
            $goods_description = json_decode($this->description, true);
            foreach ($goods_description as $des){
                if ($item['title'] == $des['title']){
                    // 判断value是否是数组
//                        if (is_array($item['value'])){
//                            if ($item['title'] == $des['title'] && in_array($des['value'], $item['value'])){
//                                $result[] = ['title'=>$des['title'], 'value'=>$des['value']];
//                            }
//                        }else{
                    if ($item['value'] == $des['value']){
                        $result[] = ['title'=>$des['title'], 'value'=>$des['value']];
//                            }
                    }
                }
            }
        }
        if(count($result) != count($datas)){
            return false;
        }
        return $result;
    }

    // 计算积分抵扣 用户  积分列表  $msg[1:完全抵扣2:不完全抵扣 ，0 积分余额为0，-1：积分数据不存在]
    public function calculate_credit(Member $user, array $credit_type_array, $goods_num=1, $use_deduction=1){
        $msg = -1;
        $result = ['msg'=>$msg, 'credit_type_array'=>$credit_type_array];
        $credit_type = CreditType::find($this->deduction);
        if (!$credit_type){
            return $result;
        }
        $user_credit = $user->getAttr($credit_type->value);
        // 如果用户积分大于0 则能够抵扣
        if ($user_credit > 0){
            // 完全抵扣所需积分
            $need_credit =  round($this->deduction_amount / round($this->deduction_rate/100,2), 2) * $goods_num;
//            $need_credit =  $this->deduction_rate/100 ;
            // 如果积分够完全抵扣 扣除当前积分返回
            if ($user_credit >= $need_credit){
                $credit_amount = $need_credit;
                // 只有商品允许积分抵扣的时候才进行此操作 (因为不需要计算不能积分抵扣的商品，)
                if($use_deduction === 1 && $this->deduction_status === 1) {
                    $user->setAttr($credit_type->value, $user->getAttr($credit_type->value) - $need_credit);
                }
//                $credit_type_array[$credit_type->value] = isset($credit_type_array[$credit_type->value]) ? $credit_type_array[$credit_type->value] + $credit_amount : $credit_amount;
                $msg = 1;
                $could_amount = $this->deduction_amount * $goods_num;
            }else{ // 不够则全部扣除并计算多少积分
                $credit_amount = $user_credit;
                // 积分能够抵扣的金额
                $could_amount = round($user_credit * round($this->deduction_rate/100,2), 2);
                if($use_deduction === 1 && $this->deduction_status === 1) {
                    $user->setAttr($credit_type->value, 0);
                }
                $msg = 2;
            }
            // 只有商品允许积分抵扣的时候才进行此操作 (因为后续商品积分抵扣是根据这个来进行扣除)
//            if($use_deduction === 1) {
            if($use_deduction === 1 && $this->deduction_status === 1) {
                // 判断数组中是否存在这个玩意 存在 相加不存在赋值
                if (empty($credit_type_array[$credit_type->value])){
                    $credit_type_array[$credit_type->value] = ['amount'=>$credit_amount, 'title'=>$credit_type->title,
                        'id'=>$credit_type->id, 'could_amount'=>$could_amount];
                }else{
                    $credit_type_array[$credit_type->value]['amount'] = $credit_type_array[$credit_type->value]['amount'] + $credit_amount;
                    $credit_type_array[$credit_type->value]['could_amount'] = $credit_type_array[$credit_type->value]['could_amount'] + $could_amount;
                }
            }

        }else{
            $msg = 0;
            $credit_amount = 0;
            $could_amount = 0;
        }
        if ($this->deduction_status === 0 || $use_deduction===0){
            $credit_amount = 0;
            $could_amount = 0;
        }
        $this->credit_amount = $credit_amount;// 总抵扣使用的积分
        $this->transfer_amount = $could_amount;// 总商品积分抵扣的金额
//        $this->total_transfer_amount = $could_amount;// 总积分抵扣的金额
        $this->old_price = round($this->price, 2); // 扣除积分抵扣前商品价格
        $this->price = round($this->price * $goods_num - round($could_amount,2), 2); // 总扣除积分抵扣后商品价格
        $this->total_discount = $this->market_price * $goods_num - $this->price;
//        $this->credit_type_value = $credit_type->value; // 扣除积分抵扣后商品价格
//        $this->credit_type_value = $credit_type->value; // 扣除积分抵扣后商品价格
//        $this->credit_type_id = $credit_type->title; // 扣除积分抵扣后商品价格
//        $this->after_amount = ;// 出去抵扣后的金额
//        $this->deduction_amount = ;// 积分抵扣的金额
        $result = ['msg'=>$msg, 'credit_type_array'=>$credit_type_array];
        return $result;
    }


    // 计算积分抵扣 用户  积分列表  $msg[1:完全抵扣2:不完全抵扣 ，0 积分余额为0，-1：积分数据不存在]
    public function dont_calculate_credit(Member $user, array $credit_type_array, $goods_num=1){
        $msg = -1;
        $result = ['msg'=>$msg, 'credit_type_array'=>$credit_type_array];
        $credit_type = CreditType::find($this->deduction);
        if (!$credit_type){
            return $result;
        }
        $user_credit = $user->getAttr($credit_type->value);
        // 如果用户积分大于0 则能够抵扣
        if ($user_credit > 0){
            // 完全抵扣所需积分
            $need_credit =  round($this->deduction_amount / round($this->deduction_rate/100,2), 2) * $goods_num;
//            $need_credit =  $this->deduction_rate/100 ;
            // 如果积分够完全抵扣 扣除当前积分返回
            if ($user_credit >= $need_credit){
                $credit_amount = $need_credit;
                // 只有商品允许积分抵扣的时候才进行此操作 (因为不需要计算不能积分抵扣的商品，)
                if($this->deduction_status === 1) {
                    $user->setAttr($credit_type->value, $user->getAttr($credit_type->value) - $need_credit);
                }
//                $credit_type_array[$credit_type->value] = isset($credit_type_array[$credit_type->value]) ? $credit_type_array[$credit_type->value] + $credit_amount : $credit_amount;
                $msg = 1;
                $could_amount = $this->deduction_amount * $goods_num;
            }else{ // 不够则全部扣除并计算多少积分
                $credit_amount = $user_credit;
                // 积分能够抵扣的金额
                $could_amount = round($user_credit * round($this->deduction_rate/100,2), 2);
//                $could_amount = round($user_credit / round($this->deduction_rate/100,2), 2);
                if($this->deduction_status === 1) {
                    $user->setAttr($credit_type->value, 0);
                }
                $msg = 2;
            }
            // 只有商品允许积分抵扣的时候才进行此操作 (因为后续商品积分抵扣是根据这个来进行扣除)
            if($this->deduction_status === 1) {
                // 判断数组中是否存在这个玩意 存在 相加不存在赋值
                if (empty($credit_type_array[$credit_type->value])){
                    $credit_type_array[$credit_type->value] = ['amount'=>$credit_amount, 'title'=>$credit_type->title,
                        'id'=>$credit_type->id, 'could_amount'=>$could_amount];
//                        'id'=>$credit_type->id, 'could_amount'=>$could_amount * $goods_num];
                }else{
                    $credit_type_array[$credit_type->value]['amount'] = $credit_type_array[$credit_type->value]['amount'] + $credit_amount;
                    $credit_type_array[$credit_type->value]['could_amount'] = $credit_type_array[$credit_type->value]['could_amount'] + $could_amount;
                }
            }

        }else{
            $msg = 0;
        }
        $this->credit_amount = 0;// 总抵扣使用的积分
        $this->transfer_amount = 0;// 总商品积分抵扣的金额
        $this->old_price = round($this->price, 2); // 扣除积分抵扣前商品价格
        $this->price = round($this->price * $goods_num, 2); // 总扣除积分抵扣后商品价格
        $this->total_discount = $this->market_price * $goods_num - $this->price;
        $result = ['msg'=>$msg, 'credit_type_array'=>$credit_type_array];
        return $result;
    }

}