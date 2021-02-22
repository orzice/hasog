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
// +----------------------------------------------------------------------


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

/**
 * 有关时间的模型
 * Class TimeModel
 * @package app\common\model
 */
class TimeModel extends Model
{

    /**
     * 自动时间戳类型
     * @var string
     */
    protected $autoWriteTimestamp = true;

    /**
     * 添加时间
     * @var string
     */
    protected $createTime = 'create_time';

    /**
     * 更新时间
     * @var string
     */
    protected $updateTime = 'update_time';

    /**
     * 软删除
     */
    use SoftDelete;
    protected $deleteTime = false;


//    public function scopePaginatefront($query, $page=1, $limit=10)
    public function scopePaginatefront($query, $get)
    {
//        $page = isset($get['page']) ? $get['page'] : 1;
        $page = isset($get['page']) ? $get['page'] : 0;
        $limit = isset($get['limit']) ? $get['limit'] : 15;
        if((is_numeric($page)) && is_numeric($limit)){
            $page = $page < 0 ? 0 : $page;
            if ($limit >=60){
                $limit=60;
            }
//            $offset = ($page-1) * $limit;
            $offset = $page === 0 ? 0 : $page * $limit;
//            $limit = $limit;
            return $query->limit($offset, $limit);
        }
        print_r(1);die();
        return $query->limit(0, 15);;
    }

}