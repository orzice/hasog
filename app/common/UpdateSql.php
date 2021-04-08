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
// | DateTime：2021-03-19 10:35:41
// +----------------------------------------------------------------------
// 升级SQL脚本
namespace app\common;

use app\admin\controller\system\Config;
use Hasog\Response;
use think\facade\Db;
use app\common\Cloud;

class UpdateSql 
{

    public function up($release=0)
    {
      $lv = $release;

        if ($lv >= 2021040801) {return true;}
        $tablePrefix = think\facade\Config::get('database.connections.mysql.prefix');

        $name = $tablePrefix.'pay_log';

        $sql = <<<ETO
ALTER TABLE `{$name}`
MODIFY COLUMN `pay_id`  varchar(255) NULL DEFAULT NULL COMMENT '支付订单号' AFTER `uid`;
ETO;
        think\facade\Db::execute($sql);
        if ($lv >= 20210310) {return true;}


        }
}
