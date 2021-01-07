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
// | DateTime：2020-12-31 18:15:18
// +----------------------------------------------------------------------

namespace app\admin\controller\system;


use app\admin\model\SystemUploadfile;
use app\common\controller\AdminController;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
use think\App;

/**
 * @ControllerAnnotation(title="上传文件管理")
 * Class Uploadfile
 * @package app\admin\controller\system
 */
class Uploadfile extends AdminController
{

    use \app\admin\traits\Curd;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new SystemUploadfile();
    }
    /**
     * @NodeAnotation(title="删除")
     */
    public function delete($id)
    {
        $row = $this->model->whereIn('id', $id)->select();
        $row->isEmpty() && $this->error('数据不存在');
        for ($i=0; $i < count($row); $i++) { 
          if ($row[$i]['file'] == '') {
            continue;
          }
            //进行删除文件操作
             $wjm = ROOT_PATH . 'public/' . $row[$i]['file'];
             $wjm = str_replace(DIRECTORY_SEPARATOR, '/', $wjm);
             $wjm = str_replace(DIRECTORY_SEPARATOR, '\/', $wjm);

            if(file_exists($wjm)){
              unlink($wjm);
            }
        }
        
        try {
            $save = $row->delete();
        } catch (\Exception $e) {
            $this->error('删除失败');
        }
        $save ? $this->success('删除成功') : $this->error('删除失败');
    }

}