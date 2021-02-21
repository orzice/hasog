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
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------


namespace app\api\controller;

use app\BaseController;
use app\common\controller\ApiController;
use app\common\model\FinaceOfflinepayment;
use app\common\model\FinaceWithdrawset;
use think\facade\Config;
use think\facade\Event;
use app\common\model\FinaceUprecord;
use app\common\model\FinaceIncome;
use app\common\model\FinaceBalanceset;
use app\common\model\FinaceWithdrawalrecord;
use app\common\model\FinaceBalancesub;
use app\common\model\FinaceOfflinewithdrawals;
use app\common\model\Member;

class Finace extends ApiController
{
    //充值记录
    public function uprecord(){
        $id=$this->MemberId();
        $data = FinaceUprecord::where('uid',$id)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //收入明细
    public function income(){
        $id=$this->MemberId();
        $data = FinaceIncome::where('uid',$id)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //提现记录
    public function withdrawalrecord(){
        $id=$this->MemberId();
        $data = FinaceWithdrawalrecord::where('uid',$id)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //余额充值
    public function topup(){
        // type 0微信 1支付宝 2线下
        $post = $this->request->post();
        $id=$this->MemberId();
        $rule = [
            'money|金额'      => 'require|float',
            'type|支付类型'   => 'require|in:0,1,2'
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $set = FinaceBalanceset::select()->toArray();
        if (empty($set)){
            return api_return(0,'账户充值已关闭');
        }
        if ($set[0]['recharge'] !== 1){
            return api_return(0,'账户充值已关闭');
        }
        $money = explode('.',$post['money']);
        if (isset($money['1'])){
            $money =strlen(explode('.',$post['money'])[1]);
            if ($money>3){
                return api_return(0,'金额小数点最多三位数');
            };
        }
        if (strpos($post['money'],'-')!==false){
                 return api_return(0,'金额必须为正整数');
        }
        if (substr($post['money'],0,1)==0){
            return api_return(0,'金额输入有误');
        }
        if ($post['type'] == 2){
            $rule = [
                'thumb|成功图片' =>'require|url',
                'pay_id|线下支付方式'      => 'require|number',
            ];
            $validate = $this->validate($post, $rule);
            //验证失败
            if($validate !== true){
                return api_return(0,$validate);
            }
            $c = FinaceOfflinepayment::where(['thumb'=>$post['thumb']])->find();
            if (!empty($c)){
                return api_return(0,'提交成功,等待审核');
            }
            $time = time();
            $a = FinaceOfflinepayment::insert(['uid'=>$id,'money'=>$post['money'],'state'=>0,'pay_id'=>$post['pay_id'],'a_state'=>0,'thumb'=>$post['thumb'],'create_time'=>$time]);
            if ($a){
                return api_return(1,'提交成功,等待审核');
            }else{
                return api_return(0,'失败');
            }
        }
        //充值返回
        $up = true;
        if ($up !== true){
            return api_return(0,'充值失败');
        }
        $s = json_decode($set[0]['sole'],true);
        $moneys = 0;
        $money = array();
        foreach ($s as $k=>$v){
            if ($post['money']>=$v['enough']){
                $money[$k]['money'] = $v['give'];
            }
        }
        if (!empty($money)){
            $money = max($money);
            if ($set[0]['proportion_status'] == 0){
                $moneys = $money['money'];
            }else{
                $moneys = $post['money']*$money['money']/100;
            }
        }
        $momber = Member::find($id);
        $post['money'] = $moneys+$post['money'];
        $balance = $momber['credit2']+$post['money'];
        $create_time = time();
        try {
            $save = FinaceBalancesub::insert(['uid'=>$id,'balance'=>$balance,'state'=>2,'money'=>$post['money'],'create_time'=>$create_time]);
            $save = Member::update(['id'=>$id,'credit2'=>$balance]);
            $save = FinaceUprecord::insert(['uid'=>$id,'way'=>1,'money'=>$post['money'],'state'=>1,'create_time'=>$create_time]);
        } catch (\Exception $e) {
            return api_return(0,'提交失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'提交成功');}else{return api_return(0,'提交失败');}
    }
    public function withdrawal(){
        $id=$this->MemberId();
        $post = $this->request->post();
        $rule = [
            'money|金额'      => 'require|float',
            'thumb|成功图片'  => 'require|url',
            'pay_id|线下支付方式' => 'require|number',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $set = FinaceWithdrawset::select()->toArray();
        if (empty($set)){
            return api_return(0,'账户提现已关闭');
        }
        if ($set[0]['recharge'] !== 1){
            return api_return(0,'账户提现已关闭');
        }
        $money = explode('.',$post['money']);
        if (isset($money['1'])){
            $money =strlen(explode('.',$post['money'])[1]);
            if ($money>3){
                return api_return(0,'金额小数点最多三位数');
            };
        }
        if (strpos($post['money'],'-')!==false){
            return api_return(0,'金额必须为正整数');
        }
        if (substr($post['money'],0,1)==0){
            return api_return(0,'金额输入有误');
        }

        if ($set['0']['service'] == 1){
            $post['services'] = $set['0']['services'];
        }else{
            $post['services'] = $set['0']['services']*$post['money']/100;
        }
        $momber = Member::find($id);
        if ($momber['credit2'] < $post['money']){
            return api_return(0,'提现失败,余额不足');
        }
        $time = time();
        $mn = $momber['credit2']-$post['money'];
        $mu = -$post['money'];
        Member::where(['id'=>$id])->update(['credit2'=>$mn]);
        $number = time().rand(99999,1000000);
        $cord_id=FinaceWithdrawalrecord::insertGetId(['uid'=>$id,'number'=>$number,'money'=>$post['money'],'numstatus'=>3,'status'=>0,'create_time'=>$time]);
        FinaceBalancesub::insert(['uid'=>$id,'balance'=>$mn,'state'=>3,'money'=>$mu,'create_time'=>$time]);
        $a = FinaceOfflinewithdrawals::insert(['uid'=>$id,'money'=>$post['money'],'procedure'=>$post['services'],'state'=>0,'pay_id'=>$post['pay_id'],'thumb'=>$post['thumb'],'create_time'=>$time,'cord_id'=>$cord_id]);
        if ($a){
            return api_return(1,'提交成功,等待审核');
        }else{
            return api_return(0,'提现失败');
        }
    }
    //查询提现设置
    public function withdrawalset(){
        $set = FinaceWithdrawset::select()->toArray();
        if (empty($set)){
            return api_return(0,'账户提现已关闭');
        }
        if ($set[0]['recharge'] !== 1){
            return api_return(0,'账户提现已关闭');
        }
        $data = array();
        if ($set[0]['manual_wechat']==1){
            $data['manual'][] = ['id' => 0,'name'=>'微信'];
        }
        if ($set[0]['manual_alipay'] ==1){
            $data['manual'][] = ['id' => 1,'name'=>'支付宝'];
        }
        $data['service'] = $set[0]['service'];
        $data['services'] = $set[0]['services'];
        return api_return(1,'查询成功',$data);
    }
}