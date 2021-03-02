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
// | Author：梗集(王国骁)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:12:00
// +----------------------------------------------------------------------

namespace app\admin\controller\admins;

use app\common\controller\AdminController;
use app\common\model\AdminsFeedback as Feedbacks;
use think\App;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="用户回馈")
 */

class Feedback extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'create_time'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Feedbacks();
    }
    /**
     * @NodeAnotation(title="用户回馈列表")
     */
    public function index(){
        if ($this->request->isAjax()){
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $count = $this->model
                ->where($where)
                ->count();
            $list = $this->model
                ->where($where)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();
            $data = [
                'code'  => 0,
                'msg'   => '',
                'count' => $count,
                'data'  => $list,
            ];
            return json($data);
        }
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="用户回馈查看")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $img = $row['imgs'];
        if($img == ''){
            $img=array();
        }else{
            $img = json_decode($img,true);
        }

        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()){
            $post = $this->request->post();
            $rule = [
                'id'=>'require|number',
                'state|状态' => 'require|number|in:0,1',
            ];
            $this->validate($post, $rule);
            $post['update_time']=time();
            try {
                $save = $this->model->where('id', $post['id'])->update($post);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('img', $img);
        $this->assign('row', $row);
        return $this->fetch();
    }
}