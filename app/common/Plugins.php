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

namespace app\common;

use think\facade\Config;
use think\facade\Route;
use app\common\model\PluginsData;

use EasyAdmin\auth\Node as NodeService;
use app\admin\model\SystemNode;
use app\admin\model\SystemMenu;
use app\admin\service\TriggerService;

class Plugins 
{
    private static $sep= DIRECTORY_SEPARATOR;
    private static $sepx = '\\';
    /**
     * 初始化方法 【新】使用数据库操作注入
     */
    static public function init()
    {
        //==================================
        //      获取已开启的插件并注入
        //==================================
        $root = root_path();
        $sep = self::$sep;
        $dir = $root.'plugin'.$sep;

        $plugins = PluginsData::where("state",1)->select();

        for ($i=0; $i < count($plugins); $i++) { 
            $file = $dir.$plugins[$i]["dir"].$sep."package.php";
            if (is_file($file)){
               $hook = include $file;
               $hook();
            }
        }
    }
    /**
     * 卸载插件
     */
    static public function PluginDel($name=null)
    {
        if (!$name) {return false;}
        $root = root_path();
        $sep = self::$sep;
        $dir = $root.'plugin'.$sep;
        $file = $dir.$name.$sep."app.json";
        if (!is_file($file)){
            return false;
        }
        $uninstall = $dir.$name.$sep."uninstall.php";
        if (is_file($uninstall)){
            $hook = include $uninstall;
            $state = $hook();
            if(!$state){
                return false;
            }
        }
        rename($file,$dir.$name.$sep."package.json");
        PluginsData::where("dir",$name)->delete();
        self::PluginNodeDel($name);
        self::PluginMenuDel($name);
        return true;
    }
    /**
     * 安装插件
     */
    static public function Install($name=null)
    {
        if (!$name) {return false;}
        //==================================
        //      安装插件
        //==================================
        $root = root_path();
        $sep = self::$sep;
        $dir = $root.'plugin'.$sep;
        $file = $dir.$name.$sep."package.json";
        if (!is_file($file)){
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
        $install = $dir.$name.$sep."install.php";
        if (is_file($install)){
            $hook = include $install;
            $state = $hook();
            if(!$state){
                return false;
            }
        }
        $sql = array(
            'dir' => $name,
            'name' => $json['name'],
            'version' => $json['version'],
            'description' => $json['description'],
            'author' => $json['author'],
            'url' => $json['url'],
            'namespace' => $json['namespace'],
            'state' => 0,
            'create_time' => time(),
            );
        try {
            $save = PluginsData::insert($sql);
        } catch (\Exception $e) {
            return false;
        }
        if($save){
            rename($file,$dir.$name.$sep."app.json");
        }
        return $save;
    }
    /**
     * 移除已安装的插件节点
     */
    static public function PluginNodeDel($name = null)
    {
        if (!$name) {return false;}
        $dir = 'plugins.'.$name.'-';
        SystemNode::where("node",'like', $dir.'%')->delete();
        return true;
    }
    /**
     * 更新已安装的插件节点
     */
    static public function PluginNode()
    {
        //==================================
        //      获取已开启的插件
        //==================================
        $sep = self::$sep;
        $sepx = self::$sepx;
        $root = root_path();
        $dir = $root.'plugin'.$sep;
        
        $plugins = PluginsData::where("state",1)->select();

        for ($i=0; $i < count($plugins); $i++) {
            $file = $dir.$plugins[$i]["dir"].$sep."package.php";
            if (is_file($file)){
               $node = new NodeService();
               $node->setDir($dir.$plugins[$i]["dir"].$sep.'admin');
               $node->setNamespacePrefix("HaSog".$sepx."plugin".$sepx.$plugins[$i]["dir"].$sepx."admin");
               $nodeList = ($node)->getNodelist();
               //处理node数据
               for ($s=0; $s < count($nodeList); $s++) { 
                   $nodeList[$s]['node'] = 'plugins.'.$plugins[$i]["dir"].'-'.str_replace(['.'],'-' ,$nodeList[$s]['node']);
               }
               if(empty($nodeList)){
                 continue;
               }
                $model = new SystemNode();
                try {
                    $existNodeList = $model->field('node,title,type,is_auth')->select();
                    foreach ($nodeList as $key => $vo) {
                        foreach ($existNodeList as $v) {
                            if ($vo['node'] == $v->node) {
                                unset($nodeList[$key]);
                                break;
                            }
                        }
                    }
                    $model->saveAll($nodeList);
                    TriggerService::updateNode();
                } catch (\Exception $e) {
                    continue;
                }
                continue;
            }
        }
        return true;
    }
    /**
     * 移除已安装的管理面板
     */
    static public function PluginMenuDel($name = null)
    {
        if (!$name) {return false;}
        // $dir = 'plugins.'.$name.'-';
        $dir = 'plugins.'.$name;
        SystemMenu::where("href",'like', $dir.'%')->delete();
        return true;
    }
    /**
     * 更新已安装的插件管理面板
     */
    static public function PluginMenu()
    {
        //==================================
        //      获取已开启的插件
        //==================================
        $sep = self::$sep;
        $root = root_path();
        $dir = $root.'plugin'.$sep;

        $plugins = SystemNode::where("type",2)->where("node",'like','plugins.%')->select();

        for ($i=0; $i < count($plugins); $i++) {
            $code = SystemMenu::where('href',$plugins[$i]["node"])->find();
            if($code){
                continue;
            }
            $dir = getSubstr($plugins[$i]["node"],'plugins.','-');
            $data = PluginsData::where('dir',$dir)->find();
            if(!$data){
                continue;
            }
            $pid = 1;
            //判断是否有父接口
            $pids = SystemMenu::where('href','plugins.'.$dir)->find();
            if ($pids) {
                $pid = $pids['id'];
            }else{
                //创建父级别
                $sql = array(
                    'pid' => 1,
                    'title' => $data["name"],
                    'icon' => "fa fa-code",
                    'href' => 'plugins.'.$dir,
                    'target' => "_self",
                    'sort' => 10,
                    'status' => 1,
                    );
                $model = new SystemMenu();
                $pid = $model->insertGetId($sql);
                    
                //如果有其他小伙伴但是没有父接口那么自动创建父接口
                $plugs = SystemMenu::where('href','like','plugins.'.$dir.'-%')->select();
                if (count($plugs) !== 0) {
                    //给原来的子数据更改为父接口
                    SystemMenu::where('href','like','plugins.'.$dir.'-%')->update(['pid'=>$pid]);
                }
            }

            // 部分插件函数 不计入前端模块
            $pass = ['add','edit','delete'];
            $pas = false;
            for ($s=0; $s < count($pass); $s++) { 
                if (strpos($plugins[$i]["node"], '/'.$pass[$s])) {
                    $pas = true;
                    break;
                }
            }
            if ($pas) {
                continue;
            }


            $sql = array(
                'pid' => $pid,
                'title' => $plugins[$i]["title"],
                'icon' => "fa fa-code",
                'href' => $plugins[$i]["node"],
                'target' => "_self",
                'sort' => 10,
                'status' => 1,
                );
            $model = new SystemMenu();
            try {
                $save = $model->save($sql);
            } catch (\Exception $e) {
                continue;
            }
            if ($save) {
                TriggerService::updateMenu();
                continue;
            } else {
                continue;
            }

        }
        return true;
    }

    //fa-code
    /**
     * 获取已安装的插件列表信息
     */
    static public function GetPluginList($state = "")
    {
        $plugins = PluginsData::order('state','DESC');
        if ($state !== "") {
            $plugins = $plugins->where("state",$state);
        }
        $plugins = $plugins->select();
    	return $plugins;
    }
    /**
     * 获取已安装的插件列表信息
     */
    static public function GetPluginState($dir = "",$state = 1)
    {
        if ($dir == '') {
            return '';
        }
        return PluginsData::where('state',$state)->where("dir",$dir)->find();
    }
    /**
     * 获取未安装的插件信息 安装后 package.json包 更名
     */
    static public function GetInstallPlugin()
    {
        $root = root_path();
        $sep = self::$sep;
        $install = array();
        $dir = $root.'plugin'.$sep;
        $str = opendir($dir);
        while( ($filename = readdir($str)) !== false ){
            if($filename != "." && $filename != ".."){
                if (!is_file($filename)){
                    $dir_array[]=$filename;
                }
            }
        }
        closedir($str);
        for ($i=0; $i < count($dir_array); $i++) { 
            $file = $dir.$dir_array[$i].$sep."package.json";
            if (is_file($file)){
                $handle = fopen($file, 'r');
                if ($handle) {
                    $buffer = fread($handle, filesize($file));
                    fclose($handle);
                    $json = json_decode($buffer,true);
                    if ($json) {
                        $install[] = $json;
                    }
                }
            }
        }
        return $install;
    }

}