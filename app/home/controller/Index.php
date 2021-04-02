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
// +----------------------------------------------------------------------

namespace app\home\controller;

use app\HomeController;
use Hasog\Response;
use think\facade\Db;

class Index extends HomeController
{
    protected $view;
    protected $source;
    protected $fg = DIRECTORY_SEPARATOR;

    // 分为 PC APP WAP WX 界面配置，权重 APP > WX > WAP > PC，APP和WX都有先决条件。
    // 注：微信不存在但是WAP存在！那么默认WAP！如果都不存在 那么 只能返回PC了
    // 注：如果在APP内且没有APP界面，那么直接返回404了！
    // 2020-12-24 Orzice 平安夜~~
    // 2021-3-15 新增 platform 函数 可以让PC访问手机版
    public function GetSource()
    {
      $dic  = public_path().'config'.$this->fg;
      $platform = '';
      if (isset($_GET['platform'])) {
        $platform = $_GET['platform'];
      }
      //===========判断来源=============
      //APP内
      if (is_app()) {
        $file = $dic .'app.json';
        if (file_exists($file)) {
          $this->source = 'app';
          return $file;
        }
        return false;
      }

      //微信内
      if (is_weixin()) {
        $file = $dic .'wx.json';
        if (file_exists($file)) {
          $this->source = 'wx';
          return $file;
        }
      }

      //手机内
      if (is_mobile() || $platform == 'wap') {
        $file = $dic .'wap.json';
        if (file_exists($file)) {
          $this->source = 'wap';
          return $file;
        }
      }

      $file = $dic .'pc.json';
      if (file_exists($file)) {
        $this->source = 'pc';
        return $file;
      }

      return false;
    }
    public function GetView()
    {
      //html 页面不缓存！
      header('Cache-Control:no-cache,must-revalidate');   
      header('Pragma:no-cache');   
      header("Expires:0");
      
      $file = $this->GetSource();

      if(!$file){
        return abort(404, '文件不存在');
      }
      if(!file_exists($file)){
        return false;
      }
      $handle = fopen($file, 'r');
      if (!$handle) {
        return false;
      }

      $buffer = fread($handle, filesize($file));
      fclose($handle);

      $json = json_decode($buffer,true);
      if (!$json) {
        return false;
      }

      $this->view = $json;
      return true;
    }
    public function SetView($dir)
    {
      $handle = fopen($dir, 'r');
      if (!$handle) {
        return abort(404, '文件不存在');
      }
      $buffer = fread($handle, filesize($dir));
      fclose($handle);
      
      return response($buffer, 200, ['Content-Length' => strlen($buffer)])->contentType('text/html');
    }
    public function SetDownload($dir)
    {
      $new = new Response();
      $Type = $new->Get();
      return download($dir, 'file')->force(false)->expire(2592000)->mimeType($Type);//缓存30天 2592000秒 因为每个请求都十分的消耗性能！但是十分安全！
    }
    public function int(){
      $path  = public_path();
      $dic  = $path.'config'.$this->fg;
      $lock = $dic .'install'.$this->fg;
      if (!is_file($lock.'install.lock')) {
        return true;
      }
      return false;
    }
    public function index()
    {
      $int =  $this->int();
      if ($int) {
        return redirect('/Install');
      }

      $data = config_plus("hasog");
      header('Server: HaSog Server '.$data['version'].'/'.$data['release']);
      header('X-Powered-By: HaSog/'.$data['version'].'/'.$data['release']);
      if (!$this->GetView()) {
        return abort(404, '文件不存在');
      }
      $pathinfo = $this->request->pathinfo();
      $ext = $this->request->ext();
      // $file = root_path().'plugin\\'.$this->view['namespace'].'\page\\'.$this->source.'\\';
      $file = root_path().'plugin'.$this->fg.$this->view['namespace'].$this->fg.'page'.$this->fg.$this->view['dir'].$this->fg;


      if ($ext == '') {
        $pathinfo .= 'index.html';
        $ext = 'html';
      }
      $dir = $file.$pathinfo;
      $dir = str_replace(["/\\","\\\\",'/'],$this->fg,$dir);

      $_404 = false;
      if(!file_exists($dir)){
        //那么去wap里面找找
        if ($this->view['dir'] == 'pc') {
          $dir = str_replace('page'.$this->fg.$this->view['dir'].$this->fg, 'page'.$this->fg.'wap'.$this->fg, $dir);
          if(!file_exists($dir)){
            $_404 = true;
          }
        }else{
            $_404 = true;
        }
      }
      
      if(filesize($dir) <= 0){
          $_404 = true;
      }
      if(file_exists($dir)){
          if(filesize($dir) <= 0){
              $_404 = true;
          }
      }

      switch ($ext) {
        case 'html'://前端核心就是html页面
            return $this->SetView($dir);
          break;
        default://其他附件均下载方式
            return $this->SetDownload($dir);
          break;
      }

    }
}
