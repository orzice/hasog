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

// | DateTime：2020-12-31 18:16:04

// +----------------------------------------------------------------------

namespace app\admin\controller\page;



use app\common\controller\AdminController;

use app\common\model\PageNotice as Notices;

use think\App;



use EasyAdmin\annotation\ControllerAnnotation;

use EasyAdmin\annotation\NodeAnotation;

/**

 * Class Test

 * @package app\admin\controller\page

 * @ControllerAnnotation(title="公告管理")

 */

class Notice extends AdminController

{

    use \app\admin\traits\Curd;

    public function __construct(App $app)

    {

        parent::__construct($app);

        $this->model = new Notices();

    }

    /**

     * @NodeAnotation(title="公告管理列表")

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

    /**

     * @NodeAnotation(title="公告管理添加")

     */

    public function add(){

        if ($this->request->isAjax()) {
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }

            $post = $this->request->post();

            $rule = [

                'goods.title|公告标题' => 'require',

                'goods.state|状态' => 'require|number|in:0,1',

            ];

            $this->validate($post, $rule);

            $post['goods']['notice'] = $post['notice'];

            try {

                $save = $this->model->save($post['goods']);

            } catch (\Exception $e) {

                $this->error('保存失败:'.$e->getMessage());

            }

            $save ? $this->success('保存成功') : $this->error('保存失败');

        }

        return $this->fetch();

    }

    /**

     * @NodeAnotation(title="公告管理修改")

     */

    public function edit($id){

        $row = $this->model->find($id);

        $row->isEmpty() && $this->error('数据不存在');

        if ($this->request->isAjax()){
        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
            $post = $this->request->post();

            $rule = [

                'goods.title|公告标题' => 'require',

                'goods.state|状态' => 'require|number|in:0,1',

            ];

            $this->validate($post, $rule);

            $post['goods']['notice'] = $post['notice'];

            try {

                $save = $this->model->where('id',$post['id'])->update($post['goods']);

            } catch (\Exception $e) {

                $this->error('保存失败:'.$e->getMessage());

            }

            $save ? $this->success('保存成功') : $this->error('保存失败');

        }

        $this->assign('row',$row);

        return $this->fetch();

    }

}