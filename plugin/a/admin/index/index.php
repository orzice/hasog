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
// | DateTime：2021-01-04 17:21:00
// +----------------------------------------------------------------------
namespace AcShop\plugin\a\admin\index;


use app\common\controller\AdminController;
use app\common\Plugins;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;


/**
 * @ControllerAnnotation(title="管理后台")
 * Class Node
 * @package app\admin\controller\system
 */
class Index extends AdminController
{
	
    /**
     * @NodeAnotation(title="首页")
     */
	public function index()
	{
        print_r("=============<br>");
        print_r("[管理员界面]插件列表<br>");
        print_r("=============<br>");
        print_r(Plugins::GetPluginList());
		return 111;
	}


}