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
// | DateTime：2020-12-31 18:17:10
// +----------------------------------------------------------------------

namespace app\admin\middleware;

use app\common\service\AuthService;
use think\Request;


/**
 * 检测用户登录和节点权限
 * Class CheckAdmin
 * @package app\admin\middleware
 */
class CheckAdmin
{

    use \app\common\traits\JumpTrait;

    public function handle(Request $request, \Closure $next)
    {
        //Sessions(null,array("id"=>1,"expire_time"=>1634546127));

        $adminConfig = config('admin');
 
        $adminId = Sessions("id");
        $expireTime = Sessions("expire_time");
        $authService = new AuthService($adminId);
        $currentNode = $authService->getCurrentNode();
        $currentController = parse_name($request->controller());


        // 验证登录
        if (!in_array($currentController, $adminConfig['no_login_controller']) &&
            !in_array($currentNode, $adminConfig['no_login_node'])) {
            empty($adminId) && $this->error('请先登录后台', [], __url('admin/login/index'));

            // 判断是否登录过期
            if ($expireTime !== true && time() > $expireTime) {
                Sessions(null, null);
                $this->error('登录已过期，请重新登录', [], __url('admin/login/index'));
            }
        }

        // 验证权限
        if (!in_array($currentController, $adminConfig['no_auth_controller']) &&
            !in_array($currentNode, $adminConfig['no_auth_node'])) {
            $check = $authService->checkNode($currentNode);
            !$check && $this->error('无权限访问');

        }

        return $next($request);
    }

}