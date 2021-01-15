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
// | DateTime：2021-01-04 17:44:47
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
//        $user_id = 1;
        $user_id === false && $this->error('请先登录');
        $user = Member::where('state', '0')->find($user_id)->hidden(['password', 'salt', '']);
        $this->success('获取用户信息成功', ['user_info'=> $user->toArray()]);
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
//                'captcha|验证码'=> 'require|length:3,6',
            ];
            $validate = $this->validate($post, $rule);
            if ($validate !== true){
                $this->error($validate);
            }
//            $captcha = isset($post['captcha'])  ? $post['captcha'] : 'null';
//            if (!captcha_check($captcha)){
//                $this->error('验证码错误');
//            }
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
                'password|用户密码' => 'require|length:6,40',
//                'repassword|再次输入密码' => 'require|length:4,40|confirm:password',
//                'captcha|验证码'=> 'require|length:3,6',
            ];
            $validate = $this->validate($post, $rule);
            if ($validate !== true){
                $this->error($validate);
            }
            //验证失败
//            $captcha = isset($post['captcha'])  ? $post['captcha'] : 'null';
//            if (!captcha_check($captcha)){
//                $this->error('验证码错误');
//            }
            $isset_phone = Member::where('mobile', $post['mobile'])->find();
            !empty($isset_phone) && $this->error('该手机号已注册');
            $post['password'] = U_password($post['password']);
            $array = ['mobile'=> $post['mobile'], 'password'=>$post['password']];
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