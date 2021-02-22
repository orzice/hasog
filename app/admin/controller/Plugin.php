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
// | DateTime：2020-12-31 18:14:18
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\controller\AdminController;

use think\facade\Request;
use app\common\Plugins;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

use app\common\service\AuthService;

/**
 * Class Category
 * @package app\admin\controller\goods
 * @ControllerAnnotation(title="插件开启权限")
 */
class Plugin extends AdminController
{
    /**
     * @NodeAnotation(title="插件详情")
     */
    //插件详情  待开发
    public function default()
    {
        $name = 'plugins.';
        $info = Request::pathinfo();
        if (substr ($info, 0,strlen($name)) !== $name) {
            return $this->error('插件不存在', '','');
        }
        $plugin = str_replace($name, '', $info);
        $plugin = str_replace('.html', '', $plugin);

    }
    /**
     * @NodeAnotation(title="插件HOOK")
     */
    public function call()
    {
        // plugins.a-index-index-index
        // plugins.a-index-index/index

        //plugins.ac_cron-index-index/index


        $name = 'plugins.';
        $info = Request::pathinfo();
        if (substr ($info, 0,strlen($name)) !== $name) {
            return $this->error('插件不存在', '','');
        }
        $plugin = str_replace($name, '', $info);
        $plugin = str_replace('/', '-', $plugin);

        $call = explode('-', $plugin);
        if(count($call) !== 4){
            return $this->error('插件不存在', '','');
        }
        $call3 = explode('.', $call[3]);

        //判断 
        $adminId = Sessions("id");
        $authService = new AuthService($adminId);
        // 验证权限
        $check = $authService->checkNode('plugins.'.$call[0].'-'.$call[1].'-'.$call[2].'/'.$call[3]);
        if (!$check) {
            $this->error('无权限访问');
        }



        $data = Plugins::GetPluginState($call[0]);

        if (!$data) {
            return $this->error('插件不存在或未开启！', '','');
        }
        // HaSog\plugin\<p1>\admin\<p2>\<p3>@<p4>
        // try {
            $dic = 'HaSog\plugin\\'.$call[0].'\admin\\'.$call[1].'\\'.$call[2];
            $dic2 = $call3[0];
            $test = new $dic($this->app);
            return $test->$dic2();
        // }  catch (\Throwable $e) {
        //     return $this->error('插件报错，请联系技术支持！', '','');
        // }

    }
}