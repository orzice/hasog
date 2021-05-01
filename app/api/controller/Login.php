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
// | DateTime：2021-02-17 15:12:21
// +----------------------------------------------------------------------

namespace app\api\controller;

use app\common\controller\ApiController;

use app\common\service\SmsService;
use think\captcha\Captcha;
use think\facade\Request;
use app\common\Plugins;
use app\common\model\Member;
use think\middleware\CheckRequestCache;

class Login extends ApiController
{
    //当前登录用户
    public function state()
    {
        $user_id = $this->MemberId();
//        $user_id === false && $this->error('请先登录');
        if($user_id === false){
            return api_return(0, '请先登录');
        }
        $user = Member::where('state', '0')->find($user_id);
//        empty($user) && $this->error('该用户不存在或被冻结');
        if(empty($user)){
            return api_return(0, '该用户不存在或被冻结');
        }
        $user = $user->hidden(['password', 'salt', '']);
        $orders = $user->orders();
        $order_paid = $user->orders()->where('status', 1)->select()->count();  //待发货(已付款)
        $order_daifukuan = $user->orders()->where('status', 0)->select()->count();// 待付款
        $order_receive = $user->orders()->where('status', 2)->select()->count(); // 待收货(已发货)
        $order_apply = $user->orders()->where('status', -2)->select()->count(); //申请退款
        $order_applied = $user->orders()->where('status', -3)->select()->count(); //申请退款
        $order_complete = $user->orders()->where('status', 3)->select()->count(); //已完成
        $order_cancel = $user->orders()->where('status', -1)->select()->count(); //已取消
        $order_all_amount = $user->orders()->select()->count();
        $order_merge = $user->orders()->whereIn('status', [-2, -3])->select()->count(); // 合并申请退款和已退款状态
        $order_count = [
            -3=>['name'=>'已退款', 'amount'=>$order_apply],
            -2=>['name'=>'申请退款', 'amount'=>$order_apply],
//            -1=>['name'=>'已取消', 'amount'=>$order_cancel],
            -1=>['name'=>'已取消', 'amount'=>$order_merge], // 暂时使用合并退款，等前台抽空将状态改为-2
            0=>['name'=>'待付款', 'amount'=>$order_daifukuan],
            1=>['name'=>'待发货', 'amount'=>$order_paid],
            2=>['name'=>'待收货', 'amount'=>$order_receive],
            3=>['name'=>'已完成', 'amount'=>$order_complete],
            ];
        // $user->credit2 = floor($user->credit2 * 100)/100;
        // $user->credit4 = floor($user->credit4 * 100)/100;
//        $this->success('获取用户信息成功', ['user_info'=> $user->toArray(), 'order_count'=>$order_count, 'order_all_count'=>$order_all_amount]);
        return api_return(1, '获取用户信息成功', ['user_info'=> $user->toArray(), 'order_count'=>$order_count, 'order_all_count'=>$order_all_amount]);

    }

    //登录
    public function index()
    {
        $user_session = $this->MemberId();
        if (!$user_session) {
            $post = $this->request->post();
            $rule = [
                'mobile|用户手机号' => 'require|mobile',
                'password|用户密码' => 'require|length:4,40',
                'captcha|验证码'=> 'require|length:3,6',
            ];
            $validate = $this->validate($post, $rule);
            if ($validate !== true){
//                $this->error($validate);
                return api_return(0, $validate);
            }
            $captcha = isset($post['captcha'])  ? $post['captcha'] : 'null';
            if (!captcha_check($captcha)){
//                $this->error('验证码错误');
                return api_return(0, '验证码错误');
            }
            //验证失败
            $user = Member::where(['mobile' => $post['mobile']])->find();
//            empty($user) && $this->error('用户名或密码错误');
            if(empty($user)){
                return api_return(0, '用户名或密码错误');
            }
            $is_user = (U_password($post['password']) == $user->password);
            !$is_user && $this->error('用户名或密码错误');
            if(!$is_user){
                return api_return(0, '用户名或密码错误');
            }
            Sessions("member_id", $user->id);
//            $this->success('登录成功了哦');
            return api_return(1, '登录成功了哦');
        }
//        $this->error('您已登录');
        return api_return(0, '您已登录');
    }

    /**
     * 验证码
     * @return \think\Response
     */
    public function captcha()
    {
        return \think\captcha\facade\Captcha::create();
    }

