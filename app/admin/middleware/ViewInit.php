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
// | DateTime：2020-12-31 18:17:22
// +----------------------------------------------------------------------

namespace app\admin\middleware;


use app\admin\service\ConfigService;
use app\common\constants\AdminConstant;
use think\App;
use think\facade\Request;
use think\facade\View;

class ViewInit
{

    public function handle($request, \Closure $next)
    {
        list($thisModule, $thisController, $thisAction) = [app('http')->getName(), Request::controller(), $request->action()];
        list($thisControllerArr, $jsPath) = [explode('.', $thisController), null];
        
    	$data = config_plus("hasog");

        View::assign($data);
        return $next($request);
    }


}