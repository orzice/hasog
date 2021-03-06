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

class OrderGoods extends TimeModel
{
    protected $deleteTime = 'delete_time';
	public function orderbelong()
	{
		return $this->belongsTo('app\common\model\Order','order_id');
	}

	public function goods()
	{
		return $this->belongsTo('app\common\model\Goods','goods_id');
	}

    public function merge_options(){
        $description = json_decode($this->goods_option, true);
        $description_array = [];
        $save_description = [];
//        if (!empty($description)){
        foreach ($description as $item){
            if (in_array($item['title'], $description_array)){
                $save_description[array_search($item['title'],$description_array)]['value'][]= $item['value'];
            }else {
                $save_description[] = ['title'=> $item['title'], 'value'=>[$item['value']]];
                $description_array[] = $item['title'];
            }
        }
        $this->goods_option = $save_description;
//        }
//        $this->goods_option = [];
    }

}