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

namespace app\api\controller;

use app\BaseController;
use app\common\controller\ApiController;
use think\facade\Config;
use think\facade\Event;
use app\common\Plugins;


class Index extends ApiController
{
    //返回软件配置信息
    public function index()
    {

        $data['version'] = config_plus("hasog.version");
        $data['site'] = [];
        $data['upload'] = [];
        $data['site']['name'] = sysconfig('site','site_name');
        $data['site']['beian'] = sysconfig('site','site_beian');
        $data['site']['name'] = sysconfig('site','site_name');
        $data['site']['copyright'] = sysconfig('site','site_copyright');
        $data['upload']['allow_size'] = sysconfig('upload','upload_allow_size');
        $data['upload']['allow_ext'] = sysconfig('upload','upload_allow_ext');

        return api_return(1,'',$data);
    }


}