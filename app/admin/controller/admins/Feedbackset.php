<?php


namespace app\admin\controller\admins;
use app\common\controller\AdminController;
use app\common\model\AdminsFeedbackset as Feedbacksets;
use app\common\model\Member;
use think\App;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="反馈黑名单")
 */
class Feedbackset extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'create_time'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Feedbacksets();
    }
    /**
     * @NodeAnotation(title="反馈黑名单列表")
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
     * @NodeAnotation(title="反馈黑名单添加")
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'uid|用户UID' => 'require|number',
            ];
            $this->validate($post, $rule);
            $a = Member::find($post['uid']);
            if (empty($a)){
                $this->error('保存失败:用户不存在');
            }
            $b = $this->model->find(['uid'=>$post['uid']]);
            if ($b){
                $this->error('保存失败:用户已在黑名单');
            }
            try {
                $save = $this->model->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        return $this->fetch();
    }
}