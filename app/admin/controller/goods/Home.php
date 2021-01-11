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
// | DateTime：2020-12-31 18:16:46
// +----------------------------------------------------------------------

namespace app\admin\controller\goods;


use app\common\model\GoodsCategory;
use think\App;
use think\facade\Config;
use app\common\model\Goods;
use app\common\model\Dispatch;
use app\common\model\Category as CategoryModel;
use app\common\controller\AdminController;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
use think\facade\Db;

/**
 * Class Home
 * @package app\admin\controller\goods
 * @ControllerAnnotation(title="商品管理")
 */
class Home extends AdminController
{

    use \app\admin\traits\Curd;

    const IS_EXISTS = ['is_hot', 'is_discount', 'is_new'];

    // 复选框 判断
    protected $sort = [
        'id' => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Goods();
    }

    /**
     * @NodeAnotation(title="列表")
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

    /**
     * @NodeAnotation(title="添加")
     */
    public function add()
    {
        event('GoodsAdd');
        if ($this->request->isAjax()) {
            $post = $this->request->post();
//            print_r($post);
//            exit();
            $rule = [
                'category_id|商品分类' => 'require|number',
                'goods.title|商品名称' => 'require',
                'goods.type|商品类型' => 'require|number|in:0,1',
                'goods.sku|商品单位' => 'require|chs',

                'goods.market_price|原价' => 'require|float',
                'goods.price|现价' => 'require|float',
                'goods.cost_price|成本' => 'require|float',
                'goods.virtual_sales|虚拟销量' => 'require|number',
                'goods.weight|重量' => 'require|number',
                'goods.stock|库存' => 'require|number',
                'goods.reduce_stock_method|减库存方式' => 'require|number|in:0,1,2',

                'goods.no_refund|不可退货退款' => 'require|number|in:0,1',
                'goods.status|是否上架' => 'require|number|in:0,1',

                'goods.dispatch|配送模板' => 'require|number',

                'thumb|商品图片' => 'require|url',
                'thumb_url|其他图片' => 'require|url',

                'goods.dt|商品属性' => 'array',
                'goods.dv|商品属性' => 'array',
            ];
            $this->validate($post, $rule);
            $post['goods']['thumb'] = $post['thumb'];
            $post['goods']['thumb_url'] = $post['thumb_url'];
            $post['goods']['content'] = $post['describe'];

            //
            if (key_exists('dt', $post['goods']) && key_exists('dv', $post['goods'])) {
                if (count($post['goods']['dt']) !== count($post['goods']['dv'])) {
                    $this->error('商品属性格式错误');
                }
                $post['goods']['descriptions'] = array();
                for ($i = 0; $i < count($post['goods']['dt']); $i++) {
                    if ($post['goods']['dt'] == '' || $post['goods']['dv'] == '') {
                        $this->error('商品属性不能为空！');
                    }
                    $post['goods']['descriptions'][] = array(
                        'title' => $post['goods']['dt'][$i],
                        'value' => $post['goods']['dv'][$i],
                    );
                }
                $post['goods']['description'] = json_encode($post['goods']['descriptions']);
            }

            // 判断是否传入分类并且不能为0(无) 然后取出分类关系插入数据库
            $category_id = $post['category_id'] ? $post['category_id'] : 0;
            $category_id === 0 && $this->error('请选择商品分类');
            $category = CategoryModel::where('id', $category_id)->findOrEmpty();
            empty($category) && $this->error('分类不存在');
            $category['level'] != 3 && $this->error('请选择三级分类');
            // 可能存在的问题 如果以后 改成多级分类 一直加载parent_category 直到顶部
            $category_ids = CategoryModel::get_id_tree($category->id);
            $goodsCategory = [
                'goods_id' => 1,
                'category_id' => $category_id,
                'category_ids' => implode(',', $category_ids),
                'create_time' => time(),
                'update_time' => time(),
            ];
            event('GoodsAddPost', $post);
            Db::startTrans();
            try {
                $model_obj = $this->model;
                $save = $model_obj->save($post['goods']);
                $goods_category = new GoodsCategory;
                $goodsCategory['goods_id'] = $model_obj->id;
                $result = $goods_category->save($goodsCategory);
                Db::commit();
                ($post['goods']['thumUploadfileb']);

                Uploadfile($post['goods']['thumb_url']);
            } catch (\Exception $e) {
                Db::rollback();
                $this->error('保存失败:' . $e->getMessage());
            }
            $result && $save ? $this->success('保存成功') : Db::rollback() && $this->error('保存失败');
        }
        /*        Config::set([count(Config::get('goodsadd')) => [
                    'name' => '插件A模块',
                    'src' => 'a/view/admin/goods_123',
                ]], 'goodsadd');*/
        $goodsadd = Config::get('goodsadd');
//        print_r($goodsadd);
//        exit();
        $dispatch = Dispatch::where('state', 1)->select();
        $category_model = new CategoryModel();
        $pidMenuList = $category_model->getCategoryList();
        $this->assign('pidMenuList', $pidMenuList);

        $this->assign('dispatch', $dispatch);
        $this->assign('goodsadd', $goodsadd);
        return $this->fetch();
    }

