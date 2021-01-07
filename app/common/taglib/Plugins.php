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

namespace app\common\taglib;

use think\template\TagLib;
use think\Template;

class Plugins extends TagLib{
    protected $tags   =  [
        'include'     => ['attr' => 'file', 'close' => 0], 
    ];

    public function tagInclude($tag, string $content): string
    {
        $name = $tag["file"];
        $parse = '<?php ';
        $parse .= '\think\facade\View::engine()->layout(false);';
        //$parse .= 'echo  \think\facade\View::display(file_get_contents(root_path()."'.$name.'"));';
        $parse .= 'echo  \think\facade\View::fetch(root_path()."plugin/".'.$name.'.".html");';
        $parse .= ' ?>';
        return $parse;
    }
    
   
}