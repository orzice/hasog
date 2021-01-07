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

class OrderRefund extends TimeModel
{

    const STATUS_ARRAY = [0 => '待审核', 1 => '成功', 2 => '失败'];
    const ALLOW_FIELDS = [
        'delete_time',
        'status',
        'reason',
        'remark'
    ];

//    protected $name = 'order_refund';


    public function member()
    {
        return $this->belongsTo('app\common\model\Member', 'uid');
    }

    public function orders()
    {
        return $this->belongsTo('app\common\model\Order', 'order_id', 'id');
    }


//    public function getStatusAttr($value)
//    {
//        return self::STATUS_ARRAY[$value];
//    }


}