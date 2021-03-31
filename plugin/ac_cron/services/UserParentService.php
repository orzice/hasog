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
// | DateTime：2021-02-21 14:16:19
// +----------------------------------------------------------------------
namespace HaSog\plugin\ac_cron\services;

use app\common\model\Member;
use app\common\service\ParentService;

/**
 * 用户相关计划任务
 */
class UserParentService
{
    public function handle()
    {
        $this->model = new Member();
        $time = time();
        $sql = $this->model->where('parent_ids_s',0)->limit(40)->select();
        if(count($sql) == 0){
            return;
        }
        
        foreach ($sql as $u) {
            $this->user($u);
        }

    }
    function user($user){
        $this->model = new Member();
        $data = new ParentService();
        if ($user['parent_ids_s'] !== 0) {
            return;
        }
        $parent_ids = $data->ParentInit($user['parent_id']);
        $this->model->where('id',$user['id'])->update(['parent_ids_s'=>1,'parent_ids'=>$parent_ids]);
        return;
    }
}
