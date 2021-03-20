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

class Update 
{
    protected $fg = DIRECTORY_SEPARATOR;

    public function output($value)
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
ETO;

      // echo $val.'<br>';
      flush();
    }
    public function index()
    {
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
window.scroll({top:9999999,left:0,behavior:'smooth' });
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
      if ($http['release'] <= config_plus("hasog.release")) {
        $this->output('已是最新版本');
        return '已是最新版本';
      }
      $this->output('遍历本地文件中...');

      // 更新
      // 排除目录 ： /config /plugin
      $dic  = root_path();
      $array = $this->scansplus($dic,['config','plugin','.git','upgrade','runtime'],root_path());
      $json = json_encode($array);
      $this->output('遍历本地文件完成');


      $this->output('生成备份目录中...');
      $up_dic  = root_path().'upgrade';
      if(!is_readable($up_dic))
      {
         is_file($up_dic) or mkdir($up_dic,0700,true);
      }
      $bf_dic  = root_path().'upgrade'.$this->fg.'backups'.$this->fg.date('Ymdhis',time());
      $this->output('生成：'.$bf_dic);
      if(!is_readable($bf_dic))
       {
          is_file($bf_dic) or mkdir($bf_dic,0700,true);
       }
      $ver_dic  = root_path().'upgrade'.$this->fg.'release'.$this->fg.$http['release'];
      $this->output('生成：'.$ver_dic);
      if(!is_readable($ver_dic))
       {
          is_file($ver_dic) or mkdir($ver_dic,0700,true);
       }
      $this->output('生成备份目录完成');


       $TxtRes = fopen ($up_dic.$this->fg.'upgrade.json',"w+");
       if(!fwrite ($TxtRes,$json)){
          fclose($TxtRes);
          $this->output('【错误】打开 '.$up_dic.$this->fg.'upgrade.json'.' 文件失败...');
          return $up_dic.$this->fg.'upgrade.json'.' 打开文件失败';
       }
      fclose($TxtRes);

      $this->output('下载云平台版本差异文件中...');
       $new_up = http_query($http['publish_json']);
       $new_json = json_decode($new_up,true);
      $this->output('下载云平台版本差异文件成功');

      $this->output('初始化数据...');
       $key_new = array_keys($new_json);
       $new_json2 = [];
       for ($i=0; $i < count($key_new); $i++) { 
          $key_n = str_replace(["/","\\"],"\\", $key_new[$i]);
          $new_json2[$key_n] = $new_json[$key_new[$i]];
       }

       $bd = [];
       $z_old = $array;
       $z_new = $new_json2;
       $key_new = array_keys($z_new);

       
       $z_old2 = array_keys($z_old);
       $z_old3 = [];
       for ($i=0; $i < count($z_old2); $i++) { 
          $key_n = str_replace(["/","\\"],"\\", $z_old2[$i]);
          $z_old3[$key_n] = $z_old[$z_old2[$i]];
       }
       $z_old = $z_old3;
     


      $this->output('初始化数据完成');

      $this->output('对比版本差异中...');
       for ($i=0; $i < count($key_new); $i++) { 
        if (isset($z_old[$key_new[$i]])) {
          if ($z_new[$key_new[$i]] !== $z_old[$key_new[$i]]) {
            $key_new[$i] = str_replace(["/","\\"],$this->fg, $key_new[$i]);
            $l_src = str_replace($dic.$this->fg, '', $key_new[$i]);
            $l_src = str_replace(["/","\\"],"\\", $l_src);
            // $bd[] = ['dir'=>$dic.$key_new[$i],'src'=>$l_src,'md5'=>$z_new[$l_src]];
            $bd[] = ['dir'=>$dic.$key_new[$i],'src'=>$l_src,'md5'=>$z_new[$key_new[$i]]];
          }
          
        }else{
            $key_new[$i] = str_replace(["/","\\"],$this->fg, $key_new[$i]);
            $l_src = str_replace($dic.$this->fg, '', $key_new[$i]);
            $l_src = str_replace(["/","\\"],"\\", $l_src);
            $bd[] = ['dir'=>$dic.$key_new[$i],'src'=>$l_src,'md5'=>$z_new[$key_new[$i]]];
        }
       }
      $this->output('对比版本差异完成 需要升级 '.count($bd).' 个文件！');
       if (count($bd) == 0) {
          $this->output('写入版本信息中...');
          $hasog = config_plus("hasog");
          $hasog['version'] = $http['version'];
          $hasog['release'] = $http['release'];
          $dic_r  = $dic.'config'.$this->fg;
          @file_put_contents($dic_r.'hasog.php', $this->getHaSogConfig($hasog));
          $this->output('写入版本信息成功');
          $this->output('没有需要更新的文件！');
          return ;
       }

      $this->output('下载升级文件中...');
       for ($i=0; $i < count($bd); $i++) { 
        $ls_nas = $ver_dic.$this->fg.str_replace(["/","\\"],$this->fg, $bd[$i]['src']);
        if (is_file($ls_nas)){
          if (md5_file($ls_nas) == $bd[$i]['md5']){
            $this->output('文件已存在：'.$ls_nas);
            continue;
          }
        }

         $h_dir = $Cloud->GetUpdateDir($bd[$i]['src']);
         
          if (!$h_dir) {
            $this->output('【异常】下载云服务文件失败：'.$ls_nas);
          }else{
            if(!is_readable(dirname($ls_nas))){
              $this->output('创建目录：'.dirname($ls_nas));
              mkdir(dirname($ls_nas),0700,true);
            }
             $ls_r = fopen ($ls_nas,"w+");
             if(!fwrite ($ls_r,$h_dir)){
                fclose($ls_r);
                $this->output('【错误】打开文件失败：'.$ls_nas);
                return $ls_nas.' 打开文件失败';
             }
             fclose($ls_r);
              $this->output('写入文件：'.$ls_nas);
          }
       }
      $this->output('下载升级文件完成');

      $this->output('备份原有文件中...');
      $this->output('备份：'.$dic.'app'.' -> '.$bf_dic.$this->fg.'app');
       $this->copydir($dic.'app',$bf_dic.$this->fg.'app');

      $this->output('备份：'.$dic.'vendor'.' -> '.$bf_dic.$this->fg.'vendor');
       $this->copydir($dic.'vendor',$bf_dic.$this->fg.'vendor');

      $this->output('备份：'.$dic.'public'.' -> '.$bf_dic.$this->fg.'public');
       $this->copydir($dic.'public',$bf_dic.$this->fg.'public');

      $this->output('备份：'.$dic.'extend'.' -> '.$bf_dic.$this->fg.'extend');
       $this->copydir($dic.'extend',$bf_dic.$this->fg.'extend');

      $this->output('备份：'.$dic.'composer.json'.' -> '.$bf_dic.$this->fg.'composer.json');
       $fh = copy($dic.'composer.json',$bf_dic.$this->fg.'composer.json');
       if (!$fh) {
         $this->output('【异常】备份失败：'.$dic.'composer.json'.' -> '.$bf_dic.$this->fg.'composer.json');
       }

      $this->output('备份：'.$dic.'composer.lock'.' -> '.$bf_dic.$this->fg.'composer.lock');
       $fh = copy($dic.'composer.lock',$bf_dic.$this->fg.'composer.lock');
       if (!$fh) {
         $this->output('【异常】备份失败：'.$dic.'composer.lock'.' -> '.$bf_dic.$this->fg.'composer.lock');
       }

      $this->output('备份原有文件完成');


      $this->output('装载数据库升级依赖...');
      if (is_file($ver_dic.$this->fg.'app'.$this->fg.'common'.$this->fg.'UpdateSql.php')){
        $fh = copy($ver_dic.$this->fg.'app'.$this->fg.'common'.$this->fg.'UpdateSql.php',$dic.'app'.$this->fg.'common'.$this->fg.'UpdateSql.php');
         if (!$fh) {
           $this->output('【异常】装载数据库升级依赖失败');
         }
        if (is_file($dic.'app'.$this->fg.'common'.$this->fg.'UpdateSql.php')){
           $up = new \app\common\UpdateSql();
           $re = $up->up(config_plus("hasog.release"));
           $this->output($re);
        }else{
           $this->output('【异常】数据库升级依赖不存在！');
         }
        $this->output('数据库升级成功');
      }else{
         $this->output('数据库不需要升级');
      }
      $this->output('安装升级文件中...');
      $this->copydir($ver_dic,$dic);
      $this->output('安装升级文件成功');
      $this->output('写入版本信息中...');
      $hasog = config_plus("hasog");
      $hasog['version'] = $http['version'];
      $hasog['release'] = $http['release'];
      $dic_r  = $dic.'config'.$this->fg;
      @file_put_contents($dic_r.'hasog.php', $this->getHaSogConfig($hasog));
      $this->output('写入版本信息成功');
      $this->output('升级完成！');

echo <<<ETO
<script>
setTimeout(function(){ clearInterval(Interval); }, 3000);
</script>
ETO;
flush();

} catch (\Throwable $e) {

  $this->output('【致命错误】升级失败: '.$e->getMessage());

echo <<<ETO
<script>
setTimeout(function(){ clearInterval(Interval); }, 3000);
</script>
ETO;
flush();

}
    }
