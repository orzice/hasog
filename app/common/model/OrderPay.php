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
// | DateTime：2020-12-31 18:22:57
// +----------------------------------------------------------------------

namespace app\common\model;


use app\common\model\TimeModel;

class OrderPay extends TimeModel
{

    const PAY_TYPE_ID = [
        1=> '微信支付',
        2=> '支付宝支付',
        3=> '线下支付',
    ];

	public function orders()
    {
		return $this->belongsTo('app\common\model\Order','order_id');
    }




}