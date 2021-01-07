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
// | DateTime：2020-12-31 18:16:18
// +----------------------------------------------------------------------

namespace app\admin\controller\order;


use think\App;
use think\facade\Config;
use app\common\model\Order;
use app\common\controller\AdminController;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\model\OrderAddress;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
use think\queue\command\Retry;


class OrderGoods extends AdminController
{

    protected $sort = [
        'id' => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new OrderGoodsModel();
    }

    /**
     * @NodeAnotation(title="订单列表")
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();

            $w1 = false;
            $where1 = array();
            $where2 = array();

            for ($i = 0; $i < count($where); $i++) {
                if (strpos($where[$i][0], 'goods') !== false) {
                    $where[$i][0] = str_replace("goods.", "", $where[$i][0]);
                    $where1[] = $where[$i];
                } else {
                    $where2[] = $where[$i];
                }
            }
            if (count($where1) !== 0) {
                $where1 = OrderGoodsModel::where($where1);
                $w1 = true;
            }

            $count = $this->model;
            if ($w1) {
                $count = $count->hasWhere('goods', $where1);
            }
            $count = $count->with(['goods', 'address'])
                ->where($where2)
                ->count();

            $list = $this->model;
            if ($w1) {
                $list = $list->hasWhere('goods', $where1);
            }
            $list = $list->with(['goods', 'address'])
                ->where($where2)
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

    public function get_goods()
    {
//        if ($this->request->isAjax()) {

        $order_id = $this->request->get('order_id');
        $page = $this->request->get('page');
        $limit = $this->request->get('limit');
        $order = OrderGoodsModel::whereNull('delete_time')->where('id', $order_id)->find();
        $msg = '';
        $code = 0;
        $count = 0;
        $order_goods = [];
        if (!empty($order)) {
//            print_r($order);die();
            $order_goods = $this->model->where('order_id', $order->id)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();
            $count = count($order_goods);
        } else {
            $msg = '订单不存在';
            $code = 1;
        }
        $data = [
            'code' => $code,
            'msg' => $msg,
            'count' => $count,
            'data' => $order_goods,
        ];
//        return json($data);
        $this->assign('code', $code);
        $this->assign('msg', $msg);
        $this->assign('count', $count);
        $this->assign('order_goods', $order_goods);
        return $this->fetch();
//        }
//        return $this->fetch();
    }


    public function edit($id)
    {
        $order = Order::where('id', $id)->find();
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $rule = [
                'name|名称' => 'require',
                'app_id|app_id' => 'require',
                'app_secret|app_secret' => 'require',
                'merchant_id|商户号id' => 'require',
                'merchant_secret|商户号支付秘钥' => 'require',
                'cert_file|cert证书文件' => 'require',
                'key_file|key秘钥文件' => 'require',
                'open_status|标准微信支付' => 'require',
            ];
            // 上级分类是否存在 并且存入id
            $this->validate($post, $rule);
            $is_exists = $this->model->whereExists(['name', '=', $post['name']]);
            !$is_exists && $this->error('保存失败,名称已存在');
            try {
                $save = $this->model->find($id)->allowField($this->model::ALLOW_FIELDS)->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败' . $e);
            }
            if ($save) {
                Uploadfile($post['cert_file']);
                Uploadfile($post['key_file']);
                $this->success('保存成功');
            }
            $this->error('保存失败');
        }
        $this->assign('status_array', Order::STATUS_ARRAY);
        $this->assign('plugin', []);
        $order->goods;

        $this->assign('row', $order);
//        print_r($order);die();
        return $this->fetch();
    }


    public function batch_delivery(){

    }


}
