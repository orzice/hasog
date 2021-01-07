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
// | Author：王火火(王琰豪)  https://gitee.com/w321
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:16:46
// +----------------------------------------------------------------------

namespace app\admin\controller\goods;


use app\admin\model\SystemNode;
use app\admin\service\TriggerService;
use app\common\constants\MenuConstant;
use think\App;
use think\facade\Config;
use app\common\model\Goods;
use app\common\model\Dispatch;
use app\common\controller\AdminController;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

/**
 * Class Category
 * @package app\admin\controller\goods
 * @ControllerAnnotation(title="商品管理")
 */
class Category extends AdminController
{

    use \app\admin\traits\Curd;

    const IS_EXISTS = ['is_hot', 'is_discount', 'is_new'];

    // 复选框 判断
    protected $sort = [
        'sort' => 'desc',
        'id' => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new \app\common\model\Category();
    }

    /**
     * @NodeAnotation(title="列表")
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            if (input('selectFieds')) {
                return $this->selectList();
            }
            $count = $this->model->count();
            $list = $this->model->order($this->sort)->select();
            $data = [
                'code' => 0,
                'msg' => '',
                'count' => $count,
                'data' => $list,
            ];
            return json($data);
        }
        return $this->fetch();
    }

    // 判断复选框是否存在 并入库
    public function is_exists(Array &$post)
    {
        foreach (self::IS_EXISTS as $item) {
            $post['goods'][$item] = key_exists($item, $post['goods']) ? 1 : 0;
            !key_exists($item, $post['goods']) && array_push($post['goods'], [$item => 0]);
        }
    }

    /**
     * @NodeAnotation(title="添加")
     */
    public function add($id = null)
    {
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'parent_id|上级分类' => 'number',
                'name|分类描述' => 'require',
                'thumb|分类封面' => 'require',
                'description|分类描述' => 'require',
                'sort|分类排序' => 'number',
            ];
            // 上级分类是否存在 并且存入id
            $post['level'] = 1;
            if ($post['parent_id'] !== 0) {
                $parent_category = $this->model->find($post['parent_id']);
                $parent_category['level'] == 3 && $this->error('上级分类不能是三级分类');
                $post['level'] = $parent_category['level'] + 1;
            }
            $this->validate($post, $rule);
            $is_exists = $this->model->whereExists(['name', '=', $post['name']]);
            !$is_exists && $this->error('保存失败,分类名已存在');
            try {
                $save = $this->model->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if ($save) {
                Uploadfile($post['thumb']);
                $this->success('保存成功');
            }
            $this->error('保存失败');
//            $save ? $this->success('保存成功') : $this->error('保存失败') ;
        }
        $pidMenuList = $this->model->getPidMenuList();
        $this->assign('category_plugin', []);
        $this->assign('id', $id);
        $this->assign('pidMenuList', $pidMenuList);
        return $this->fetch();
    }

    /**
     * @NodeAnotation(title="编辑")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        empty($row) && $this->error('数据不存在');
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'name|分类描述' => 'require',
                'thumb|分类封面' => 'require',
                'description|分类描述' => 'require',
                'sort|分类排序' => 'number',
            ];
            // 上级分类是否存在 并且存入id
            $post['level'] = 1;
            if ($post['parent_id'] !== 0) {
                $parent_category = $this->model->find($post['parent_id']);
                $parent_category['level'] == 3 && $this->error('上级分类不能是三级分类');
                $post['level'] = $parent_category['level'] + 1;
            }
            $this->validate($post, $rule);
            $is_exists = $this->model->whereExists(['name', '=', $post['name']]);
            !$is_exists && $this->error('保存失败,分类名已存在');
            try {
                $save = $this->model->find($id)->allowField($this->model::ALLOW_FIELDS)->save($post);
            }
            catch (\Exception $e) {
                $this->error('保存失败' . $e);
            }
            if ($save) {
                Uploadfile($post['thumb']);
                $this->success('保存成功');
            }
            $this->error('保存失败');
//            $save ? $this->success('保存成功') : $this->error('保存失败') ;
        }
        $pidMenuList = $this->model->getPidMenuList();
        $this->assign('category_plugin', []);
        $this->assign([
            'id' => $id,
            'pidMenuList' => $pidMenuList,
            'row' => $row,
        ]);
        return $this->fetch();
    }

    /**
     * @NodeAnotation(title="删除")
     */
    public function delete($id)
    {
        $row = $this->model->whereIn('id', $id)->select();
        empty($row) && $this->error('数据不存在');
        $save = false;
        try {
            $save_all = $this->model::before_delete_data($row[0]);
//            $save_all && $save = $row[0]->delete();
        } catch (\Exception $e) {
            $this->error('删除失败');
        }
        if ($save_all) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * @NodeAnotation(title="属性修改")
     */
    public function modify()
    {
        $post = $this->request->post();
        $rule = [
            'id|ID' => 'require',
            'field|字段' => 'require',
            'value|值' => 'require',
        ];
        $this->validate($post, $rule);
        $row = $this->model->find($post['id']);
        if (!$row) {
            $this->error('数据不存在');
        }
        if (!in_array($post['field'], $this->allowModifyFileds)) {
            $this->error('该字段不允许修改：' . $post['field']);
        }
//        $homeId = $this->model
//            ->where([
//                'pid' => MenuConstant::HOME_PID,
//            ])
//            ->value('id');
//        if ($post['id'] == $homeId && $post['field'] == 'status') {
//            $this->error('首页状态不允许关闭');
//        }
        try {
            $row->save([
                $post['field'] => $post['value'],
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
//        TriggerService::updateMenu();
        $this->success('保存成功');
    }

    /**
     * @NodeAnotation(title="添加菜单提示")
     */
    public function getMenuTips()
    {
        $node = input('get.keywords');
        $list = SystemNode::whereLike('node', "%{$node}%")
            ->field('node,title')
            ->limit(10)
            ->select();
        return json([
            'code' => 0,
            'content' => $list,
            'type' => 'success',
        ]);
    }


}
