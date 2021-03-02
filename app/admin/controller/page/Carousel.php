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
// | DateTime：2020-12-31 18:16:00
// +----------------------------------------------------------------------
namespace app\admin\controller\page;

use app\common\controller\AdminController;
use app\common\model\PageCarousel as Carousels;
use think\App;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="轮播图管理")
 */
class Carousel extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'create_time'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Carousels();
    }
    /**
     * @NodeAnotation(title="轮播图管理列表")
     */
    public function index()
    {
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
     * @NodeAnotation(title="轮播图管理添加")
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'weight|权重' => 'require|number',
                'thumb|轮播图片' => 'require|url',
                'link|链接' => 'require',
                'state|状态' => 'require|number|in:0,1',
            ];
            $this->validate($post, $rule);
            $post['picture'] = $post['thumb'];
            unset($post['thumb']);
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
     * @NodeAnotation(title="轮播图管理修改")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()){
            $post = $this->request->post();
            $rule = [
                'weight|权重' => 'require|number',
                'thumb|轮播图片' => 'require|url',
                'link|链接' => 'require',
                'state|状态' => 'require|number|in:0,1',
            ];
            $this->validate($post, $rule);
            $post['picture'] = $post['thumb'];
//            print_r($post);die;
            unset($post['thumb']);
            unset($post['file']);
//            print_r($post['id']);die;
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

    public function preview(){
        $row = $this->model->where('state',1)->order('weight','desc')->select()->toArray();
        $this->assign('row',$row);
        return $this->fetch();
    }

}