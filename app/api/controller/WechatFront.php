<?php


namespace app\api\controller;

use app\common\controller\ApiController;
use app\common\model\WechatPay;
use app\api\service\WeixinPay;

class WechatFront extends ApiController
{
    public function test(){
        $wechat_pay_obj = WechatPay::find(3);
        $wechat_obj = new WeixinPay($wechat_pay_obj->id);
        $wechat_obj->wxpay();

    }

}