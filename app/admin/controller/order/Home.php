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
// | DateTime：2020-12-31 18:16:13
// +----------------------------------------------------------------------

namespace app\admin\controller\order;


use app\common\components\Excel;
use app\common\model\CreditType;
use app\common\model\FinaceOfflinepayment;
use app\common\model\Member;
use app\common\model\Order as OrderModel;
use EasyAdmin\tool\CommonTool;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use think\App;
use think\facade\Config;
use app\common\model\Order;
use app\common\controller\AdminController;
use app\common\model\OrderGoods;
use app\common\model\OrderAddress;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
use think\facade\Db;

/**
 * Class Home
 * @package app\admin\controller\goods
 * @ControllerAnnotation(title="订单管理")
 */
class Home extends AdminController
{
    private static $sep= DIRECTORY_SEPARATOR;

    protected $sort = [
        'id' => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Order();
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


            $get = $this->request->get();
            $action = isset($get['action']) && !empty($get['action']) ? $get['action'] : '{}';
            $action_model = $this->model;
            switch ($action) {
                case 'paid':
                    $this->model = $this->model->where('status', '=',1);
                    break;
                case 'send_goods':
                    $this->model = $this->model->where('status', '=', 2);
                    break;
            }
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
                $where1 = OrderGoods::where($where1);
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
            $this->model = $action_model;
            return json($data);
        }

