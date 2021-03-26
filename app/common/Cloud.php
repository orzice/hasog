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
// | DateTime：2021-03-19 10:06:26
// +----------------------------------------------------------------------

namespace app\common;

use think\facade\Config;
use think\facade\Route;

class Cloud 
{
    private static $api_url = '';
    private static $uniqueid = false;
    private static $api = '';
    private static $api_lv = false;
    private static $error = false;
    private static $error_value = '';

    public function __construct()
    {
        self::$api_url =  config_plus("hasog.CloudUrl");
        self::$api_lv = self::GetV();
        self::$api =  self::$api_url.'/api/'.self::$api_lv.'.';
        self::$uniqueid = getuniqueid();
    }
    static public function GetError()
    {
        return self::$error_value;
    }
    static public function Error($value)
    {
        self::$api_url = true;
        self::$error_value = $value;
        return false;
    }
    static public function GetV()
    {
        $http = http_query(self::$api_url.'/api');
        $json = json_decode($http,true);
        if (empty($json)) {
            return self::Error('链接云平台失败！');
        }
        if (!isset($json['data'])) {
            return self::Error('链接云平台失败！');
        }
        return $json['data'];
    }
    static public function GetUpdate()
    {
        $http = http_query(self::$api.'update?uniqueid='.self::$uniqueid);
        $json = json_decode($http,true);
        if (empty($json)) {
            return self::Error('链接云平台失败！');
        }
        if ($json['code'] == 0) {
            if(isset($json['msg'])){
                return self::Error($json['msg']);
            }else{
                return self::Error('未知错误');
            }
        }
        return $json['data'];
    }
    static public function GetUpdateDir($dir='')
    {
        $http = http_query(self::$api.'update/dir?uniqueid='.self::$uniqueid.'&dir='.$dir);
        $json = json_decode($http,true);
        if (!empty($json)) {
            if(isset($json['code'])){
                if ($json['code'] == 0) {
                    return self::Error($json['msg']);
                }
            }else{
                return $http;
            }
        }
        
        return $http;
    }
    static public function GetNot()
    {
        $http = http_query(self::$api.'index/not');
        $json = json_decode($http,true);
        if ($json['code'] == 0) {
            if(isset($json['msg'])){
                return self::Error($json['msg']);
            }else{
                return self::Error('未知错误');
            }
        }
        return $json['data'];
    }
    static public function GetPluginUpdate($plugin='',$key='')
    {
        $http = http_query(self::$api.'update/plugin?uniqueid='.self::$uniqueid.'&plugin='.$plugin.'&key='.$key);
        $json = json_decode($http,true);
        if (!empty($json)) {
            if(isset($json['code'])){
                if ($json['code'] == 0) {
                    return self::Error($json['msg']);
                }
            }else{
                return $http;
            }
        }
        
        return $http;
    }

}