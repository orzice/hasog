<?php
// +----------------------------------------------------------------------
// | AcShop (Acgice商城)
// +----------------------------------------------------------------------
// | 技术支持【幻神科技】: https://www.hasog.com
// +----------------------------------------------------------------------
// | 联系我们: https://oauth.acgice.com/sdk/contact.html
// +----------------------------------------------------------------------
// | gitee开源项目：https://gitee.com/orzice/acshop
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/orzice/acshop
// +----------------------------------------------------------------------
// | Author：Orzice(小涛)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-12-24 16:37:39
// +----------------------------------------------------------------------
namespace HaSog\plugin\ac_cron\admin\index;


use app\common\controller\AdminController;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;


/**
 * @ControllerAnnotation(title="计划任务模块")
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
        print_r("[计划任务]插件列表<br>");
        print_r("=============<br>");
	}


}