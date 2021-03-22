<?php


namespace app\admin\controller\page;
use app\common\controller\AdminController;
use app\common\model\PageNavigation as Navigations;
use think\App;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="导航管理")
 */
class Navigation extends AdminController
{
    use \app\admin\traits\Curd;
    protected $sort = [
        'weight'   => 'desc',
    ];
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Navigations();
    }
    /**
     * @NodeAnotation(title="导航管理列表")
     */
    public function index(){
        if ($this->request->isAjax()) {
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
     * @NodeAnotation(title="导航管理添加")
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'name|导航名称'=>'require',
                'weight|权重' => 'require|number',
                'thumb|导航图标' => 'require|url',
                'link|链接' => 'require',
                'state|状态' => 'require|number|in:0,1',
            ];
            $this->validate($post, $rule);
            try {
                $save = $this->model->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="导航管理修改")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()){
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'name|导航名称'=>'require',
                'weight|权重' => 'require|number',
                'thumb|导航图标' => 'require|url',
                'link|链接' => 'require',
                'state|状态' => 'require|number|in:0,1',
            ];
            $this->validate($post, $rule);
            unset($post['file']);
            try {
                $save = $this->model->where('id', $post['id'])->update($post);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
}