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

use Hasog\Response;
use think\facade\Db;
use app\common\Cloud;

class UpdateSql 
{

    public function up($release=0)
    {
      $lv = $release;
      
      if ($lv >= 20210310) {return true;}

      
    }
}