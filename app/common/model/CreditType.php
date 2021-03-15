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
use think\model\relation\HasMany;

class CreditType extends TimeModel
{

    const IS_WAY = [1=>'is_pay', 2=>'is_withdraw', 3=>'is_transfer',4=>'is_convert',];

    const AllOW_FIELD = [
        'is_pay', 'is_withdraw', 'is_transfer', 'is_convert', 'title', 'value'
    ];
    protected $deleteTime = 'delete_time';


}