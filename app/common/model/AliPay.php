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
use think\facade\Db;
use think\Model;
use think\model\concern\SoftDelete;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

class AliPay extends TimeModel
{

    use SoftDelete;
    const ALLOW_FIELDS = [
        'name',
        'app_id',
        'rsa_private_key',
        'rsa_public_key',
        'open_status',
        'remark',
        'is_union',
        'is_login',
        'enable_app',
        'enable_wap',
        'enable_pc',
    ];
    protected $deleteTime = 'delete_time';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $defaultSoftDelete = null;
    protected $name = 'ali_pay';



}