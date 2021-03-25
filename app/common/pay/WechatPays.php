<?php


namespace app\common\pay;


use app\common\model\PayLog;
use app\common\model\WechatPay;
use think\facade\Db;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

class WechatPays
{
    protected $config = [
        'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
        'app_id' => 'wxb3fxxxxxxxxxxx', // 公众号 APPID
        'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
        'mch_id' => '14577xxxx',
        'key' => 'mF2suE9sU6Mk1Cxxxxxxxxxxx',
        'notify_url' => 'http://yanda.net.cn/notify.php',
        'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
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
//        'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ];


    public function __construct()
    {
//        parent::__construct();
//        $wechat_pay = empty($wechat) ? WechatPay::where('is_union', 1)->find() : $wechat;
        $wechat_pay = WechatPay::where('is_union', 1)->find();
        $this->config['app_id'] = $wechat_pay->app_id;
        $this->config['app_secret'] = $wechat_pay->app_secret;
        $this->config['mch_id'] = $wechat_pay->merchant_id;
        $this->config['key'] = $wechat_pay->merchant_secret;
        $this->config['cert_client'] = $wechat_pay->cert_file;
        $this->config['cert_key'] = $wechat_pay->key_file;
        $this->config['notify_url'] = 'http://hasog.chengrx.com/api/wechat_front/notify';
    }

    public function init($wechat_pay){
        $this->config['app_id'] = $wechat_pay->app_id;
        $this->config['app_secret'] = $wechat_pay->app_secret;
        $this->config['mch_id'] = $wechat_pay->merchant_id;
        $this->config['key'] = $wechat_pay->merchant_secret;
        $this->config['cert_client'] = $wechat_pay->cert_file;
        $this->config['cert_key'] = $wechat_pay->key_file;
    }


    public function jsapi_index($order, $is_order=true, $notify_url=null, $need_append=false)
    {
        $this->config['notify_url'] = $notify_url ? $notify_url : $this->config['notify_url'];
        $s = new \Hasog\wechat\Wechat();
        $s->init($this->config['app_id'], $this->config['mch_id'], $this->config['key'], $this->config['app_secret']);
        $t =  $s->GetOpenid();
        // 生成支付记录
        $union_wechat = $this->get_union_wechat();

        $pay_log = new PayLog([
            'pay_account'=> $union_wechat->id,
            'status'=> 0,
            'pay_type'=> 1,
            'log_type'=> 1,
            'total_fee'=> 1,
            'create_time'=> time(),
        ]);
        if ($is_order){
            $pay_log['order_sn'] = $order->order_sn;
            $pay_log['amount'] = $order->price;
            $pay_log['uid'] = $order->uid;
        }else {
            $pay_log['amount'] = $order['total_fee'];
            $pay_log['uid'] = $order['uid'];
        }
        $pay_log->save();
        $this->config['notify_url'] .= '/'.$pay_log->id.'/';
        $order_data =[
            'out_trade_no' => time(),
            'body' => '微信充值',
            'openid' => $t,
        ];
        if ($is_order){
            $order_data['total_fee'] = $order->price * 100;
        }else{
            $order_data['total_fee'] = $order['total_fee'] * 100;
        }
        $config = $this->config;
        $result = Pay::wechat($config)->mp($order_data);
        $result = json_encode($result);
//        if ($order){
//            return $result;
//        }else {
        return ['result'=>$result, 'pay_log'=>$pay_log];
//        }
    }

    public function return_pay_obj($notify_url=null)
    {
        $this->config['notify_url'] = $notify_url ? $notify_url : $this->config['notify_url'] ;
        $pay = Pay::wechat($this->config);
        return $pay;
    }

    public function h5_index($order){
        $order = [
            'out_trade_no' => time(),
            'body' => 'subject-测试',
            'total_fee' => '1',
        ];

//        $pay = Pay::wechat($this->config)->mp($order);
        $pay = Pay::wechat($this->config)->wap($order)->send();

    }

    public function get_union_wechat(){
        return WechatPay::where('is_union', 1)->find();
    }

    public function notify()
    {
        $pay = Pay::wechat($this->config);

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }


}