        $get = $this->request->get();
        $action = isset($get['action']) && !empty($get['action']) ? $get['action'] : '{}';
        $this->assign('action', $action);
        return $this->fetch();
    }

    /**
     * @NodeAnotation(title="订单编辑")
     */
    public function edit($id)
    {
        $order = Order::where('id', $id)->find();
        empty($order) && $this->error('订单不存在');
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $status_str = implode(',', array_keys($this->model::STATUS_ARRAY));
            $rule = [
                'change_price|订单改价金额' => 'float|between: 0,99999999',
                'change_dispatch_price|运费改价金额' => 'float|between: 0,99999999',
                'merchant_remark|商家备注' => 'max:255',
                'express_code|快递公司码' => 'max:50',
                'express_company_name|快递公司名称' => 'max:50',
                'express_sn|快递单号' => 'max:1000',
            ];
            $price = 0;
            $post['express_sn'] = isset($post['express_sn']) ? $post['express_sn'] : [] ;
            if ($order->status!==0){
                unset($post['change_price']);
                unset($post['change_dispatch_price']);
            }
            if ($order->status!==1 && $order->status!==2){
                unset($post['express_code']);
                unset($post['express_company_name']);
                unset($post['express_sn']);
            }
            $price += (isset($post['change_price']) && $post['change_price'] > 0)? $post['change_price'] : $order->goods_price;
            $price += (isset($post['change_dispatch_price']) && $post['change_dispatch_price'] > 0)? $post['change_dispatch_price'] : $order->dispatch_price;
            // 上级分类是否存在 并且存入id
            $this->validate($post, $rule);
            try {
                if($price!=$order->price){
                    $order->price = $price;
                }
                if(!empty($post['express_sn'])){
                    $order->status = 2;
                    $order->send_time = time();
                    $post['express_sn'] = json_encode(array_filter($post['express_sn']));
                }
                $order->save();
                $save = $order->allowField($this->model::ALLOW_FIELDS)->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败'.$e);
            }
            if ($save) {
                $this->success('保存成功');
            }
            $this->error('保存失败');
        }
        $order_xianxia = FinaceOfflinepayment::where('a_state', 1)
        ->where('order_id', $order->id)
            ->order('create_time', 'desc')->find();
        $order_xianxia_id = !empty($order_xianxia) ? $order_xianxia->id : null;

        $express_sns = empty($order->express_sn) ? [] : json_decode($order->express_sn);
        $this->assign('express_sns', $express_sns);
        $this->assign('status_array', Order::STATUS_ARRAY);
        $this->assign('plugin', []);
        $this->assign('order_xianxia_id', $order_xianxia_id);
        $goods = $order->goods;
        foreach ($goods as $item){
            $item->goods_option = !empty($item->goods_option)?json_decode($item->goods_option, true): [];
        }
        $order->goods = $goods;
        $order->status_zh = Order::STATUS_ARRAY[$order->status];
        $this->assign('row', $order);
        return $this->fetch();
    }


    /**
     * @NodeAnotation(title="获取批量发货模版")
     */
    public function batch_delivery()
    {
        $is_ajax = $this->request->isAjax();
        $get = $this->request->get();
//        $post = $this->request->post();
//        print_r($post['id']);die();

        $ids = $get['ids'];

        $ids = explode(',', $ids);
        $results = $this->model->whereIn('id', $ids)
            ->field('order_sn, express_company_name, express_code, express_sn')
            ->select()->toArray();
        $head = ['订单号', '快递单号', '快递公司名', '快递公司码'];
        $keys = ['order_sn', 'express_sn', 'express_company_name', 'express_code'];
        $exp = new \app\common\Excel();
        $file_name = date('Y-m-d H：i：s', time());
        $exp->export($file_name, $results, $head, $keys, 'xlsx');die();
    }

    /**
     * @NodeAnotation(title="确认收款")
     */
    public function receive_money(){
        $post = $this->request->post();
        $order_id = isset($post['order_id'])? $post['order_id'] : '';
        $order = Order::where('id', $order_id)->find();
        (empty($order) || $order->status !== 0)  && $this->error('订单错误或状态不存在');
        try{
            $order->status = 1;
            $save = $order->save();
        }catch (\Exception $e){
            $this->error('订单错误');
        }
        if ($save) {
            event('OrderPay',$order_id);
            $this->success('收款成功', ['status'=>Order::STATUS_ARRAY[$order->status]]);
        }else{
            $this->error('订单错误') ;
        }
    }

    /**
     * @NodeAnotation(title="发货")
     */
    public function send_goods(){
        $post = $this->request->post();
        $order_id = isset($post['order_id'])? $post['order_id'] : '';
        $order = Order::where('id', $order_id)->find();
        (empty($order) || $order->status !== 1)  && $this->error('订单错误');
        try{
            $order->status = 2;
            $order->send_time = time();
            $save = $order->save();
        }catch (\Exception $e){
            $this->error('订单错误');
        }
        if ($save) {
            event('OrderDeliver',$order_id);
            $this->success('发货成功', ['status'=>Order::STATUS_ARRAY[$order->status]]);
        }else{
            $this->error('订单错误') ;
        }
    }

    /**
     * @NodeAnotation(title="确认收货")
     */
    public function receive_goods(){
        $post = $this->request->post();
        $order_id = isset($post['order_id'])? $post['order_id'] : '';
        $order = Order::where('id', $order_id)->find();
        (empty($order) || $order->status !== 2)  && $this->error('订单错误');
        try{
            $order->status = 3;
            $order->finish_time = time();
            $save = $order->save();
        }catch (\Exception $e){
            $this->error('订单错误');
        }
        if ($save) {
            event('OrderReceiving',$order_id);
            $this->success('收货成功', ['status'=>Order::STATUS_ARRAY[$order->status]]);
        }else{
            $this->error('订单错误') ;
        }
    }

    /**
     * @NodeAnotation(title="退款订单")
     */
    public function refund_order(){
        $post = $this->request->post();
        $order_id = isset($post['order_id'])? $post['order_id'] : '';
        $order = Order::where('id', $order_id)->where('is_refund', 1)->find();
        (empty($order) || $order->status !== 2)  && $this->error('订单错误');
        try{
            $order->status = 3;
            $order->finish_time = time();
            $save = $order->save();
        }catch (\Exception $e){
            $this->error('订单错误');
        }
        if ($save) {
            event('OrderReceiving',$order_id);
            $this->success('收货成功', ['status'=>Order::STATUS_ARRAY[$order->status]]);
        }else{
            $this->error('订单错误') ;
        }
    }

    /**
     * @NodeAnotation(title="申请退款")
     */
    public function apply_cancel(){
        $post = $this->request->post();
        $order_id = isset($post['order_id'])? $post['order_id'] : '';
        $order = Order::where('id', $order_id)->find();
        $order = Order::where('id', $order_id)
            ->where('type', 0)
            ->find();
//        empty($order) && $this->error('订单不存在或该订单类型不支持退款');
        (empty($order) || !in_array($order->status, [1, 2, 3]))  && $this->error('该订单暂不支持退款');
        Db::startTrans();
        try{
            $data = [
              'uid' => $order->uid,
              'order_id' => $order->id,
              'price' => $order->price,
              'order_sn' => $order->order_sn,
              'status' => 0,
            ];
            $save_refund = $order->order_refund()->save($data);
            $order->status = -2;
            $save = $order->save();
            if ($save === false || $save_refund === false){
                throw new \Exception('添加失败');
            }
            Db::commit();
        }catch (\Exception $e){
            Db::rollback();
            $this->error('订单错误');
        }
        event('OrderRefund',$order_id);
        $this->success('申请成功', ['status'=>Order::STATUS_ARRAY[$order->status]]);
    }


    /**
     * @NodeAnotation(title="取消订单")
     */
    public function cancel_order(){
        $post = $this->request->post();
        $order_id = isset($post['order_id'])? $post['order_id'] : '';
        $order = Order::where('id', $order_id)->find();
        $order = Order::where('id', $order_id)
            ->where('type', 0)
            ->find();
        empty($order_id) && $this->error('订单不存在');
        $user = Member::find($order->uid);
        if ($order->status === 0 ) {
            $order->status = -1;
            try {
                // 积分退款
                $goods_objs = $order->goods;
                foreach ($goods_objs as $goods_obj){
                    if ($goods_obj->is_deduction == 1 ){
                        $credit_type = CreditType::find($goods_obj->deduction);
                        Member::where('id', $user->id)->inc($credit_type->value, $goods_obj->credit_amount)->update();
                    };
                }
                $save = $order->save();
                if ($save === false) {
                    throw new \Exception('取消订单失败');
                }
            } catch (\Exception $e) {
                $this->error('取消订单失败');
            }
            event('OrderDelete',$order_id);
            $this->success('取消订单成功');
        }
        $this->error('该订单当前状态不能申请退款');
    }

    /**
     * @NodeAnotation(title="批量发货")
     */
    public function batch_delivery_data()
    {
        $root = root_path();
        $sep = self::$sep;
        $dir = $root.'runtime'.$sep.'storage'.$sep;

        $files = $this->request->file();
        $file = $files['file'];
        $savename = \think\facade\Filesystem::putFile( 'topic', $file);

        $exp = new \app\common\Excel();
//        $content = $exp->import($file->getPath() . '\\' . $file->getFilename(), $file->getOriginalExtension());

//        print_r($dir.$savename);die();
        $content = $exp->import($dir.$savename, $file->getOriginalExtension());
        unset($content[0]);
        $msg = '成功';
        Db::startTrans();
        try {
            foreach ($content as $item) {
                $order = $this->model::where('order_sn', $item[0])
                    ->whereIn('status', [1,2])
//                    ->where('status', 1)
//                    ->whereOr('status', 2)
                    ->select()->first();
                !empty($order) && $order->save(['status' => 2, 'express_sn' => json_encode([$item[1]]),
                    'express_company_name' => $item[2], 'express_code' => $item[3],
                    ]);
                event('OrderDelivers', $item[0]);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
//            $msg = '批量发货失败, 请检查格式以及订单号是否正确, 且订单已付款';
            $msg = '批量发货失败, 请检查数据格式以及数据顺序否正确';
        }
        return json(['code' => 0, 'msg' => $msg, 'data' => []]);
    }


    protected $noExportFileds = ['delete_time', 'update_time'];

    /**
     * @NodeAnotation(title="导出")
     */
    public function export()
    {
        list($page, $limit, $where) = $this->buildTableParames();
        $tableName = $this->model->getName();
        $tableName = CommonTool::humpToLine(lcfirst($tableName));
        $prefix = config('database.connections.mysql.prefix');
        $dbList = Db::query("show full columns from {$prefix}{$tableName}");
        $header = [];
        foreach ($dbList as $vo) {
            $comment = !empty($vo['Comment']) ? $vo['Comment'] : $vo['Field'];
            if (!in_array($vo['Field'], $this->noExportFileds)) {
                $header[] = [$comment, $vo['Field']];
            }
        }
        $header[] = ['订单商品', 'order_goods'];
        $header[] = ['收货地址', 'area_address'];
        $header[] = ['详细地址', 'address_detail'];
        $header[] = ['收货姓名', 'address_name'];
        $header[] = ['收货电话', 'address_mobile'];


        $list = $this->model
            ->where($where)
            ->limit(100000)
            ->order('id', 'desc')
            ->select();
//            ->toArray();
        $fileName = time();
        foreach ($list as &$item){
            $address = $item->address;
//            print_r($address);die();
            if (!empty($address)){
                $address->area_name();
                $item->area_address = $address->province .$address->city .$address->district;
                $item->address_detail = $address->address;
                $item->address_name = $address->realname;
                $item->address_mobile = $address->mobile;
            }else{
                $item->area_address = '数据错误,暂无';
                $item->address = '数据错误,暂无';
                $item->address_name = '数据错误,暂无';
                $item->address_mobile ='数据错误,暂无';
            }
            $order_goods_list = $item->goods;
            $order_goods_str = '';
            foreach ($order_goods_list as $order_goods){
                $order_goods_str .= '商品名称:'.$order_goods->title.',' ;
                $order_goods_str .= '商品价格:'.$order_goods->price.',' ;
//                $order_goods_str .= '商品数量:'.$order_goods->total.',' ;
                $order_goods_str .= '商品数量:'.$order_goods->total ;
                $order_goods_str .= "\n";
            }
            $item->order_goods = $order_goods_str;
        }

        $list = $list->toArray();
//        print_r($list[0]);die();
        return \jianyan\excel\Excel::exportData($list, $header, $fileName, 'xlsx');
    }


}
