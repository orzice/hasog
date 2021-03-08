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
// | DateTime：2021-03-06 11:05:20
// +----------------------------------------------------------------------
// 应用公共文件

use think\exception\HttpResponseException;
use app\common\service\AuthService;
use think\facade\Cache;
use think\facade\Config;


if (!function_exists('isReadWrite')) {
function isReadWrite($file)
    {
        if (DIRECTORY_SEPARATOR == '\\') {
            return true;
        }
        if (DIRECTORY_SEPARATOR == '/' && @ ini_get("safe_mode") === false) {
            return is_writable($file);
        }
        if (!is_file($file) || ($fp = @fopen($file, "r+")) === false) {
            return false;
        }
        fclose($fp);
        return true;
    }
}




if (!function_exists('checkPhpVersion')) {

function checkPhpVersion($version)
{
    $php_version = explode('-', phpversion());
    $check = strnatcasecmp($php_version[0], $version) >= 0 ? true : false;
    return $check;
}
}