public function getHaSogConfig($data)
{
    $config = <<<EOT
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
// | DateTime：2021-03-06 17:52:38
// +----------------------------------------------------------------------

return [
    // 版本
    'version'         => '{$data['version']}',
    // 日期
    'release'         => '{$data['release']}',
    // Session配置
    'SessionName'         => '{$data['SessionName']}',
    // 后台管理员密码加密
    'pwSDK'         => '{$data['pwSDK']}',
    // 前台用户密码加密
    'userPW'         => '{$data['userPW']}',
    // 云平台配置
    'CloudUrl'         => '{$data['CloudUrl']}',
    //  后台访问目录
    'Admin'         => '{$data['Admin']}',
    //  唯一ID 勿动
    'uniqueid'         => '{$data['uniqueid']}',
    //  服务器公网IP
    'ServerIp'         => '{$data['ServerIp']}',
];

EOT;
    return $config;
}
    public function copydir($dir,$toDir){
      flush();
        if(is_file($toDir)){
          return;
        }else{
            if(!file_exists($toDir)){
                mkdir($toDir,0700,true);
            }
            $dirName = opendir($dir);
            while($fileName = readdir($dirName)){
                if($fileName!="." && $fileName!=".."){
                    $dirUrl = $dir.DIRECTORY_SEPARATOR.$fileName;
                    $dirToUrl = $toDir.DIRECTORY_SEPARATOR.$fileName;
                    if(is_dir($dirUrl)){
                        $this->copydir($dirUrl,$dirToUrl);
                    }else{
                        copy($dirUrl,$dirToUrl);
                    }
                }
            }
            closedir($dirName);    
        }
    }
 
    public function scansplus($dir,$nodir,$root)
    {
      static $dic=[];
      $dirArr = scandir($dir);
      foreach($dirArr as $v){
         if($v!='.' && $v!='..'){
          $dirname = $dir.DIRECTORY_SEPARATOR.$v;
          $dirname = str_replace("\\\\",DIRECTORY_SEPARATOR, $dirname);
          $dirname = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR, $dirname);
          if(is_dir($dirname)){
            $ls = false;
            $ls_n = str_replace($root,"", $dirname);
            for ($s=0; $s < count($nodir); $s++) { 
              if ($nodir[$s] == $ls_n) {
                $ls = true;
                break;
              }
            }
            if ($ls) {
             continue;
            }
            $this->scansplus($dirname,$nodir,$root);
          }else{
              $name = str_replace($root, '', $dirname);
              // $dirname = str_replace(DIRECTORY_SEPARATOR,"\\", $dirname);
              $dic[$name] = md5_file($dirname);
            }
         }
      }

      return $dic;

    }
    public function scans($dir,$root)
    {
      static $dic=[];

      $dirArr = scandir($dir);
      foreach($dirArr as $v){
         if($v!='.' && $v!='..'){
           $dirname = $dir.DIRECTORY_SEPARATOR.$v; //子文件夹的目录地址
            if(is_dir($dirname)){
              $this->scans($dirname,$root);
            }else{
              $name = str_replace($root, '', $dirname);
              // $dirname = str_replace(DIRECTORY_SEPARATOR,"\\", $dirname);
              $dic[$name] = md5_file($dirname);
            }
         }
      }
      return $dic;

    }
}