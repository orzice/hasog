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
// | DateTime：2021-01-04 17:21:35
// +----------------------------------------------------------------------

use think\facade\Config;
use think\facade\Event;
use AcgCron\Cron;
use think\facade\View;

return function () {
   //print_r("插件A启动<br>");
	// 设置插件
	Config::set(['a' => [
        'name' => '插件A模块',
        'version' => '1.0.0',
        'description' => '测试插件A说明',
        'author' => '',
        'url' => '',
        'namespace' => 'AcShop\\plugin\\a',
        'admin' => 'index-index-index',//后台管理页面 留空就是没有
        ]], 'plugins_menu');

	// 监听事件
	//Event::subscribe(AcShop\plugin\a\listener\index::class);
    
    Event::listen('GoodsAdd', function() {
        Config::set([count(Config::get('goodsadd')) => [
            'name' => '插件A模块',
            'src' => 'a/view/admin/goods_add',
            ]], 'goodsadd');
    });
    Event::listen('GoodsAddPost', function($post) {
       //print_r($post);
       //exit;
    });
    
    Event::listen('GoodsEdit', function($id) {
        View::assign('a',array('title'=>'测试数据'));
        Config::set([count(Config::get('goodsedit')) => [
            'name' => '插件A模块['.$id,
            'src' => 'a/view/admin/goods_edit',
            ]], 'goodsedit');
    });
    Event::listen('GoodsEditPost', function($post) {
       //print_r($post);
       //exit;
    });

    Event::listen('MemberAddStart', function() {
        Config::set([count(Config::get('memberadd')) => [
            'name' => '插件A模块',
            'src' => 'a/view/admin/goods_add',
            ]], 'memberadd');
    });
    Event::listen('MemberEditStart', function($id) {
        Config::set([count(Config::get('memberedit')) => [
            'name' => '插件A模块['.$id,
            'src' => 'a/view/admin/goods_add',
            ]], 'memberedit');
    });

    // 例子：定时任务
    // Event::listen('cron.collectJobs', function($user) {
    //     Cron::add('acgice-plugin-a', '* * * * * *', function () {
    //         print_r('插件A的定时任务');
    //         return;
    //     });
    // });

    // 例子：禁止某个用户加入黑名单
    // Event::listen('MemberModify', function($arr) {
    //     if($arr['id'] == 1 && $arr['value'] == 0){
    //         api_return(0,"用户 ".$arr['id']." 不允许修改");
    //     }
    // });



};
