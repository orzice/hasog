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
// | Author：Orzice(小涛)  https://gitee.com/orzice / 王火火(王琰豪)  https://gitee.com/w321
// +----------------------------------------------------------------------
// | DateTime：2021-02-17 15:12:21
// +----------------------------------------------------------------------

namespace app\api\controller;

use app\common\controller\ApiController;

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
        $user_id === false && $this->error('请先登录');
        $user = Member::where('state', '0')->find($user_id);
        empty($user) && $this->error('该用户不存在或被冻结');
        $user = $user->hidden(['password', 'salt', '']);
        $orders = $user->orders();
        $order_paid = $user->orders()->where('status', 1)->select()->count();  //待发货(已付款)
        $order_daifukuan = $user->orders()->where('status', 0)->select()->count();// 待付款
        $order_receive = $user->orders()->where('status', 2)->select()->count(); // 待收货(已发货)
        $order_apply = $user->orders()->where('status', -2)->select()->count(); //申请退款
        $order_complete = $user->orders()->where('status', 3)->select()->count(); //已完成
        $order_cancel = $user->orders()->where('status', -1)->select()->count(); //已取消
        $order_all_amount = $user->orders()->select()->count();
        $order_count = [
            -2=>['name'=>'申请退款', 'amount'=>$order_apply],
            -1=>['name'=>'已取消', 'amount'=>$order_cancel],
            0=>['name'=>'待付款', 'amount'=>$order_daifukuan],
            1=>['name'=>'待发货', 'amount'=>$order_paid],
            2=>['name'=>'待收货', 'amount'=>$order_receive],
            3=>['name'=>'已完成', 'amount'=>$order_complete],
            ];
        $this->success('获取用户信息成功', ['user_info'=> $user->toArray(), 'order_count'=>$order_count, 'order_all_count'=>$order_all_amount]);
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
                $this->error($validate);
            }
            $captcha = isset($post['captcha'])  ? $post['captcha'] : 'null';
            if (!captcha_check($captcha)){
                $this->error('验证码错误');
            }
            //验证失败
            $user = Member::where(['mobile' => $post['mobile']])->find();
            empty($user) && $this->error('用户名或密码错误');
            $is_user = (U_password($post['password']) == $user->password);
            !$is_user && $this->error('用户名或密码错误');
            Sessions("member_id", $user->id);
            $this->success('登录成功了哦');
        }
        $this->error('您已登录');
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
                'captcha|验证码'=> 'require|length:3,6',
                'parent_id|推荐人ID'=> 'number|length:1,8',
            ];
            $validate = $this->validate($post, $rule);
            if ($validate !== true){
                $this->error($validate);
            }

            //验证失败
            $captcha = isset($post['captcha'])  ? $post['captcha'] : 'null';
            if (!captcha_check($captcha)){
                $this->error('验证码错误');
            }
            $isset_phone = Member::where('mobile', $post['mobile'])->find();
            !empty($isset_phone) && $this->error('该手机号已注册');
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
                $this->error('注册失败,请稍后重试哦');
            }
            $result ? $this->success('注册成功') : $this->error('注册失败');
        }
        $this->error('您已登录');
    }

    //找回密码
    public function lostpasswd()
    {

    }

    // 用户退出
    public function user_out()
    {
        $user_id = $this->MemberId();
//        $user_id = 1;
        $user_id === false && $this->error('请先登录');
        Sessions('member_id', null);
        $this->success('退出登录成功了哦');
    }
}