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

use app\common\Update;
use app\common\PluginsUpdate;

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
        $isHTTPS = ($this->request->server('SERVER_PORT') == 443 || $this->request->server('HTTPS') && strtolower($this->request->server('HTTPS')) != 'off') ? true : false;
        $scheme = 'http'.($isHTTPS ? 's' : '');
        $siteurl = $scheme.'://'.$this->request->server('HTTP_HOST');

        $data = 'siteuniqueid='.rawurlencode(getuniqueid()).'&siteurl='.rawurlencode($siteurl).'&sitever='.config_plus("hasog.version").'/'.config_plus("hasog.release").'&ip='.config_plus("hasog.ServerIp").'&sitecharset=utf-8&addonversion=1';
        $param = 'data='.rawurlencode(base64_encode($data));
        $param .= '&md5hash='.substr(md5(getHaSogServerIp().$data.time()), 8, 8).'&timestamp='.time();
      
        if(env('hasog.is_demo', false)){
            $param = '';
        }

        $this->assign('param', $param);

        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="升级插件")
     */
    public function up()
     {
        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $get = request()->get();
        $rule = [
            'dir|文件'      => 'require|alphaDash',
            'key|密钥'      => 'require|alphaDash',
        ];
        $this->validate($get, $rule);
        

        if (isset($_GET['up'])) {
            if ($_GET['up'] == '1') {
                $ups = new PluginsUpdate();
                return $ups->index($get['dir'],$get['key']);
            }
        }

        $this->assign('get', $get);
        return $this->fetch();
     }
    /**
     * @NodeAnotation(title="在线升级")
     */
    public function update()
     {

        if (isset($_GET['up'])) {
            if ($_GET['up'] == '1') {
                if(env('hasog.is_demo', false)){
                    $this->error('演示环境下不允许修改');
                }
                $ups = new Update();
                return $ups->index();
            }
        }

        return $this->fetch();
     }
}