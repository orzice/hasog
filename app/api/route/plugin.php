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
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------
use think\facade\Route;

// Route::get('think', function () {
//     return 'hello,ThinkPHP6!';
// });

//Route::get('hello/:name', 'index/hello');

//Route::rule('plugin','app\api\controller\Index@index

// 绑定到类
/**
 * plugin.a-index-index-index    或者 home/ 都可以
 */
//Route::rule('plugin.<p1>-<p2>-<p3>-<p4>','AcShop\plugin\<p1>\api\<p2>\<p3>@<p4>');
Route::rule('plugin.<p1>-<p2>-<p3>-<p4>','Plugin/call');

//Route::rule('order/wechat_no/<id>','order/wechat_no');
Route::rule('wechat_front/wechat_no/<id>/<pay_id>','wechat_front/wechat_no');
Route::rule('wechat_front/wechat_balance/<pay_id>','wechat_front/wechat_balance');
Route::rule('ali_front/ali_no/<id>/<pay_id>','ali_front/ali_no');
Route::rule('ali_front/ali_balance/<pay_id>','ali_front/ali_balance');
Route::rule('ali_front/ali_return/<pay_id>','ali_front/ali_return');
Route::rule('ali_front/ali_balance_return/<pay_id>','ali_front/ali_balance_return');

// Route::rule('plugin.<p1>-<p2>-<p3>-<p4>', function ($p1,$p2,$p3,$p4) {
// 	print_r($p1);
// 	print_r($p2);
// 	print_r($p3);
// 	print_r($p4);
// });

// plugin.orz-s1hop.api.Shop.banner
// Route::rule('plugin.<action>', function ($action) {
// 	//print_r($action);
// 	$url = explode(".",$action);
// 	//$code = "AcShop\plugin\\".$url[0]."\\src\\".$url[1]."\\".$url[2]."::".$url[3];
// 	$code = "AcShop\plugin\\".$url[0]."\\src\\".$url[1]."\\".$url[2];
	
// 	eval('$con = new '.$code.";");
// 	print_r($con);
// 	//print_r (explode(".",$action));
// 	//return "AcShop\plugin\\".$url[0]."\\src\\".$url[1]."\\".$url[2]."@".$url[3];
// });
//  plugin/a.index.index.index