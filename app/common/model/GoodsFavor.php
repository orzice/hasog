<?php


namespace app\common\model;
use app\common\model\TimeModel;
use think\facade\Db;
use think\Model;

class GoodsFavor extends TimeModel
{
       public function goods(){
           return $this->belongsTo(Goods::class, 'goods_id', 'id');
       }
}