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
// | DateTime：2020-12-31 18:16:29
// +----------------------------------------------------------------------

namespace app\admin\controller\member;


use app\common\model\CreditType;
use app\common\model\FinaceBalancesub;
use app\common\model\FinaceUprecord;
use think\App;
use think\facade\Config;
use app\common\model\Member;
use app\common\controller\AdminController;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

use app\common\service\ParentService;

/**
 * Class User
 * @package app\admin\controller\member
 * @ControllerAnnotation(title="会员管理")
 */
class User extends AdminController
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
     * @NodeAnotation(title="列表")
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $count = $this->model
                ->where($where)
                ->count();
            $list = $this->model
                ->withoutField('password')
                ->where($where)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();
            $data = [
                'code'  => 0,
                'msg'   => '',
                'count' => $count,
                'data'  => $list,
            ];
            return json($data);
        }
        $credit_values = CreditType::select();
        $this->assign('credit_values', $credit_values);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="添加账号")
     */
    public function add()
    {
        event('MemberAddStart');
        if ($this->request->isAjax()) {
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'mobile|手机' => 'require|mobile|length:4,20',
                'password|密码' => 'require|alphaNum|length:4,20',
                'content|备注' => 'chsDash|length:1,100',
            ];
            $this->validate($post, $rule);

            $post['password'] = U_password($post['password']);
    
            event('MemberAdd',$post);
            try {
                $save = $this->model->save($post);
            } catch (\Exception $e) {
                $this->error('新增失败');
            }

            if($save){
               event('MemberAddEnd',$post);
            }


            $save ? $this->success('新增成功') : $this->error('新增失败');
        }

        $plugin = Config::get('memberadd');
        $this->assign('plugin',$plugin);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="编辑账号")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        event('MemberEditStart',$id);

        if ($this->request->isAjax()) {
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [];
            $this->validate($post, $rule);
            event('MemberEdit',$post);
            try {
                $save = $row->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if($save){
               event('MemberEditEnd',$post);
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $plugin = Config::get('memberedit');
        $this->assign('plugin',$plugin);
        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="修改推荐人")
     */
    public function parent($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()) {
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                // 'mobile|手机'       => 'require|mobile|length:4,20',
                'mobile|推荐人UID'       => 'require|number',
            ];
            $this->validate($post, $rule);
            if($post['mobile'] == $row['id']){$this->error('不能设置自己为自己的上级');}
            $rows = $this->model->where('id',$post['mobile'])->find();
            $rows->isEmpty() && $this->error('数据不存在');

            event('MemberParent',array(
                'id' => $id,
                'parent' => $row['parent_id'],
                'new' => $rows['id'],
                ));


            $data = new ParentService();
            if ($row['parent_id'] !== 0) {
                $data->ParentEdit($row['id'],$row['parent_id']);
            }
            $parent_ids = $data->ParentInit($rows['id']);


            try {
                $save = $row->save([
                    'parent_id' => $rows['id'],
                    'parent_ids' => $parent_ids,
                    'parent_ids_s' => 1,
                ]);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if($save){
                event('MemberParentEnd',array(
                    'id' => $id,
                    'parent' => $row['parent_id'],
                    'new' => $rows['id'],
                    ));
            }

            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }

    /**
     * @NodeAnotation(title="余额充值")
     */
    public function recharge_balance($id)
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
            $allow_credit = CreditType::where('id', $post['goods']['credit_type'])->find();
            empty($allow_credit) && $this->error('积分类型错误');
            $this->validate($post['goods'], $rule);
            $credit = $this->model::where('id',$post['goods']['id'])->find();
//            print_r($credit);die();
            $old_credit=$credit->getAttr($allow_credit->value);
            $credit = $credit->getAttr($allow_credit->value)+$post['goods']['credit2s'];
            $b = substr($post['goods']['credit2s'], 0,1);
            $balancesub['money'] =$post['goods']['credit2s'];
            $balancesub['uid']   =$post['goods']['id'];
            $balancesub['before_balance'] = $old_credit; // 修改前积分
            $balancesub['balance'] = $credit; // 修改后的积分
            $balancesub['remark'] = '后台充值'.$allow_credit->title.$post['goods']['credit2s'];
            $balancesub['create_time'] = time();
            $uprecord['uid'] = $post['goods']['id'];
            $uprecord['way'] = 0;
            $uprecord['before_balance'] = $old_credit; // 修改前积分
            $uprecord['after_balance'] = $credit; // 修改后的积分
            $uprecord['remark'] = '后台充值'.$allow_credit->title.$post['goods']['credit2s'];
            $uprecord['money'] = $post['goods']['credit2s'];
            $uprecord['state'] =1;
            $uprecord['create_time'] =time();

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

    /**
     * @NodeAnotation(title="修改密码")
     */
    public function password($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()) {
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'password|登录密码'       => 'require|alphaNum|length:4,20',
                'password_again|确认密码' => 'require|alphaNum|length:4,20',
            ];
            $this->validate($post, $rule);
            if ($post['password'] != $post['password_again']) {
                $this->error('两次密码输入不一致');
            }
            $post['id'] = $id;
            event('MemberPassword',$post);
            try {
                $save = $row->save([
                    'password' => U_password($post['password']),
                ]);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if($save){
                event('MemberPasswordEnd',$post);
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="删除")
     */
    public function delete($id)
    {
        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $row = $this->model->whereIn('id', $id)->select();
        $row->isEmpty() && $this->error('数据不存在');
        event('MemberDelete',$id);
        try {
            $save = $row->delete();
        } catch (\Exception $e) {
            $this->error('删除失败');
        }
        if($save){
            event('MemberDeleteEnd',$id);
        }
        $save ? $this->success('删除成功') : $this->error('删除失败');
    }
    /**
     * @NodeAnotation(title="属性修改")
     */
    public function modify()
    {
        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $post = $this->request->post();
        $rule = [
            'id|ID'    => 'require',
            'field|字段' => 'require',
            'value|值'  => 'require',
        ];
        $this->validate($post, $rule);

        if (!in_array($post['field'], $this->allowModifyFileds)) {
            $this->error('该字段不允许修改：' . $post['field']);
        }
        $row = $this->model->find($post['id']);
        empty($row) && $this->error('数据不存在');
        event('MemberModify',$post);
        try {
            $row->save([
                $post['field'] => $post['value'],
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        event('MemberModifyEnd',$post);
        $this->success('保存成功');
    }
}
