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

namespace app\api\middleware;

use app\common\service\AuthService;
use think\Request;


/**
 * 检测用户登录和节点权限
 * Class CheckAdmin
 * @package app\api\middleware
 */
class CheckAdmin
{

    use \app\common\traits\JumpApi;

    public function handle(Request $request, \Closure $next)
    {
        //Sessions(null,array("id"=>1,"expire_time"=>1634546127));

        $MemberConfig = config('member');
 
        $member_id = Sessions("member_id");
        $currentController = parse_name($request->controller());

        // 插件不需要验证登录
        $name = 'plugin.';
        $info = $request->pathinfo();
        if (substr ($info, 0,strlen($name)) == $name) {
            return $next($request);
        }

        // 其他的验证登录
        if (!in_array($currentController, $MemberConfig['no_login_controller'])) {
            empty($member_id) && $this->error('请先登录账号', 'login','login');
        }

        return $next($request);
    }

}