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
// | DateTime：2021-03-23 10:12:58
// +----------------------------------------------------------------------

namespace app\common\service;

use app\common\model\Member;
use think\facade\Db;
use think\facade\Cache;


use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Sms\V20190711\SmsClient;
use TencentCloud\Sms\V20190711\Models\SendSmsRequest as TenSendSmsRequest;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest as AliSendSmsRequest;

// 短信服务
class SmsService
{
    private static $type = false;
    private static $max = 5;
    private static $je = 60;
    private static $error = false;
    public function init()
    {
        self::$max = sysconfig('default','sms_max');
        self::$je = sysconfig('default','sms_fz');
        self::$type = sysconfig('default','sms_new_type');
    }
    /**
     *  验证码验证服务 3
     */
    public function Code($mobile=false,$code=0)
    {
        if ($code == -1) {//删除Code
            Cache::store('redis')->delete('sms_code_'.$mobile);

            return true;

        }else if ($code == 0) {//查询Code
            $max = Cache::store('redis')->get('sms_code_'.$mobile);
            if (!$max) {
                self::$error = '数据不存在！';
                return false;
            }
            return $max;

        }else{
            //创建Code
            Cache::store('redis')->set('sms_code_'.$mobile,$code,300);//默认储存5分钟
            return true;
        }

    }

    /**
     *  发送短信验证码
     */
    public function GoSmSCode($mobile=false,$Code=false)
    {
        if (!$mobile || $mobile == '') {
            self::$error = '手机号不能为空';
            return false;
        }
        $code = $Code;
        if (!$Code) {
            $code = yanzhengma(6);
        }

        //储存KEY
        $this->Code($mobile,$code);

        $sms = [];
        $sms['tx_secretid'] = sysconfig('default','txsms_secret_id');
        $sms['tx_secretkey'] = sysconfig('default','txsms_secret_key');
        $sms['tx_tmplateid'] = sysconfig('default','txsms_template_id');
        $sms['tx_smssdkappid'] = sysconfig('default','txsms_appid');
        $sms['tx_signname'] = sysconfig('default','txsms_signname');
        $sms['tx_fz'] = 5;//5分钟

        $sms['al_accessKeyId'] = sysconfig('default','alisms_appkey');
        $sms['al_accessKeySecret'] = sysconfig('default','alisms_secret');
        $sms['al_template_id'] = sysconfig('default','alisms_template_id');
        // case 'txsms'://腾讯云
        // case 'alisms'://阿里云
        switch (self::$type) {
            case 'txsms'://腾讯云

                    try {
                        $cred = new Credential($sms['tx_secretid'], $sms['tx_secretkey']);
                        $httpProfile = new HttpProfile();
                        $httpProfile->setEndpoint("sms.tencentcloudapi.com");
                          
                        $clientProfile = new ClientProfile();
                        $clientProfile->setHttpProfile($httpProfile);
                        $client = new SmsClient($cred, "", $clientProfile);
                    
                        $req = new TenSendSmsRequest();
                        
                        $params = array(
                            "PhoneNumberSet" => array(
                                '+86'.$mobile
                            ),
                            "TemplateID" =>  strval($sms["tx_tmplateid"]),
                            "Sign" => $sms["tx_signname"],
                            "TemplateParamSet" => array(
                                strval($code),
                                strval($sms["tx_fz"])
                            ),
                            "SmsSdkAppid" => strval($sms["tx_smssdkappid"])
                        );
                        $req->fromJsonString(json_encode($params));
                    
                        $resp = $client->SendSms($req);
                    }catch(TencentCloudSDKException $e) {
                        self::$error = '发送失败，请稍后再试';
                        return false;
                    }
                
                break;
            case 'alisms'://阿里云

                    try {
                        $config = [
                            // 您的AccessKey ID
                            "accessKeyId" => $sms['al_accessKeyId'],
                            // 您的AccessKey Secret
                            "accessKeySecret" => $sms['al_accessKeySecret'],
                            // 访问的域名
                            "endpoint" => "dysmsapi.aliyuncs.com"
                        ];
                        $client =  new Dysmsapi($config);
                        $param = [];
                        $param['code'] = strval($code);
                        $param['code'] = strval($sms["tx_fz"]);

                        $sendSmsRequest = new AliSendSmsRequest([
                            "phoneNumbers" => $mobile,
                            "signName" =>  strval($sms["tx_signname"]),
                            "templateCode" => $sms['al_template_id'],
                            "templateParam" => json_encode($param)
                        ]);
                         // 复制代码运行请自行打印 API 的返回值
                        $client->sendSms($sendSmsRequest);
                    }catch(TencentCloudSDKException $e) {
                        self::$error = '发送失败，请稍后再试';
                        return false;
                    }
                break;
            
            default:
                self::$error = '未知配置';
                return false;
                break;
        }


        return true;
    }
    /**
     *  验证手机号是否可以继续发送  单个手机号最多每天发送多少次！
     */
    public function MobileCd($mobile=false,$state=0)
    {
        $bt = date('Ymd',time());
        if (self::$je == 0) {
            return true;
        }
        $max = Cache::store('redis')->get('sms_max_'.$bt.'_'.$mobile);
        if ($max >= self::$max) {
            self::$error = '每日发送短信超过限制！';
            return false;
        }
        if ($state == 0) {
            $sx = Cache::store('redis')->get('sms_cd_'.$mobile);
            if (!$sx) {
                return true;
            }
            self::$error = '不要在短时间内重复发送短信！';
            return false;
        }else{
            Cache::store('redis')->set('sms_cd_'.$mobile,'1',self::$je);
            Cache::store('redis')->inc('sms_max_'.$bt.'_'.$mobile);
            return true;
        }
    }
    /**
     *  错误
     */
    public function Error()
    {
        return self::$error;
    }
}