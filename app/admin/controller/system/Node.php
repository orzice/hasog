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
// | DateTime：2020-12-31 18:14:56
// +----------------------------------------------------------------------

namespace app\admin\controller\system;


use app\admin\model\SystemNode;
use app\admin\service\TriggerService;
use app\common\controller\AdminController;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
use EasyAdmin\auth\Node as NodeService;
use think\App;

/**
 * @ControllerAnnotation(title="系统节点管理")
 * Class Node
 * @package app\admin\controller\system
 */
class Node extends AdminController
{

    use \app\admin\traits\Curd;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new SystemNode();
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
            $count = $this->model
                ->count();
            $list = $this->model
                ->getNodeTreeList();
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
     * @NodeAnotation(title="系统节点更新")
     */
    public function refreshNode($force = 0)
    {
        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $nodeList = (new NodeService())->getNodelist();
        
        empty($nodeList) && $this->error('暂无需要更新的系统节点');
        $model = new SystemNode();
        try {
            if ($force == 1) {
                $updateNodeList = $model->whereIn('node', array_column($nodeList, 'node'))->select();
                $formatNodeList = array_format_key($nodeList, 'node');
                foreach ($updateNodeList as $vo) {
                    isset($formatNodeList[$vo['node']]) && $model->where('id', $vo['id'])->update([
                        'title'   => $formatNodeList[$vo['node']]['title'],
                        'is_auth' => $formatNodeList[$vo['node']]['is_auth'],
                    ]);
                }
            }

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
            $this->error('节点更新失败');
        }
        $this->success('节点更新成功');
    }

    /**
     * @NodeAnotation(title="清除失效节点")
     */
    public function clearNode()
    {
        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }

        $nodeList = (new NodeService())->getNodelist();
        $model = new SystemNode();
        try {
            $existNodeList = $model->field('id,node,title,type,is_auth')->select()->toArray();
            $formatNodeList = array_format_key($nodeList, 'node');
            foreach ($existNodeList as $vo) {
                !isset($formatNodeList[$vo['node']]) && $model->where('id', $vo['id'])->delete();
            }
            TriggerService::updateNode();
        } catch (\Exception $e) {
            $this->error('节点更新失败');
        }
        $this->success('节点更新成功');
    }
}