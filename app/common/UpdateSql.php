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

use think\facade\Config;
use Hasog\Response;
use think\facade\Db;
use app\common\Cloud;

class UpdateSql 
{

    public function up($release=0)
    {
      $lv = $release;
      $tablePrefix = Config::get('database.connections.mysql.prefix');

        if ($lv >= 2021061501) {return true;}

$tableName = $tablePrefix.'finace_bankcard';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `bankcard` varchar(20) NOT NULL DEFAULT '0' COMMENT '银行卡号',
  `time` int(11) NOT NULL COMMENT '时间',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `bankname` varchar(255) NOT NULL COMMENT '银行名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
ETO;
Db::execute($Sql);


        if ($lv >= 2021040801) {return true;}

        $name = $tablePrefix.'pay_log';

        $sql = <<<ETO
ALTER TABLE `{$name}`
MODIFY COLUMN `pay_id`  varchar(255) NULL DEFAULT NULL COMMENT '支付订单号' AFTER `uid`;
ETO;
        Db::execute($sql);
        if ($lv >= 20210310) {return true;}


        }
}
