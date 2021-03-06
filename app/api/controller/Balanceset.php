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
// | DateTime：2021-03-26 18:39:21
// +----------------------------------------------------------------------
namespace app\admin\controller\finace;
use app\common\controller\AdminController;
use app\common\model\FinaceBalanceset as Balancesets;
use think\App;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package appadmincontrollerpage
 * @ControllerAnnotation(title="余额设置")
 */
class Balanceset extends AdminController {
    use \app\admin\traits\Curd;
    protected $sort = [
                'create_time'   => 'desc',
            ];
    public function __construct(App $app) {
        parent::__construct($app);
        $this->model = new Balancesets();
    }
    /**
     * @NodeAnotation(title="修改")
     */
    public function edit() {
        $res = $this->model->limit(1)->select()->toArray();
        $row='';
        foreach($res as $k=>$v) {
            $row = $v;
        }
        $sole = json_decode($row['sole'],true);
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'recharge'=>'require|number|in:0,1',
                'proportion_status' => 'require|number|in:0,1',
                'transfer' =>'require|number|in:0,1',
            ];
            $this->validate($post['balance'], $rule);
            if ($post['balance']['enough']) {
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
                foreach ($sole as $k=>$v) {
                    if ($v['enough'] == ''&& $v['give'] =='') {
                        unset($sole[$k]);
                    }
                }
                $rule = [
                    'enough'=>'number|min:0',
                    'give' => 'number|min:0',
                ];
                foreach ($sole as $k => $v) {
                    $this->validate($v, $rule);
                }
                $post['balance']['sole'] = json_encode($sole);
                unset($post['balance']['enough']);
                unset($post['balance']['give']);
                $this->validate($post['balance'], $rule);
            }
            $res = $this->model->limit(1)->select();
            $post['balance']['id'] = $res['0']['id'];
            //            print_r($post['balance']);die;
            try {
                if ($res) {
                    $save = $this->model->update($post['balance']);
                } else {
                    $save = $this->model->insert($post['balance']);
                }
            }
            catch (Exception $e) {
                //                $this->error('保存失败:'.$e->getMessage());
                return api_return(0, '保存失败:'.$e->getMessage());
            }
            if ($save!== false) {
                return api_return(1, '保存成功');
            } else {
                return api_return(0, '保存失败');
            }
            //            $save ? $this->success('保存成功') : $this->error('保存失败');
            //            print_r(unserialize($post['balance']['sole']));die;
        }
        $this->assign('row',$row);
        $this->assign('sole',$sole);
        return $this->fetch();
    }
}