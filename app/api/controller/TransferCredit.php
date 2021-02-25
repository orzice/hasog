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
// | Author：王火火(王琰豪)  https://gitee.com/w321
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------

namespace app\api\controller;


use app\common\controller\ApiController;
//use app\common\model\Cart as CartModel;
use app\common\model\CreditType;
use app\common\model\Member;
use app\common\model\TransferCredit as TransferCreditModel;
use think\Exception;
use think\facade\Config;
use think\facade\Db;
use think\facade\Event;

class TransferCredit extends ApiController
{
    // 获取可转账积分列表
    public function get_credit_type()
    {
        $post = $this->request->post();
        // code = {1:'支持支付',2:'支持提现',3:'支持转账',4:'支持转余额'} 不传返回所有
        $code = isset($post['code']) ? $post['code'] : null ;
        $code = key_exists($code, CreditType::IS_WAY)? CreditType::IS_WAY[$code] : null;
        if ($code===null){
            $credit_types = CreditType::field('id, title, value')->select();
        }else {
            $credit_types = CreditType::where($code, 1)->field('id, title, value')->select();
        }
        $this->success('获取可转账积分列表成功', ['objs'=>$credit_types]);
    }

    // 积分转余额
    public function internal_transfer(){
        $post = $this->request->post();
        $user_id = $this->MemberId();
        $user = Member::where('state', '0')->find($user_id);
        empty($user) && $this->error('用户数据错误');
//        $type = $post['type'];
        $rule = [
            'amount|转换金额' => 'require|float',
            'credit_type|转换类型' => 'require|length: 1,100',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if ($validate !== true) {
            $this->error('金额数据或转换类型有误');
        }
        $allow_credit = CreditType::where('id', $post['credit_type'])->where('is_convert', 1)->find();
        empty($allow_credit) && $this->error('该类型暂不支持转成余额');
        if($user->credit3 < $post['amount']){
            $this->error('转换失败, '.$allow_credit->title.'数量不足');
        }
//        $is_set = TransferCreditModel::where('uid', $user->id)->where('credit_type', 'credit3')
//            ->where('status', 0)->find();
//        isset($is_set) && $this->error('请耐心上个申请的审核');
        try{
            Db::startTrans();
            $transfer_obj = new TransferCreditModel([
                'uid'=>$user->id,
                'type'=> 0,
                'credit_type'=>$allow_credit->id,
                'amount'=>$post['amount'],
            ]);
            $save = $transfer_obj->save();
            Member::where('id',$user_id)->inc('credit2', $post['amount'])
                ->dec($allow_credit->value, $post['amount'])->update();
            if($save === false){
                throw new Exception('转换失败');
            }
            Db::commit();
        }catch (\Exception $e){
            Db::rollback();
            $this->error('转换失败,请稍后重试');
        }
        $this->success('转换成功');
    }

    // 积分转账
    public function credit_transfer(){
        $post = $this->request->post();
        $user_id = $this->MemberId();
        $user = Member::where('state', '0')->find($user_id);
        empty($user) && $this->error('用户数据错误', [], 'login');
//        $type = $post['type'];
        $rule = [
            'amount|转账金额' => 'require|float',
            'credit_type|转账类型' => 'require|length: 1,100',
            'target_mobile|转账目标Uid' => 'require|number',
            'remark|备注' => 'length: 0,255',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if ($validate !== true) {
            $this->error($validate);
        }
        $amount = $post['amount'];
        if ($amount <= 0 ){
            $this->error('请输入正确的转账金额');
        }
//        $tar_user = Member::where('mobile', $post['target_mobile'])->where('state', 0)->find();
        $tar_user = Member::where('id', $post['target_mobile'])->where('state', 0)->find();
        empty($tar_user) && $this->error('目标用户未注册或被冻结');
        $tar_user->id === $user->id && $this->error('暂不支持给自己转账');
        $allow_credit = CreditType::where('id', $post['credit_type'])->where('is_transfer', 1)->find();
        empty($allow_credit) && $this->error('该类型暂不支持转账');
        if($user->getAttr($allow_credit->value) < $post['amount']){
            $this->error('转账失败,'.$allow_credit->title.'不足');
        }
        $this->PluginApiCD('credit_transfer'.$user_id);
        try{
            $transfer_obj = new TransferCreditModel([
                'uid'=> $user->id,
                'type'=> 1,
                'target_mobile'=> $tar_user->mobile,
                'target_uid'=> $tar_user->id,
                'credit_type'=> $post['credit_type'],
                'amount'=> $post['amount'],
            ]);
            $save = $transfer_obj->save();
            Member::where('id',$user_id)->dec($allow_credit->value, $post['amount'])->update();

            Member::where('id',$tar_user->id)->inc($allow_credit->value, $post['amount'])->update();
            if($save === false){
                throw new Exception('转账失败');
            }
        }catch (\Exception $e){
        $this->error('转账失败,请稍后重试');
        }
        $this->success('转账成功');
    }

    // 积分转账记录
    public function transfer_list()
    {
        $user_id = $this->MemberId();
        $get = $this->request->get();
        $request_status = isset($get['status']) ? $get['status'] : null;
        $order_list = TransferCreditModel::where('uid', $user_id)
            ->where('type', 1)
            ->order('id', 'desc')
            ->hidden(['status', 'type'])
            ->paginatefront($get)
            ->select();
        foreach ($order_list as &$item) {
            $credit_type = CreditType::find($item->credit_type);
            $item->credit_type = $credit_type ? $credit_type->title : null;
        }
        $this->success('请求成功', ['order_list' => $order_list]);
    }

    // 积分被转账记录
    public function be_transfer_list()
    {
        $user_id = $this->MemberId();
        $get = $this->request->get();
        $request_status = isset($get['status']) ? $get['status'] : null;
        $order_list = TransferCreditModel::where('target_uid', $user_id)
            ->where('type', 1)
            ->order('id', 'desc')
            ->hidden(['status', 'type'])
            ->paginatefront($get)
            ->select();
        foreach ($order_list as &$item) {
            $credit_type = CreditType::find($item->credit_type);
            $item->credit_type = $credit_type ? $credit_type->title : null;
        }
        $this->success('请求成功', ['order_list' => $order_list]);
    }



}