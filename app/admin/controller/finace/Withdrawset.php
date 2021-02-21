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
// | Author：梗集(王国骁)  https://gitee.com/orzice
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
        $res = $this->model->limit(1)->select()->toArray();
        if (empty($res)){
            $res = array([
                'recharge'=>0,
                'wechat'=>0,
                'wechatmin'=>'',
                'wechatnum'=>'',
                'wechatmax'=>'',
                'alipay'=>0,
                'alipaymin'=>'',
                'alipaymax'=>'',
                'alipaynum'=>'',
                'manual'=>0,
                'manual_wechat'=>0,
                'manual_alipay'=>0,
                'service'=>0,
                'services'=>0,
                'servicesminus'=>0,
                'minservices'=>0,
            ]);
        }
        $row='';
        foreach($res as $k=>$v){
            $row = $v;
        }
        if ($this->request->isAjax()){
            $post = $this->request->post();

            $rule = [
                'recharge'=>'require|number|in:0,1',
                'wechat'=>'require|number|in:0,1',
                'wechatmin|微信最低金额'=>'float|between: 0.3,20000',
                'wechatmax|微信最高金额'=>'float|between: 0.3,20000',
                'wechatnum|微信提现次数'=>'number|between: 1,10',
                'alipay'=>'require|number|in:0,1',
                'alipaymin|支付宝最低金额'=>'float|between: 0,50000',
                'alipaymax|支付宝最高金额'=>'float|between: 0,50000',
                'alipaynum|支付宝提现次数'=>'number|min:1',
                'manual'=>'require|number|in:0,1',
                'manual_wechat'=>'require|number|in:0,1',
                'manual_alipay'=>'require|number|in:0,1',
                'service'=>'require|number|in:0,1',
                'services'=>'float|between: 0,999999',
                'servicesminus'=>'float|between: 0,999999',
                'minservices'=>'float|between: 0,999999',
            ];
            $this->validate($post['balance'], $rule);
            $res = $this->model->limit(1)->select()->toArray();
            try {
                if (empty($res)){

                    $save = $this->model->insert($post['balance']);
                }else{
                    $post['balance']['id'] = $res['0']['id'];
                    $save = $this->model->update($post['balance']);
                }
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('res',$row);
       return $this->fetch();
    }
}