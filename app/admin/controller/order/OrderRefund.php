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
// | DateTime：2020-12-31 18:16:23
// +----------------------------------------------------------------------

namespace app\admin\controller\order;


use think\App;
use think\facade\Config;
use app\common\controller\AdminController;
use app\common\model\OrderRefund as OrderRefundModel;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
use think\facade\Db;
use think\queue\command\Retry;

/**
 * Class OrderRefund
 * @package app\admin\controller\goods
 * @ControllerAnnotation(title="订单退款")
 */
class OrderRefund extends AdminController
{

    protected $sort = [
        'id' => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new OrderRefundModel();
    }

    /**
     * @NodeAnotation(title="退款列表")
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            if (input('selectFieds')) {
                return $this->selectList();
            }
            $count = $this->model->count();
            $list = $this->model->select();
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



    public function edit($id)
    {
        $order_refund = $this->model::where('id', $id)->find();
        $order = $order_refund->orders;
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $status_key = implode(',' , array_keys($this->model::STATUS_ARRAY));
            $rule = [
                'status|审核状态' => 'in:'.$status_key,
                'reason|驳回原因' => 'max:255',
                'remark|备注' => 'max:255',
            ];
            // 上级分类是否存在 并且存入id
            $this->validate($post, $rule);
            if ($order_refund->status !==0 && isset($post['status'])) {
                unset($post['status']);
                unset($post['reason']);
            };
            Db::startTrans();
            try {
                if(isset($post['status'])){
                    switch ($post['status']){
                        case 1:
                            $order->status = -1;
                            $order->cancel_time = time();
                            break;
                        case 2:
                            $order->status = 1;
                            break;
                        default:
                            break;
                    }
                }
                $order_save = $order->save();
                $save = $order_refund->allowField($this->model::ALLOW_FIELDS)->save($post);
            } catch (\Exception $e) {
                DB::rollback();
                $this->error('保存失败了' . $e);
            }
            if ($save) {
                DB::commit();
                $this->success('保存成功');
            }
            DB::rollback();
            $this->error('保存失败');
        }
        $this->assign('status_array', $this->model::STATUS_ARRAY);
        $this->assign('status_zh', $this->model::STATUS_ARRAY[$order_refund->status]);
        $this->assign('plugin', []);
        $this->assign('row', $order_refund);
//        print_r($order);die();
        return $this->fetch();
    }






    public function batch_delivery(){

    }


}
