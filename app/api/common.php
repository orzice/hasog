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
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------
// 应用公共文件


use think\exception\HttpResponseException;
use app\common\service\AuthService;
use think\facade\Cache;
use think\facade\Config;


if (!function_exists('http_query')) {
function http_query($url, $post = null)
   {
        // 初始化一个cURL会话
        $ch = curl_init($url);
        if (isset($post)) {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
        //忽略证书
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        $curl_result = curl_exec($ch);
        if ($curl_result) {
            $data = $curl_result;
        } else {
            $data = curl_error($ch);
        }
        curl_close($ch);    #关闭cURL会话
        return $data;
    }
 }
 
/**
 * 插件请使用这个进行拦截系统操作  0是失败  1是成功！
 * 
 * 建议只在必要的时候再使用此函数，不然可能发生无法预料的问题。
 */
if (!function_exists('api_return')) {

    function api_return($code = 0,$msg = '', $data = '', $url = null, $wait = 2)
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];
        $response = json($result);
        throw new HttpResponseException($response);
    }
}

