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
use app\common\model\AliPay;
use app\common\model\FinaceOfflinepayment;
use app\common\model\FinaceWithdrawset;
use app\common\pay\AliPays;
use think\facade\Config;
use think\facade\Db;
use think\facade\Event;
use app\common\model\FinaceUprecord;
use app\common\model\FinaceIncome;
use app\common\model\FinaceBalanceset;
use app\common\model\FinaceWithdrawalrecord;
use app\common\model\FinaceBalancesub;
use app\common\model\FinaceOfflinewithdrawals;
use app\common\model\Member;
use Yansongda\Pay\Pay;
use app\common\pay\WechatPays;
use app\common\model\WechatPay;

class Finace extends ApiController
{
    //充值记录
    public function uprecord(){
        $id=$this->MemberId();
        $post = $this->request->post();
        $data = FinaceUprecord::where('uid',$id)->paginatefront($post)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(1,'查询成功',[]);
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //收入明细
    public function income(){
        $id=$this->MemberId();
        $post = $this->request->post();
        $data = FinaceIncome::where('uid',$id)->paginatefront($post)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(1,'查询成功',[]);
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //提现记录
    public function withdrawalrecord(){
        $id=$this->MemberId();
        $post = $this->request->post();
        $data = FinaceWithdrawalrecord::where('uid',$id)->paginatefront($post)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(1,'查询成功',[]);
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //余额充值
    public function topup(){
        // type 0微信 1支付宝 2线下
        $post = $this->request->get();
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
                 return api_return(0,'金额必须为正数');
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
        elseif ($post['type']==0){
            $wechat_pay = new WechatPays();
            $pay = WechatPay::where('is_union',1)->find();
            if (empty($pay)){
                return api_return(0,'微信支付通道已关闭');
            }
            $data = ['total_fee'=>$post['money'],'uid'=> $id];

            $result = $wechat_pay->jsapi_index($data, false,$this->request->domain().'/api/wechat_front/wechat_balance/', true );
            $pay_log = $result['pay_log'];
            $result = $result['result'];
//            $user = Member::find($id);
            $this->assign('uid', $id);
            $this->assign('pay_log', $pay_log);
            $this->assign('amount', $post['money']);
            $this->assign('jsApiParameters', $result);
            $this->assign('redirect_url', 'http://hasog.chengrx.com/#/paySuccess');

            return $this->fetch('/pay/wechat/jsapi_balance');

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
                $save = FinaceBalancesub::insert(['uid'=>$id,'balance'=>$balance,'state'=>2,'money'=>$post['money'],'create_time'=>$create_time,'credit_type'=>'1']);
                $save = Member::update(['id'=>$id,'credit2'=>$balance]);
                $save = FinaceUprecord::insert(['uid'=>$id,'way'=>1,'money'=>$post['money'],'state'=>1,'create_time'=>$create_time,'credit_type'=>'1']);
            } catch (\Exception $e) {
                return api_return(0,'提交失败:'.$e->getMessage());
            }
        }
        elseif ($post['type']==1){
            $ali_pay = new AliPays();
            $pay = AliPay::where('is_union',1)->find();
            if (empty($pay)){
                return api_return(0,'阿里支付通道已关闭');
            }
            $data = ['total_fee'=>$post['money'],'uid'=> $id];
            $return_url = $this->request->domain().'/api/ali_front/ali_balance_return/';
            $result = $ali_pay->jsapi_index($data, false,$this->request->domain().'/api/ali_front/ali_balance/',  $return_url);
            $pay_log = $result['pay_log'];
            $result = $result['result'];
//            $user = Member::find($id);
            $this->assign('uid', $id);
            $this->assign('pay_log', $pay_log);
            $this->assign('amount', $post['money']);
            $this->assign('jsApiParameters', $result);
            $this->assign('redirect_url', $this->request->domain().'/#/paySuccess');

            return $this->fetch('/pay/wechat/jsapi_balance');

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
                $save = FinaceBalancesub::insert(['uid'=>$id,'balance'=>$balance,'state'=>2,'money'=>$post['money'],'create_time'=>$create_time,'credit_type'=>'1']);
                $save = Member::update(['id'=>$id,'credit2'=>$balance]);
                $save = FinaceUprecord::insert(['uid'=>$id,'way'=>1,'money'=>$post['money'],'state'=>1,'create_time'=>$create_time,'credit_type'=>'1']);
            } catch (\Exception $e) {
                return api_return(0,'提交失败:'.$e->getMessage());
            }
        }
        else{

        }

        if ($save){return api_return(1,'提交成功');}else{return api_return(0,'提交失败');}
    }
    public function ceshi(){
        $s = new \Hasog\wechat\Wechat();
        $s->init('wxd5093ac3d5c139a0','1604006877','c292d794d2ae3227726637fae6c5d5ca','c292d794d2ae3227726637fae6c5d5ca');
        $t =  $s->GetOpenid();
        $config = $this->config();
        // print_r($openid);
        // print_r($config);
        // exit;
        $order =[
            'out_trade_no' => time(),
            'body' => '微信充值',
            'total_fee'      => '10',
            // 'openid'      => 'oTSxF6w3cOJ29rhRd6uFxma3cMRw',
            'openid' => $t,
        ];
        
        $result = Pay::wechat($config)->mp($order);
		$result = json_encode($result);
        print_r($result);
    }
    public function config(){
        $config = [
            'app_id' => 'wxd5093ac3d5c139a0', // 公众号 APPID
            'mch_id' => '1604006877',
            'key' => 'c292d794d2ae3227726637fae6c5d5ca',
            'notify_url' => 'http://yanda.net.cn',
            'cert_client' => './cert/apiclient_cert.pem', // optional, 退款，红包等情况时需要用到
            'cert_key' => './cert/apiclient_key.pem',// optional, 退款，红包等情况时需要用到
            'log' => [ // optional
                'file' => './logs/wechat.log',
                'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            // 'mode' => 'dev',
        ];
return $config;
    }
    public function withdrawal(){
        $id=$this->MemberId();
        $post = $this->request->post();
        $rule = [
            'money|金额'      => 'require|float',
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
        if ($post['pay_id'] == 0){
            $rule = [
                'thumb|收款码'  => 'require|url',
            ];
            $validate = $this->validate($post, $rule);
            //验证失败
            if($validate !== true){
                return api_return(0,$validate);
            }
        }else{
            $rule = [
                'alipaystates|支付宝类型'  => 'require|number',
            ];
            $validate = $this->validate($post, $rule);
            //验证失败
            if($validate !== true){
                return api_return(0,$validate);
            }
            if ($post['alipaystates'] == 0){
                $rule = [
                    'thumb|收款码'  => 'require|url',
                ];
                $validate = $this->validate($post, $rule);
                //验证失败
                if($validate !== true){
                    return api_return(0,$validate);
                }
            }else{
                $rule = [
                    'alipaynumber|支付宝账号'  => 'require|email',
                    'alipayname|支付宝姓名'  => 'require|max:10',
                ];
                $validate = $this->validate($post, $rule);
                //验证失败
                if($validate !== true){
                    $rule = [
                        'alipayname|支付宝姓名'  => 'require|max:5',
                        'alipaynumber|支付宝账号'  => 'require|mobile',
                    ];
                    $validate = $this->validate($post, $rule);
                    //验证失败
                    if($validate !== true){
                        return api_return(0,$validate);
                    }
                }

            }
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
        $this->PluginApiCD('withdrawal'.$id);
        Member::where('id',$id)->dec('credit2',$post['money'])->update();
        // Member::where(['id'=>$id])->update(['credit2'=>$mn]);
        $number = time().rand(99999,1000000);
        $remark = '提现前余额:'.$momber['credit2'].'->提现后余额:'.$mn;


        $cord_id=FinaceWithdrawalrecord::insertGetId(['remark'=>$remark,'before_balance'=>$momber['credit2'],'after_balance'=>$mn,'uid'=>$id,'number'=>$number,'money'=>$post['money'],'numstatus'=>3,'status'=>0,'create_time'=>$time]);
        FinaceBalancesub::insert(['credit_type'=>'1','uid'=>$id,'balance'=>$mn,'state'=>3,'money'=>$mu,'create_time'=>$time,'before_balance'=>$momber['credit2'],'remark'=>$remark]);
        if ($post['pay_id'] == 0){
            $a = FinaceOfflinewithdrawals::insert(['uid'=>$id,'money'=>$post['money'],'procedure'=>$post['services'],'state'=>0,'pay_id'=>$post['pay_id'],'thumb'=>$post['thumb'],'create_time'=>$time,'cord_id'=>$cord_id,'alipaystates'=>0]);
        }else{
            if ($post['alipaystates'] == 0){
                $a = FinaceOfflinewithdrawals::insert(['uid'=>$id,'money'=>$post['money'],'procedure'=>$post['services'],'state'=>0,'pay_id'=>$post['pay_id'],'thumb'=>$post['thumb'],'create_time'=>$time,'cord_id'=>$cord_id,'alipaystates'=>0]);
            }else{
                $a = FinaceOfflinewithdrawals::insert(['uid'=>$id,'money'=>$post['money'],'procedure'=>$post['services'],'state'=>0,'pay_id'=>$post['pay_id'],'alipaynumber'=>$post['alipaynumber'],'alipayname'=>$post['alipayname'],'alipaystates'=>1,'thumb'=>0,'create_time'=>$time,'cord_id'=>$cord_id]);
            }
        }

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
    //充值余额设置
    public function topupset(){
        $set = FinaceBalanceset::select()->toArray();
        if (empty($set)){
            return api_return(0,'账户充值已关闭');
        }
        if ($set[0]['recharge'] !== 1){
            return api_return(0,'账户充值已关闭');
        }
        $data = array();
        if ($set[0]['manual_wechat']==1){
            $data['manual'][] = ['id' => 1,'name'=>'微信'];
        }
        if ($set[0]['manual_alipay'] ==1){
            $data['manual'][] = ['id' => 2,'name'=>'支付宝'];
        }
        if ($set[0]['manual_offline'] ==1){
            $data['manual'][] = ['id' => 3,'name'=>'线下'];
        }
        return api_return(1,'查询成功',$data);
    }
}