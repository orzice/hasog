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
// | DateTime：2021-01-04 17:21:13
// +----------------------------------------------------------------------
namespace AcShop\plugin\a\listener;


use think\Event;
/**
* 
*/
class Index 
{
	public function subscribe(Event $event){
		//$event->listen('UserLogin', [$this,'onUserLogin']);
                $event->listen('UserLogin', [$this,'onUserLogin']);
                print_r("事件监听注册<br>");
             
        // $event->listen(\app\api\controller\index::class, function ($event) {
        //     //订单model
        //     print_r($event);
        //     exit;
        //     // $model = $event->getOrderModel();
        //     // $this->handle($model);
        // });
        }
        public function onUserLogin($user)
        {
            // UserLogin事件响应处理
            print_r("插件A 响应<br>数据:".$user."<br>");
        }

}