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
// | DateTime：2020-12-31 18:18:36
// +----------------------------------------------------------------------

namespace app\admin\service;

use think\facade\Cache;

class ConfigService
{

    public static function getVersion()
    {
        $version = Cache('version');
        if (empty($version)) {
            $version = sysconfig('site', 'site_version');
            cache('site_version', $version);
            Cache::set('version', $version, 3600);
        }
        return $version;
    }

}