    //注册
    public function register()
    {
//        session('member');die();
        $user_session = $this->MemberId();
        if (!$user_session) {
            $post = $this->request->post();
            $rule = [
                'mobile|用户手机号' => 'require|mobile',
                'password|用户密码' => 'require|length:6,20',
                'repassword|再次输入密码' => 'require|confirm:password',
                'parent_id|推荐人ID'=> 'number|length:1,8',
            ];
            $message_status = sysconfig('sms', 'message_status');
            // 开启手机验证码
            if ($message_status==1) {
                $rule['code|手机验证码'] = 'require|number';
                $validate = $this->validate($post, $rule);
                if ($validate !== true){
//                $this->error($validate);
                    return api_return(0, $validate);
                }
                //验证手机验证码
                $sms = new SmsService();
                $sms->init();
                $codes = $sms->Code($post['mobile']);
                if (!$codes) {
                    return api_return(0, '手机验证码错误');
                }
                if ($codes !== $post['code']) {
                    return api_return(0, '手机验证码错误');
                }
            }else{// 未开启手机验证码
                $rule['captcha|验证码'] = 'require|length:3,6';
                $validate = $this->validate($post, $rule);
                if ($validate !== true){
//                $this->error($validate);
                    return api_return(0, $validate);
                }
                //验证失败
                $captcha = isset($post['captcha'])  ? $post['captcha'] : 'null';
                if (!captcha_check($captcha)){
//                $this->error('验证码错误');
                    return api_return(0, '验证码错误');
                }
            }
            $isset_phone = Member::where('mobile', $post['mobile'])->find();
            if(!empty($isset_phone)){
                return api_return(0, '该手机号已注册');
            }
            $post['password'] = U_password($post['password']);
            $parent_id = isset($post['parent_id'])? $post['parent_id'] : null;
            $array = ['mobile'=> $post['mobile'], 'password'=>$post['password']];
            //请判断推荐人是否存在！
            if (!empty($parent_id)) {
               $parent = Member::where('id', $parent_id)->find();
               !empty($parent) && $array['parent_id'] = $parent_id;
            }
            // !empty($parent_id) && $array['parent_id'] = $parent_id;
            try {
                $user = new Member();
                $result = $user->save($array);
            } catch (\Exception $e) {
//                $this->error('注册失败,请稍后重试哦');
                return api_return(0, '注册失败,请稍后重试哦');
            }
            if($result !== false){
                // 开启手机验证码
                if ($message_status==1) {
                    $sms->Code($post['mobile'], -1);
                }
                return api_return(1, '注册成功');
            }else{
                return api_return(0, '注册失败');
            }
//            $result ? $this->success('注册成功') : $this->error('注册失败');
        }
//        $this->error('您已登录');
        return api_return(0, '您已登录');
    }

    //找回密码
    public function lostpasswd()
    {

    }

    //发送短信
    public function mobile(){
        $message_status = sysconfig('sms', 'message_status');
        if ($message_status === 0){
            return api_return(0, '获取验证码失败，短信验证未开启');
        }
        $user_session = $this->MemberId();
        if ($user_session) {
//            return $this->error('您已登录',[],__urls('clouduser/Index/index'));
            return api_return(0, '您已登录');
        }

        $post = $this->request->post();
        $rule = [
            'username|手机号'      => 'require|mobile',
            'captcha|验证码'       => 'require|captcha',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            $data = array(
                "error" => "1",
                "value" => $validate,
            );
            return api_return(0, $validate);
        }
        $mobile = $post["username"];


        //验证账号是否存在
        $row = Member::where("mobile",$mobile)->find();
        if ($row !== null) {
            $data = array(
                "error" => "1",
                "value" => "账号已注册",
            );
            return api_return(0, '账号已注册');
        }

        $sms = new SmsService();
        $sms->init();
        $code = yanzhengma(6);

        $tz = $sms->MobileCd($mobile);
        if (!$tz) {
            $data = array(
                "error" => "1",
                "value" => $sms->Error(),
                // "code" => $code,
            );
            return api_return(0, $sms->Error());
        }
        $fs = true;
        $fs = $sms->GoSmSCode($mobile,$code);
        $sms->MobileCd($mobile,1);
        $sms->Code($mobile,$code);
        if (!$fs) {
            $data = array(
                "error" => "1",
                "value" => $sms->Error(),
                // "code" => $code,
            );
            return api_return(0, $sms->Error());
        }


        $data = array(
            "error" => "0",
            "value" => "发送成功",
            // "code" => $code,
        );
        return api_return(1, '发送成功');
    }

    //是否开启短息验证码
    public function message_state(){
        $status = sysconfig('sms', 'message_status');
        $data = ['status'=>$status];
        return api_return(1, '请求成功', $data);

    }


    // 用户退出
    public function user_out()
    {
        $user_id = $this->MemberId();
//        $user_id = 1;
//        $user_id === false && $this->error('请先登录');
        if($user_id === false){
            return api_return(0, '请先登录');
        }
        Sessions('member_id', null);
//        $this->success('退出登录成功了哦');
        return api_return(1, '退出登录成功了哦');
    }
}