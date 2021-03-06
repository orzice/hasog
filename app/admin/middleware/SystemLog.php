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
// | DateTime：2021-03-06 09:39:17
// +----------------------------------------------------------------------
namespace app\admin\middleware;

use app\admin\service\SystemLogService;
use EasyAdmin\tool\CommonTool;

/**
 * 系统操作日志中间件
 * Class SystemLog
 * @package app\admin\middleware
 */
class SystemLog
{

    public function handle($request, \Closure $next)
    {

        if ($request->isAjax()) {
            $method = strtolower($request->method());
            if (in_array($method, ['post', 'put', 'delete'])) {
                if(Sessions("id")){
                    
                    $url = $request->url();
                    $ip = CommonTool::getRealIp();
                    $params = $request->param();
                    if (isset($params['s'])) {
                        unset($params['s']);
                    }
                    $data = [
                        'admin_id'    => Sessions("id"),
                        'admin_name'  => Sessions("username"),
                        'url'         => $url,
                        'method'      => $method,
                        'ip'          => $ip,
                        'content'     => json_encode($params, JSON_UNESCAPED_UNICODE),
                        'useragent'   => $_SERVER['HTTP_USER_AGENT'],
                        'create_time' => time(),
                    ];
                    SystemLogService::instance()->save($data);
                }
            }
        }
        return $next($request);
    }

}