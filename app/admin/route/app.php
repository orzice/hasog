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
// | DateTime：2020-12-31 18:18:30
// +----------------------------------------------------------------------
use think\facade\Route;


//  BUG 因为不判断登录，所以可能被攻击！所以需要中继！
/**
 * /admin/plugins.a-index-index-index
 */
// Route::rule('plugins.<p1>-<p2>-<p3>-<p4>','AcShop\plugin\<p1>\admin\<p2>\<p3>@<p4>');

Route::rule('plugins.<p1>-<p2>-<p3>-<p4>','Plugin/call');

/**
 * /admin/plugins.a-index-index/index
 */
// Route::rule('plugins.<p1>-<p2>-<p3>/<p4>','AcShop\plugin\<p1>\admin\<p2>\<p3>@<p4>');

Route::rule('plugins.<p1>-<p2>-<p3>/<p4>','Plugin/call');

Route::rule('plugins.<p1>','Plugin/default');

