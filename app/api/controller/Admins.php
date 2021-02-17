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
use app\common\model\AdminsPayment;
use think\facade\Config;
use think\facade\Event;
use app\common\model\AdminsFeedback;
use app\common\model\AliPay;
use app\common\model\WechatPay;

class admins extends ApiController
{
    //提交反馈 *图片未做
    public function feedbackadd(){
        $post = $this->request->post();
        $id=$this->MemberId();
        $rule = [
            'text|内容'      => 'require|chsDash|max:3',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $post['uid']=$id;
        $post['state']=0;
        $post['create_time']=time();
        try {
            $save = AdminsFeedback::insert($post);
        } catch (\Exception $e) {
            return api_return(0,'提交失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'提交成功');}else{return api_return(0,'提交失败');}
    }

    //反馈列表
    public function feedbackindex(){
        $id=$this->MemberId();
        $data = AdminsFeedback::where('uid',$id)->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //获取支付宝配置
    public function alipay(){
        $data = AliPay::where('open_status',1)->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);

    }
    //获取微信配置
    public function wechatpay(){
        $data =WechatPay::where('open_status',1)->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //获取线下支付配置
    public function payment(){
        $data = AdminsPayment::where('state',1)->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
}