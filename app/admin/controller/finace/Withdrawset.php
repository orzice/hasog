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
// | DateTime：2020-12-31 18:12:48
// +----------------------------------------------------------------------

namespace app\admin\controller\finace;
use app\common\controller\AdminController;
use app\common\model\FinaceWithdrawset as Withdrawsets;
use think\App;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="提现设置")
 */
class Withdrawset extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'create_time'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Withdrawsets();
    }
    /**
     * @NodeAnotation(title="修改")
     */
    public function edit(){
        $row = $this->model->limit(1)->select()->toArray();
        $res='';
        foreach($row as $k=>$v){
            $res = $v;
        }
        if ($this->request->isAjax()){
            $post = $this->request->post();
            $rule = [
                'recharge'=>'require|number|in:0,1',
                'wechat'=>'require|number|in:0,1',
                'wechatmin'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
                'wechatmax'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
                'wechatnum'=>'number',
                'alipay'=>'require|number|in:0,1',
                'alipaymin'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
                'alipaymax'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
                'alipaynum'=>'number',
                'manual'=>'require|number|in:0,1',
                'manuals'=>'number|in:0,1,2',
                'service'=>'require|number|in:0,1',
                'services'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
                'servicesminus'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
                'minservices'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
            ];
            $this->validate($post['balance'], $rule);
            $res = $this->model->limit(1)->select();
            $post['balance']['id'] = $res['0']['id'];
            try {

                if ($res){
                    $save = $this->model->update($post['balance']);
                }else{
                    $save = $this->model->insert($post['balance']);
                }
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('res',$res);
       return $this->fetch();
    }
}