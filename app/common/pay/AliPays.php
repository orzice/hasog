<?php


namespace app\common\pay;


use app\common\model\AliPay;
use app\common\model\PayLog;
//use app\common\model\WechatPay;
use think\facade\Db;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

class AliPays
{
    protected $config = [
        'app_id' => '2016082000295641',
        'notify_url' => 'http://yansongda.cn/notify.php',
        'return_url' => 'http://yansongda.cn/return.php',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuWJKrQ6SWvS6niI+4vEVZiYfjkCfLQfoFI2nCp9ZLDS42QtiL4Ccyx8scgc3nhVwmVRte8f57TFvGhvJD0upT4O5O/lRxmTjechXAorirVdAODpOu0mFfQV9y/T9o9hHnU+VmO5spoVb3umqpq6D/Pt8p25Yk852/w01VTIczrXC4QlrbOEe3sr1E9auoC7rgYjjCO6lZUIDjX/oBmNXZxhRDrYx4Yf5X7y8FRBFvygIE2FgxV4Yw+SL3QAa2m5MLcbusJpxOml9YVQfP8iSurx41PvvXUMo49JG3BDVernaCYXQCoUJv9fJwbnfZd7J5YByC+5KM4sblJTq7bXZWQIDAQAB',
        // 加密方式： **RSA2**
        'private_key' => 'MIIEpAIBAAKCAQEAs6+F2leOgOrvj9jTeDhb5q46GewOjqLBlGSs/bVL4Z3fMr3p+Q1Tux/6uogeVi/eHd84xvQdfpZ87A1SfoWnEGH5z15yorccxSOwWUI+q8gz51IWqjgZxhWKe31BxNZ+prnQpyeMBtE25fXp5nQZ/pftgePyUUvUZRcAUisswntobDQKbwx28VCXw5XB2A+lvYEvxmMv/QexYjwKK4M54j435TuC3UctZbnuynSPpOmCu45ZhEYXd4YMsGMdZE5/077ZU1aU7wx/gk07PiHImEOCDkzqsFo0Buc/knGcdOiUDvm2hn2y1XvwjyFOThsqCsQYi4JmwZdRa8kvOf57nwIDAQABAoIBAQCw5QCqln4VTrTvcW+msB1ReX57nJgsNfDLbV2dG8mLYQemBa9833DqDK6iynTLNq69y88ylose33o2TVtEccGp8Dqluv6yUAED14G6LexS43KtrXPgugAtsXE253ZDGUNwUggnN1i0MW2RcMqHdQ9ORDWvJUCeZj/AEafgPN8AyiLrZeL07jJz/uaRfAuNqkImCVIarKUX3HBCjl9TpuoMjcMhz/MsOmQ0agtCatO1eoH1sqv5Odvxb1i59c8Hvq/mGEXyRuoiDo05SE6IyXYXr84/Nf2xvVNHNQA6kTckj8shSi+HGM4mO1Y4Pbb7XcnxNkT0Inn6oJMSiy56P+CpAoGBAO1O+5FE1ZuVGuLb48cY+0lHCD+nhSBd66B5FrxgPYCkFOQWR7pWyfNDBlmO3SSooQ8TQXA25blrkDxzOAEGX57EPiipXr/hy5e+WNoukpy09rsO1TMsvC+v0FXLvZ+TIAkqfnYBgaT56ku7yZ8aFGMwdCPL7WJYAwUIcZX8wZ3dAoGBAMHWplAqhe4bfkGOEEpfs6VvEQxCqYMYVyR65K0rI1LiDZn6Ij8fdVtwMjGKFSZZTspmsqnbbuCE/VTyDzF4NpAxdm3cBtZACv1Lpu2Om+aTzhK2PI6WTDVTKAJBYegXaahBCqVbSxieR62IWtmOMjggTtAKWZ1P5LQcRwdkaB2rAoGAWnAPT318Kp7YcDx8whOzMGnxqtCc24jvk2iSUZgb2Dqv+3zCOTF6JUsV0Guxu5bISoZ8GdfSFKf5gBAo97sGFeuUBMsHYPkcLehM1FmLZk1Q+ljcx3P1A/ds3kWXLolTXCrlpvNMBSN5NwOKAyhdPK/qkvnUrfX8sJ5XK2H4J8ECgYAGIZ0HIiE0Y+g9eJnpUFelXvsCEUW9YNK4065SD/BBGedmPHRC3OLgbo8X5A9BNEf6vP7fwpIiRfKhcjqqzOuk6fueA/yvYD04v+Da2MzzoS8+hkcqF3T3pta4I4tORRdRfCUzD80zTSZlRc/h286Y2eTETd+By1onnFFe2X01mwKBgQDaxo4PBcLL2OyVT5DoXiIdTCJ8KNZL9+kV1aiBuOWxnRgkDjPngslzNa1bK+klGgJNYDbQqohKNn1HeFX3mYNfCUpuSnD2Yag53Dd/1DLO+NxzwvTu4D6DCUnMMMBVaF42ig31Bs0jI3JQZVqeeFzSET8fkoFopJf3G6UXlrIEAQ==',
        // 使用公钥证书模式，请配置下面两个参数，同时修改ali_public_key为以.crt结尾的支付宝公钥证书路径，如（./cert/alipayCertPublicKey_RSA2.crt）
        // 'app_cert_public_key' => './cert/appCertPublicKey.crt', //应用公钥证书路径
        // 'alipay_root_cert' => './cert/alipayRootCert.crt', //支付宝根证书路径
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];

