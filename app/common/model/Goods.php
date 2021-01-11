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
//        print_r(111111);

//        exit();
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


}