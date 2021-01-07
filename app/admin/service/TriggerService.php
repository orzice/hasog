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
// | DateTime：2020-12-31 18:18:44
// +----------------------------------------------------------------------

namespace app\admin\service;


use think\facade\Cache;

class TriggerService
{

    /**
     * 更新菜单缓存
     * @param null $adminId
     * @return bool
     */
    public static function updateMenu($adminId = null)
    {
        if(empty($adminId)){
            Cache::tag('initAdmin')->clear();
        }else{
            Cache::delete('initAdmin_' . $adminId);
        }
        return true;
    }

    /**
     * 更新节点缓存
     * @param null $adminId
     * @return bool
     */
    public static function updateNode($adminId = null)
    {
        if(empty($adminId)){
            Cache::tag('authNode')->clear();
        }else{
            Cache::delete('allAuthNode_' . $adminId);
        }
        return true;
    }

    /**
     * 更新系统设置缓存
     * @return bool
     */
    public static function updateSysconfig()
    {
        Cache::tag('sysconfig')->clear();
        return true;
    }

}