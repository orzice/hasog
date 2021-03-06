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
// | DateTime：2020-12-31 18:12:10
// +----------------------------------------------------------------------

namespace app\admin\controller\finace;

use app\common\controller\AdminController;
use app\common\model\FinaceBalanceset as Balancesets;
use think\App;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="余额设置")
 */
class Balanceset extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'create_time'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Balancesets();
    }
    /**
     * @NodeAnotation(title="余额设置修改")
     */
    public function edit(){
        $res = $this->model->limit(1)->select()->toArray();
        if (empty($res)){
            $res = array([
                'recharge'=>0,
                'proportion_status'=>0,
                'sole'=>'[]',
                'transfer'=>0,
                'manual_wechat'=>0,
                'manual_alipay'=>0,
                'manual_offline'=>0,
            ]);
        }
        $row='';
        foreach($res as $k=>$v){
            $row = $v;
        }
        $sole = json_decode($row['sole'],true);


        if ($this->request->isAjax()){
            
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'recharge'=>'require|number|in:0,1',
                'proportion_status' => 'require|number|in:0,1',
                'transfer' =>'require|number|in:0,1',
                'manual_wechat' =>'require|number|in:0,1',
                'manual_alipay' =>'require|number|in:0,1',
                'manual_offline' =>'require|number|in:0,1',
            ];
            $this->validate($post['balance'], $rule);
            if ($post['balance']['enough']){
                $enough = $post['balance']['enough'];
                $give = $post['balance']['give'];
                $sole = array();
                if (!empty($enough)) {
                    $array = is_array($enough) ? $enough : array();
                    foreach ($array as $k => $v) {
                        $sole[] = array(
                            'enough' => $enough[$k],
                            'give' => $give[$k],
                        );
                    }
                }
                foreach ($sole as $k=>$v){
                    if ($v['enough'] == ''&& $v['give'] ==''){
                        unset($sole[$k]);
                    }
                }
                $rule = [
                    'enough'=>'number|min:0',
                    'give' => 'number|min:0',
                ];
                foreach ($sole as $k => $v){
                    $this->validate($v, $rule);
                }
                $post['balance']['sole'] = json_encode($sole);
                unset($post['balance']['enough']);
                unset($post['balance']['give']);
                $this->validate($post['balance'], $rule);
            }
//            print_r($post['balance']);die;
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
//            print_r(unserialize($post['balance']['sole']));die;
        }
        $this->assign('row',$row);
        $this->assign('sole',$sole);
        return $this->fetch();
    }
}