    public function __construct()
    {
        $alipay = AliPay::where('is_union', 1)->find();
        $this->config['app_id'] = $alipay->app_id;
        $this->config['private_key'] = $alipay->rsa_private_key;
        $this->config['ali_public_key'] = $alipay->rsa_public_key;
    }

    public function init($alipay){
        $this->config['app_id'] = $alipay->app_id;
        $this->config['private_key'] = $alipay->rsa_private_key;
        $this->config['ali_public_key'] = $alipay->rsa_public_key;
    }

    public function jsapi_index($order, $is_order=true, $notify_url=null, $need_append=false)
    {
        $this->config['notify_url'] = $notify_url ? $notify_url : $this->config['notify_url'];
//        $s = new \Hasog\wechat\Wechat();
//        $s->init($this->config['app_id'], $this->config['mch_id'], $this->config['key'], $this->config['app_secret']);
//        $t =  $s->GetOpenid();
        // 生成支付记录
        $union_ali = $this->get_union_ali();

        $pay_log = new PayLog([
            'pay_account'=> $union_ali->id,
            'status'=> 0,
            'pay_type'=> 2,
            'log_type'=> 1,
//            'total_fee'=> 0,
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
            'subject' => '阿里充值',
        ];
        if ($is_order){
            $order_data['total_amount'] = $order->price * 100;
        }else{
            $order_data['total_amount'] = $order['total_fee'] * 100;
        }
        $config = $this->config;
        $result = Pay::alipay($config)->wap($order_data)->send();
        $result = json_encode($result);
//        if ($order){
//            return $result;
//        }else {
        return ['result'=>$result, 'pay_log'=>$pay_log];
//        }
    }

/*    public function index()
    {
        $order = [
            'out_trade_no' => time(),
            'total_amount' => '1',
            'subject' => 'test subject - 测试',
        ];

        $alipay = Pay::alipay($this->config)->web($order);

        return $alipay->send();// laravel 框架中请直接 `return $alipay`
    }*/

    public function return()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }

    public function notify()
    {
        $alipay = Pay::alipay($this->config);

        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }

    public function get_union_ali(){
        return AliPay::where('is_union', 1)->find();
    }

    public function return_pay_obj($notify_url=null)
    {
        $this->config['notify_url'] = $notify_url ? $notify_url : $this->config['notify_url'] ;
        $pay = Pay::alipay($this->config);
        return $pay;
    }

}