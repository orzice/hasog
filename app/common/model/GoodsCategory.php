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
use think\facade\Db;
use think\Model;
use think\model\concern\SoftDelete;

class GoodsCategory extends TimeModel
{

    use SoftDelete;
    const ALLOW_FIELDS = ['goods_id', 'category_id', 'category_ids',  'delete_time'];
    protected $deleteTime = 'delete_time';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $defaultSoftDelete = null;
    protected $name = 'goods_category';



    public static function goods_save($category_id){

    }


    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}