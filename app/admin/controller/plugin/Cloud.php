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
// | DateTime：2020-12-31 18:15:25
// +----------------------------------------------------------------------

namespace app\admin\controller\plugin;

use app\common\controller\AdminController;
use app\common\Plugins;
use app\common\model\PluginsData;

use app\admin\service\TriggerService;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
use think\App;

use app\admin\model\SystemMenu;

/**
 * @ControllerAnnotation(title="插件云平台")
 * Class Node
 * @package app\admin\controller\plugin
 */

class Cloud extends AdminController
{
    /**
     * @NodeAnotation(title="云平台")
     */
    public function index()
     {
        //获取插件配置
        // $PluginOn = Plugins::GetPluginList(1);
        // $PluginOff = Plugins::GetPluginList(0);
        // $Install = Plugins::GetInstallPlugin();

        // $this->assign('PluginOn', $PluginOn);
        // $this->assign('PluginOff', $PluginOff);
        // $this->assign('Install', $Install);

        return $this->fetch();
    }
}