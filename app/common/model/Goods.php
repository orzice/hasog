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

}