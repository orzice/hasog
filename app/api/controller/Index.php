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

    //APP下载安装外部接口  http://127.0.1.99/api/index/cloudApp?dir=1_1&uniqueid=VDRRmBb9d9vcGa0E&key=123456
    public function cloudApp()
    {
        $post = $this->request->get();
        $rule = [

            'dir' => 'require|alphaDash',
            'uniqueid' => 'require|alphaDash',
            'key' => 'require|alphaDash',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if ($validate !== true) {
            return api_return(0, '异常');
        }
        if ($post['uniqueid'] !== config_plus("hasog.uniqueid")) {
            return api_return(0, '异常');
        }

        return redirect('/'.config_plus("hasog.Admin").'/plugin.cloud/up?dir='.$post['dir'].'&key='.$post['key']);
    }

    //返回软件配置信息
    public function index()
    {

        $data['version'] = config_plus("hasog.version");
        $data['release'] = config_plus("hasog.release");
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