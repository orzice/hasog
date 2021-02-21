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
// | DateTime：2020-12-31 18:12:24
// +----------------------------------------------------------------------

namespace app\admin\controller\finace;
use app\common\model\CreditType;
use app\common\model\Member;

use app\common\controller\AdminController;
use think\App;
use app\common\model\FinaceBalancesub;
use app\common\model\FinaceUprecord;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="充值余额")
 */
class Upbalance extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'id'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Member();
    }

    /**
     * @NodeAnotation(title="充值余额列表")
     */
    public function index(){
        if ($this->request->isAjax()){
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $count = $this->model
                ->where($where)
                ->count();
            $list = $this->model
                ->where($where)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();
            $data = [
                'code' => 0,
                'msg' => '',
                'count' => $count,
                'data' => $list,
            ];
            return json($data);
        }
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="充值余额修改")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()){
            $post = $this->request->post();
            $rule=[
                'id|id'=>'require|number',
                'credit2s'=>['^[\+\-]?\d+(\.\d+)?$'],
                'credit_type|积分类型'=>'require|number',
            ];
            $this->validate($post['goods'], $rule);
            $credit = $this->model::where('id',$post['goods']['id'])->find();
            $credit=$credit['credit2'];
            $credit = $credit+$post['goods']['credit2s'];
            $b = substr($post['goods']['credit2s'], 0,1);
            $balancesub['money'] =$post['goods']['credit2s'];
            $balancesub['uid']   =$post['goods']['id'];
            $balancesub['balance'] = $credit;
            $balancesub['create_time'] = time();
            $uprecord['uid'] = $post['goods']['id'];
            $uprecord['way'] = 0;
            $uprecord['money'] = $post['goods']['credit2s'];
            $uprecord['state'] =1;
            $uprecord['create_time'] =time();
            $allow_credit = CreditType::where('id', $post['goods']['credit_type'])->find();
            empty($allow_credit) && $this->error('积分类型错误');
            $uprecord['credit_type'] =$allow_credit->id;
            $balancesub['credit_type'] =$allow_credit->id;
            try {
                if ($b == '-'){
                    $balancesub['state'] = 0;
                    $save = FinaceBalancesub::insert($balancesub);
                }else{
                    $balancesub['state'] = 1;
                    $save = FinaceBalancesub::insert($balancesub);
                }
                Member::where('id', $post['goods']['id'])->inc($allow_credit->value, $post['goods']['credit2s'])->update();
                $save = FinaceUprecord::insert($uprecord);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');

        }
        $credit_types = CreditType::select()->all();
        $this->assign('credit_types', $credit_types);
        $this->assign('row',$row);
        return $this->fetch();
    }

}