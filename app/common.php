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
// 应用公共文件

use think\exception\HttpResponseException;
use app\common\service\AuthService;
use think\facade\Cache;
use think\facade\Config;

if (!function_exists('RequestPlugin')) {
    /**
     *  后台插件专用 获取路由
     */
    function RequestPlugin($name,$dic,$con,$fun,$ls = false)
    {
        $http = app('http')->getName();
        $http = '/'.$http.'/';
        if ($ls) {
            $http = '';
        }
        //plugins.a-index-index-index
        return $http.'plugins.'.$name.'-'.$dic.'-'.$con.'-'.$fun;
    }
}
if (!function_exists('Uploadfile')) {
    /**
     *  标记 附件已使用
     */
    function Uploadfile($url)
    {
        \app\admin\model\SystemUploadfile::where("uid",Sessions('id'))->where("state",0)->where("url",$url)->update(["state" => 1]);
        return true;
    }
}
if (!function_exists('UploadfileDelete')) {
    /**
     *  清除未使用附件  每一次上传 都会监控未使用的图片 进行删除处理
     */
    function UploadfileDelete()
    {
        $row = \app\admin\model\SystemUploadfile::where('file','<>',"")->where('state',0)->select();
        for ($i=0; $i < count($row); $i++) { 
              if ($row[$i]['file'] == '') {
                continue;
              }
            //进行删除文件操作
             $wjm = root_path() . 'public/' . $row[$i]['file'];
             $wjm = str_replace(DIRECTORY_SEPARATOR, '/', $wjm);
             $wjm = str_replace(DIRECTORY_SEPARATOR, '\/', $wjm);

            if(file_exists($wjm)){
              unlink($wjm);
            }
        }
        //删除数据库记录
        \app\admin\model\SystemUploadfile::where('file','<>',"")->where('state',0)->delete();
        return true;
    }
}
if (!function_exists('Sessions')) {
    /**
     * 获取Session配置信息  可以随意修改Session名
     * @param $group
     * @param null $name
     * @return array|mixed
     */
    function Sessions($name = null,$data = 0)
    {
        $src = config_plus("hasog.SessionName");
        if($name){
            $src = $src .".".$name;
        }
        if($data !== 0){
            return session($src,$data);
        }else{
            return session($src);
        }
    }
}

if (!function_exists('sysconfig')) {

    /**
     * 获取系统配置信息
     * @param $group
     * @param null $name
     * @return array|mixed
     */
    function sysconfig($group, $name = null)
    {
        $where = ['group' => $group];
        $value = empty($name) ? Cache::get("sysconfig_{$group}") : Cache::get("sysconfig_{$group}_{$name}");
        if (empty($value)) {
            if (!empty($name)) {
                $where['name'] = $name;
                $value = \app\admin\model\SystemConfig::where($where)->value('value');
                Cache::tag('sysconfig')->set("sysconfig_{$group}_{$name}", $value, 3600);
            } else {
                $value = \app\admin\model\SystemConfig::where($where)->column('value', 'name');
                Cache::tag('sysconfig')->set("sysconfig_{$group}", $value, 3600);
            }
        }
        return $value;
    }
}
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
 
if (!function_exists('__url')) {

    /**
     * 构建URL地址
     * @param string $url
     * @param array $vars
     * @param bool $suffix
     * @param bool $domain
     * @return string
     */
    function __url(string $url = '', array $vars = [], $suffix = true, $domain = false)
    {
        return url($url, $vars, $suffix, $domain)->build();
    }
}
if (!function_exists('__aurl')) {

    /**
     * 构建URL地址
     * @param string $url
     * @param array $vars
     * @param bool $suffix
     * @param bool $domain
     * @return string
     */
    function __aurl(string $url = '')
    {
        return __url('admin/index/index').'#'.__url($url);
    }
}

if (!function_exists('U_password')) {

    /**
     * 用户密码加密算法
     * @param $value 需要加密的值
     * @param $type  加密类型，默认为md5 （md5, hash）
     * @return mixed
     */
    function U_password($value)
    {
        $value = sha1('hasog_') . md5(config_plus("hasog.userPW")) .  md5($value) . sha1($value);
        return sha1($value);
    }

}
if (!function_exists('password')) {

    /**
     * 后台密码加密算法
     * @param $value 需要加密的值
     * @param $type  加密类型，默认为md5 （md5, hash）
     * @return mixed
     */
    function password($value)
    {
        $value = sha1('ac_') . md5($value) . md5(config_plus("hasog.pwSDK")) . sha1($value);
        return sha1($value);
    }

}

if (!function_exists('config_plus')) {

    /**
     * 获取系统配置文件信息
     * @param $group
     * @param null $name
     * @return array|mixed
     */
    function config_plus($name)
    {
        return Config::get($name);
    }
}

if (!function_exists('auth')) {

    /**
     * auth权限验证
     * @param $node
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function auth($node = null)
    {
        $authService = new AuthService(Sessions('id'));
        $check = $authService->checkNode($node);
        return $check;
    }

}


if (!function_exists('getSubstr')) {
/*以下是取中间文本的函数 
getSubstr=调用名称
$str=预取全文本 
$leftStr=左边文本
$rightStr=右边文本
*/
function getSubstr($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    //echo '左边:'.$left;
    $right = strpos($str, $rightStr,$left);
    //echo '<br>右边:'.$right;
    if($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}
}

if (!function_exists('array_format_key')) {

    /**
     * 二位数组重新组合数据
     * @param $array
     * @param $key
     * @return array
     */
    function array_format_key($array, $key)
    {
        $newArray = [];
        foreach ($array as $vo) {
            $newArray[$vo[$key]] = $vo;
        }
        return $newArray;
    }

}

//判断是否是APP访问
function is_app(){
  if(isset($_SERVER['HTTP_USER_AGENT'])){
    $agent = $_SERVER['HTTP_USER_AGENT'];
   }else{
    $agent = '';
   }
   if(strpos($agent,"Html5Plus") !== false){
    //H5手机版
    return true;
   }
}
//判断是否是手机访问不是就是PC访问
function is_mobile(){
  if(isMobiles()){
      return true;
  }else{
      return false;
  }
}
//判断是否是微信访问
function is_weixin(){
  if(isset($_SERVER['HTTP_USER_AGENT'])){
    $ua = $_SERVER['HTTP_USER_AGENT'];
   }else{
    $ua = '';
   }
   
  //MicroMessenger 是android/iphone版微信所带的
  //Windows Phone 是winphone版微信带的  (这个标识会误伤winphone普通浏览器的访问)
  //if(strpos($ua, 'MicroMessenger') == false || strpos($ua, 'Windows Phone') == false){ 
  if(strpos($ua, 'MicroMessenger') == false){  
      return false;
  }else{  
      return true;
  }
}
//判断是否手机版
function isMobiles()
{ 
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 