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
// | DateTime：2020-12-31 18:22:40
// +----------------------------------------------------------------------
namespace app\common\controller;


use app\BaseController;
use think\Model;

use think\exception\HttpResponseException;
use think\Response;
use think\facade\Cache;

use app\common\Plugins;

class ApiController extends BaseController
{

    /**
     * 当前模型
     * @Model
     * @var object
     */
    protected $model;

    /**
     * 初始化方法
     */
    protected function initialize()
    {
        parent::initialize();
        
    }

    /**
     * 获取用户是否登录
     * @return bool
     */
    public function MemberId()
    {
    	$member_id = Sessions("member_id");
    	if (empty($member_id)) {
    		// return api_return(0,'请先登录账号', 'login','login');
    		return false;
    	}
        return $member_id;
//        return 1;
    }
    /**
     * 获取用户是否登录 [插件API专用]
     * @return bool
     */
    public function PluginMemberId()
    {
    	$member_id = Sessions("member_id");
    	if (empty($member_id)) {
    		return api_return(0,'请先登录账号', 'login','login');
    		// return false;
    	}
        return $member_id;
    }
    /**
     * 延迟 API
     * @return bool
     */
    public function PluginApiCD($name,$num=3)
    {
      // ================ 3秒内只能允许一次！ ==================
		$cache = Cache::store('redis');
      $hc = $cache->get($name);
      if ($hc) {
        return api_return(0,'点击太快啦！稍后再试！');
      }
      $cache->set($name, 1, $num);
      // ================ 3秒内只能允许一次！ ==================
    }

    /**
     * 模板变量赋值
     * @param string|array $name 模板变量
     * @param mixed $value 变量值
     * @return mixed
     */
    public function assign($name, $value = null)
    {
        return $this->app->view->assign($name, $value);
    }

    /**
     * 解析和获取模板内容 用于输出
     * @param string $template
     * @param array $vars
     * @return mixed
     */
    public function fetch($template = '', $vars = [])
    {
        return $this->app->view->fetch($template, $vars);
    }

    /**
     * 重写验证规则
     * @param array $data
     * @param array|string $validate
     * @param array $message
     * @param bool $batch
     * @return array|bool|string|true
     */
    public function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        try {
            parent::validate($data, $validate, $message, $batch);
        } catch (\Exception $e) {
            //$this->error($e->getMessage());
			return $e->getMessage();
        }
        return true;
    }
	
	
	    /**
	     * 展示页面
	     * @access protected
	     * @param mixed $msg 提示信息
	     * @param mixed $data 返回的数据
	     * @param string $url 跳转的 URL 地址
	     * @param int $wait 跳转等待时间
	     * @param array $header 发送的 Header 信息
	     * @return void
	     * @throws HttpResponseException
	     */
	    protected function apiview($code = 0,$msg = '', $data = '', $url = null, $wait = 2)
	    {
	        $result = [
	            'code' => $code,
	            'msg'  => $msg,
	            'data' => $data,
	            'url'  => $url,
	            'wait' => $wait,
	        ];

	
            $response = view(app('config')->get('app.dispatch_success_tmpl'), $result);
	       
	        throw new HttpResponseException($response);
	    }
	
	    /**
	     * 操作成功跳转的快捷方法
	     * @access protected
	     * @param mixed $msg 提示信息
	     * @param mixed $data 返回的数据
	     * @param string $url 跳转的 URL 地址
	     * @param int $wait 跳转等待时间
	     * @param array $header 发送的 Header 信息
	     * @return void
	     * @throws HttpResponseException
	     */
	    protected function success($msg = '', $data = '', $url = null, $wait = 3, array $header = [])
	    {
	        // if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
	        //    zuo $url = $_SERVER["HTTP_REFERER"];
	        // } elseif ($url) {
	        //     $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url)->__toString();
	        // }
	
	        $result = [
	            'code' => 1,
	            'msg'  => $msg,
	            'data' => $data,
	            'url'  => $url,
	            'wait' => $wait,
	        ];
	
	        $type = $type = $this->getResponseType();
	        if ($type == 'html') {
                $response = json($result);
//                $response = view(app('config')->get('app.dispatch_success_tmpl'), $result);
	        } elseif ($type == 'json') {
	            $response = json($result);
	        }
	        throw new HttpResponseException($response);
	    }
	
	    /**
	     * 操作错误跳转的快捷方法
	     * @access protected
	     * @param mixed $msg 提示信息
	     * @param mixed $data 返回的数据
	     * @param string $url 跳转的 URL 地址
	     * @param int $wait 跳转等待时间
	     * @param array $header 发送的 Header 信息
	     * @return void
	     * @throws HttpResponseException
	     */
	    protected function error($msg = '', $data = '', $url = null, $wait = 3, array $header = [])
	    {
	        // if (is_null($url)) {
	        //     $url = request()->isAjax() ? '' : 'javascript:history.back(-1);';
	        // } elseif ($url) {
	        //     $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url)->__toString();
	        // }
	
	        $type   = $this->getResponseType();
	        $result = [
	            'code' => 0,
	            'msg'  => $msg,
	            'data' => $data,
	            'url'  => $url,
	            'wait' => $wait,
	        ];
	        if ($type == 'html') {
	            $response = json($result);
	            //$response = view(app('config')->get('app.dispatch_error_tmpl'), $result);
	        } elseif ($type == 'json') {
	            $response = json($result);
	        }
	        throw new HttpResponseException($response);
	    }
	
	    /**
	     * 返回封装后的 API 数据到客户端
	     * @access protected
	     * @param mixed $data 要返回的数据
	     * @param int $code 返回的 code
	     * @param mixed $msg 提示信息
	     * @param string $type 返回数据格式
	     * @param array $header 发送的 Header 信息
	     * @return void
	     * @throws HttpResponseException
	     */
	    protected function result($data, $code = 0, $msg = '', $type = '', array $header = [])
	    {
	        $result   = [
	            'code' => $code,
	            'msg'  => $msg,
	            'time' => time(),
	            'data' => $data,
	        ];
	        $type     = $type ?: $this->getResponseType();
	        $response = Response::create($result, $type)->header($header);
	
	        throw new HttpResponseException($response);
	    }
	
	    /**
	     * URL 重定向
	     * @access protected
	     * @param string $url 跳转的 URL 表达式
	     * @param array|int $params 其它 URL 参数
	     * @param int $code http code
	     * @param array $with 隐式传参
	     * @return void
	     * @throws HttpResponseException
	     */
	    protected function redirect($url = [], $params = [], $code = 302)
	    {
	        if (is_integer($params)) {
	            $code   = $params;
	            $params = [];
	        }
	
	        $response = Response::create($url, 'redirect', $code);
	        throw new HttpResponseException($response);
	    }
	
	    /**
	     * 获取当前的 response 输出类型
	     * @access protected
	     * @return string
	     */
	    protected function getResponseType()
	    {
	        return (request()->isJson() || request()->isAjax() || request()->isPost()) ? 'json' : 'html';
	    }


}