    /**
     * @NodeAnotation(title="修改")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        event('GoodsEdit', $id);
        $old_goods_category = GoodsCategory::where('goods_id', $id)
            ->order('create_time', 'desc')
            ->findOrEmpty();

        if ($this->request->isAjax()) {
            $post = $this->request->post();
//            print_r($post);
//            exit();
//            $post['goods']['is_hot'] = 3;

            $rule = [
                'category_id|商品分类' => 'require|number',
                'goods.title|商品名称' => 'require',
                'goods.type|商品类型' => 'require|number|in:0,1',
                'goods.sku|商品单位' => 'require|chs',

                'goods.market_price|原价' => 'require|float',
                'goods.price|现价' => 'require|float',
                'goods.cost_price|成本' => 'require|float',
                'goods.virtual_sales|虚拟销量' => 'require|number',
                'goods.weight|重量' => 'require|number',
                'goods.stock|库存' => 'require|number',
                'goods.reduce_stock_method|减库存方式' => 'require|number|in:0,1,2',

                'goods.no_refund|不可退货退款' => 'require|number|in:0,1',
                'goods.status|是否上架' => 'require|number|in:0,1',

                'goods.dispatch|配送模板' => 'require|number',

                'thumb|商品图片' => 'require|url',
                'thumb_url|其他图片' => 'require|url',

                'goods.dt|商品属性' => 'array',
                'goods.dv|商品属性' => 'array',
            ];
            $this->validate($post, $rule);
            $post['goods']['thumb'] = $post['thumb'];
            $post['goods']['thumb_url'] = $post['thumb_url'];
            $post['goods']['content'] = $post['describe'];
            if (key_exists('dt', $post['goods']) && key_exists('dv', $post['goods'])) {

                if (count($post['goods']['dt']) !== count($post['goods']['dv'])) {
                    $this->error('商品属性格式错误');
                }
                $post['goods']['descriptions'] = array();
                for ($i = 0; $i < count($post['goods']['dt']); $i++) {
                    if ($post['goods']['dt'] == '' || $post['goods']['dv'] == '') {
                        $this->error('商品属性不能为空！');
                    }
                    $post['goods']['descriptions'][] = array(
                        'title' => $post['goods']['dt'][$i],
                        'value' => $post['goods']['dv'][$i],
                    );
                }
                $post['goods']['description'] = json_encode($post['goods']['descriptions']);
            }
            event('GoodsEditPost', $post);


            // 判断分类是否更改如果修改则软删除之前的记录，并新增
            $category_id = $post['category_id'] ? $post['category_id'] : 0;
            $category_id === 0 && $this->error('请选择商品分类');
            $category = CategoryModel::where('id', $category_id)->findOrEmpty();
            empty($category) && $this->error('分类不存在');
            $category['level'] != 3 && $this->error('请选择三级分类');

            // 如果所属分类变化 则软删除之间的关系  构造新的关系
            $goodsCategory=false;
            if ($category_id != $old_goods_category['category_id']) {
                // 可能存在的问题 如果以后 改成多级分类 一直加载parent_category 直到顶部
                $category_ids = CategoryModel::get_id_tree($category->id);
                $goodsCategory = [
                    'goods_id' => $id,
                    'category_id' => $category->id,
                    'category_ids' => implode(',', $category_ids),
                    'create_time' => time(),
                    'update_time' => time(),
                ];
            }
            // 判断请求中是否存在标签 存在......不存在......
            $this->is_exists($post);
//            print_r($post['goods']);
//            exit();

            Db::startTrans();
            try {
                unset($post['goods']['descriptions']);
                unset($post['goods']['dt']);
                unset($post['goods']['dv']);
                $goods = $this->model->find($id);
                $save = $goods->save($post['goods']);
                $goods_category = new GoodsCategory;
                $goodsCategory && $result = $goods_category->save($goodsCategory);
                $goodsCategory && $old_goods_category->delete();
                Uploadfile($post['goods']['thumb']);
                Uploadfile($post['goods']['thumb_url']);
                Db::commit();
            } catch (\Exception $e) {
                $this->error('保存失败:' . $e->getMessage());
                Db::rollback();
            }
            // 没有修改分类
            if(!$goodsCategory){
                $save ? $this->success('保存成功') : Db::rollback() && $this->error('保存失败');
            }else{
                $save && $result ? $this->success('保存成功') : Db::rollback() && $this->error('保存失败');
            }
        }


        $goodsadd = Config::get('goodsedit');
        $dispatch = Dispatch::where('state', 1)->select();
        $row['descriptions'] = json_decode($row['description'], true);
        if (!$row['descriptions']) {
            $row['descriptions'] = array();
        }

        // 传入分类选项
        $category_model = new CategoryModel();
        $pidMenuList = $category_model->getCategoryList();
        $this->assign('pidMenuList', $pidMenuList);

        $this->assign('category_id', $old_goods_category->category_id);

        $this->assign('dispatch', $dispatch);
        $this->assign('goodsadd', $goodsadd);
        $this->assign('row', $row);


        return $this->fetch();
    }

    public function is_exists(Array &$post)
    {
        foreach (self::IS_EXISTS as $item) {
            $post['goods'][$item] = key_exists($item, $post['goods']) ? 1 : 0;
            !key_exists($item, $post['goods']) && array_push($post['goods'], [$item => 0]);
        }
    }

    /**
     * @NodeAnotation(title="删除")
     */
    public function delete($id)
    {
        $row = $this->model->whereIn('id', $id)->select();
        $row->isEmpty() && $this->error('数据不存在');
        $old_goods_category = GoodsCategory::where('goods_id', $id)
            ->order('create_time', 'desc')
            ->findOrEmpty();
        try {
            $old_goods_category->delete();
            $save = $row->delete();
        } catch (\Exception $e) {
            $this->error('删除失败');
        }
        $save ? $this->success('删除成功') : $this->error('删除失败');
    }



}
