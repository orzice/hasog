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
// | Author：王火火(王琰豪) https://gitee.com/w321
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:16:23
// +----------------------------------------------------------------------

namespace app\admin\controller\order;


use app\common\model\CreditType;
use app\common\model\FinaceBalancesub;
use app\common\model\Member;
use app\common\model\OrderPay;
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
/*            if (input('selectFieds')) {
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
            return json($data);*/
        }
        return $this->fetch();
    }


    /**
     * @NodeAnotation(title="审核退款")
     */
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
//                            $order->status = -1;
                            $order->status = -3;
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
                $order_pay = OrderPay::where('order_id', $order->id)->where('status', 1)->find();
                if(empty($order_pay)){
                    Db::rollback();
                    $this->error('支付记录不存在');
                }
                $order_pay->status = 0;
                $user = $order->member;
                switch ($order_pay->pay_type_id){
                    case 4:
                        $user->credit2 += $order_pay->amount;
                        $balance_change = new FinaceBalancesub([
                            'uid'=> $user->id,
                            'before_balance'=> $user->credit2,
                            'remark'=> '订单号'.$order->order_sn.'退款'.$order->price,
                            'balance'=> $user->credit2 + $order->price,
                            'state'=> 1,
                            'credit_type'=> 1,
                            'money'=> $order->price,
                        ]);
                        $change_save = $balance_change->save();
                        if ($change_save === false){
                            Db::rollback();
                            throw new \Exception('添加失败');
                        }
                        break;
                    case 3;
                        break;
                }

                $pay_save = $order_pay->save();

                // 积分退款
                $goods_objs = $order->goods;
                foreach ($goods_objs as $goods_obj){
                    if ($goods_obj->is_deduction === 1 ){
                        $credit_type = CreditType::find($goods_obj->deduction);
                        Member::where('id', $user->id)->inc($credit_type->value, $goods_obj->credit_amount)->update();
                    };
                }


                if($save === false || $order_save === false || $pay_save === false)
                {
                    throw new \Exception('添加失败');
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                $this->error('保存失败了' . $e);
            }
            $this->success('保存成功');
        }
        $this->assign('status_array', $this->model::STATUS_ARRAY);
        $this->assign('status_zh', $this->model::STATUS_ARRAY[$order_refund->status]);
        $this->assign('plugin', []);
        $this->assign('row', $order_refund);
        return $this->fetch();
    }




}
