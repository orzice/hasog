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
// | DateTime：2021-03-20 10:49:50
// +----------------------------------------------------------------------

namespace app\common;

use Hasog\Response;
use think\facade\Db;
use app\common\Cloud;

use app\common\Plugins;
use app\common\model\PluginsData;

class PluginsUpdate 
{
    protected $fg = DIRECTORY_SEPARATOR;

    public function output($value,$end=false)
    {
      $time = date('H:i:s',time());
      $val = $time.' - '.$value;

echo <<<ETO
                    <li class="layui-timeline-item" style="padding-bottom: 0px;">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                        <div class="layui-timeline-title">{$val}</div>
                            <!--h3 class="layui-timeline-title">{$time}</h3>
                            <p>
                                {$value}
                            </p-->
                        </div>
                    </li>
<script>
window.scroll({top:9999999,left:0,behavior:'smooth' });
</script>
ETO;
if ($end) {

echo <<<ETO
<script>

setTimeout(function (){
 
window.parent.parent.location.reload();
window.parent.location.reload();

}, 3000);

</script>
ETO;
}
      // echo $val.'<br>';
      flush();
    }
    public function index($p_dir=false,$p_key=false)
    {
      if ($p_dir==false || $p_key == false) {
        $this->output('【错误】参数有误');
        return;
      }
      ob_end_flush();
      ob_start();
      header('X-Accel-Buffering: no'); //关闭输出缓存
      set_time_limit(0);//0表示没有限制
      ob_end_clean();
      ob_implicit_flush(1);

echo <<<ETO
<html>
<head>
    <meta charset="utf-8">
    <title>升级中请勿关闭！</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/lib/layui-v2.5.6/css/layui.css" media="all">
    <style>
    body{
        background: #ffffff;
        padding: 15px;
    }
    </style>
</head>
<body>
<script>
var  Interval = window.setInterval(function(){ 
 // var t = document.body.clientHeight;
// window.scroll({top:t,left:0,behavior:'smooth' });
//window.scroll({top:9999999,left:0,behavior:'smooth' });
}, 100); 
</script>
<div class="layui-col-md6">
                <ul class="layui-timeline">
ETO;
flush();
try {
  
      $Cloud = new Cloud();
      
      $this->output('正在连接云平台...');
      $http = $Cloud->GetUpdate();

      if (!$http) {
        $this->output('【错误】连接云平台出错：'.$Cloud->GetError());
        return $Cloud->GetError();
      }
      $dic  = root_path();
      $p_dic  = $dic.DIRECTORY_SEPARATOR.'plugin'.DIRECTORY_SEPARATOR.$p_dir;
      $ls_nas = $p_dic.DIRECTORY_SEPARATOR.'int.zip';

      $this->output('生成：'.$p_dic);
      if(!is_readable($p_dic))
       {
          is_file($p_dic) or mkdir($p_dic,0700,true);
       }
       
      $h_dir = $Cloud->GetPluginUpdate($p_dir,$p_key);
     
      if (!$h_dir) {
        $this->output('【异常】下载云服务文件失败：'.$Cloud->GetError());
        return;
      }else{

         $ls_r = fopen ($ls_nas,"w+");
         if(!fwrite ($ls_r,$h_dir)){
            fclose($ls_r);
            $this->output('【错误】打开文件失败：'.$ls_nas);
            return $ls_nas.' 打开文件失败';
         }
         fclose($ls_r);
          $this->output('写入文件：'.$ls_nas);
      }

      // 升级 Or 安装
      $ins_dir = $p_dic.DIRECTORY_SEPARATOR."app.json";
      $inst = false;
      if (is_file($ins_dir)) {
        $inst = true;
      }


      $this->output('解压包文件中、本次耗时大概2分钟、请耐心等待...');
      $zips = $this->unZip($ls_nas, $p_dic);
      if (is_file($ls_nas)) {
        unlink($ls_nas);
      }
      if (!$zips) {
        $this->output('【错误】压缩包解压失败');
        return $Cloud->GetError();
      }
      //============int===============
      // 升级 Or 安装
      if ($inst) {
        if (is_file($p_dic.DIRECTORY_SEPARATOR.'package.json')) {
          unlink($p_dic.DIRECTORY_SEPARATOR.'package.json');
        }

        //更新
        try {
            $a = Plugins::Update($p_dir);
        } catch (\Exception $e) {
          if (is_file($ls_nas)) {
            unlink($ls_nas);
          }
          $this->output('【错误】插件更新失败！');
          return;
        }
        $install = $p_dic.DIRECTORY_SEPARATOR."install.php";
        if (is_file($install)){
            $hook = include $install;
            $state = $hook();
            if(!$state){
                if (is_file($ls_nas)) {
                  unlink($ls_nas);
                }
                $this->output('【错误】插件安装失败！');
                return;
            }
        }


      }else{
        //新装 不需要管理
        if (is_file($ins_dir)) {
          unlink($ins_dir);
        }
      }
      //============int===============

      if (is_file($ls_nas)) {
        unlink($ls_nas);
      }
      $this->output('升级完成！',true);

flush();

} catch (\Throwable $e) {

  $this->output('【致命错误】升级失败: '.$e->getMessage());

}
    }
    /**
   * @param string $zipFile 需要解压的文件
   * @param string $unZipDir 解压后的文件夹路径
   * @return bool
   */
    public function unZip($zipFile, $unZipDir)
    {
        $zip = new \ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            //将压缩文件解压到指定的目录下 为了追求速度 放弃中文名了
            $zip->extractTo($unZipDir); 
            //关闭zip文档 
            $zip->close(); 
            return true;

        } else {
            return false;
        }

    }
}
