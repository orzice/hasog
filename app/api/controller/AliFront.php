<?php


namespace app\api\controller;

use app\common\controller\ApiController;
use app\common\model\AliPay;
use app\common\model\CreditType;
use app\common\model\FinaceBalancesub;
use app\common\model\FinaceUprecord;
use app\common\model\Member;
use app\common\model\OrderPay;
use app\common\model\Order;
use app\common\model\PayLog;
use app\common\pay\AliPays;
use Symfony\Component\HttpFoundation\Response;
use think\App;
use think\Exception;
use think\facade\Db;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

class AliFront extends ApiController
{
    // 阿里支付成功回调url
    public function ali_return($pay_id){
        $get = $this->request->get();
        $pay_log = PayLog::where('id', $pay_id)->find();
        $ali_account = AliPay::where('id', $pay_log->pay_account)->find();
        $ali_account = !empty($ali_account)? $ali_account : null ;
        $ali_pay = new AliPays();
        // 获取支付订单时的微信配置参数
        $ali_pay->init($ali_account);
        $return_url = $this->request->domain().'/api/ali_front/ali_return/'.$pay_id.'/';
        $pay = $ali_pay->return_pay_obj($this->request->url(true), $pay_id, $return_url);
        $data = $pay->verify(); // 是的，验签就这么简单！
        $order = Order::where('order_sn', $data['out_trade_no'])->find();
/*        try{
            Log::debug('Alipay notify', $data->all());
            $pay_log->status = 1;
            $pay_log->pay_id = 'test';
            $pay_log->result_notice = json_encode($data);
            Db::startTrans();
            $pay_log->save();
            $order->status = 1;
            $order->pay_type_id = 1;
            $order->pay_time = time();
            // 生成支付记录
            $order_pay = new OrderPay([
                'uid'=> $order->uid,
                'order_id'=> $order->id,
                'order_sn'=> $order->order_sn,
                'status'=> 1,
                'pay_type_id'=> 1,
                'pay_time'=> time(),
                'amount'=> $order->price,
            ]);
            $pay_save = $order_pay->save();
            // 商品是否是支付时扣除库存 如果是则扣除
            $goods_array = $order->goods;
            $goods_result = true;
            foreach ($goods_array as &$goods_obj) {
                $goods = $goods_obj->goods;
                if ($goods->reduce_stock_method === 1) {
                    $goods->stock -= $goods_obj->total;
//                        $goods->show_sales += $goods_obj->total;
                    $goods->real_sales += $goods_obj->total;
//                        $goods->virtual_sales += $goods_obj->total;
                    $goods_result = $goods->save();
                    if (!$goods_result) {
                        break;
                    }
                }
            }
            $save = $order->save();
            if ($save === false || $goods_result === false || $pay_save === false) {
                throw new \Exception('添加失败');
            }
            Db::commit();
            event('OrderPay',$order->id);
            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            Db::rollback();
            return api_return(0, '错误');
        }*/
        $pay_log = $data['pay_log'];
        $result = $data['result'];
        $this->assign('order', $order);
        $this->assign('pay_log', $pay_log);
        $this->assign('jsApiParameters', 'test');
        $this->assign('redirect_url', $this->request->domain().'/#/paySuccess');
        return $this->fetch('/pay/wechat/jsapi');
    }

    // 阿里支付成功回调url
    public function ali_balance_return($pay_id){
        $get = $this->request->get();
        $pay_log = PayLog::where('id', $pay_id)->find();
        $ali_account = AliPay::where('id', $pay_log->pay_account)->find();
        $ali_account = !empty($ali_account)? $ali_account : null ;
        $ali_pay = new AliPays();
        // 获取支付订单时的微信配置参数
        $ali_pay->init($ali_account);
        $return_url = $this->request->domain().'/api/ali_front/ali_balance_return/'.$pay_id.'/';
        $pay = $ali_pay->return_pay_obj($this->request->url(true), $pay_id, $return_url);
        $user = Member::where('id', $pay_log->uid)->find();
        $old_credit = $user->credit2;
        $data = $pay->verify(); // 是的，验签就这么简单！
/*        try{
            $pay_log->status = 1;
            $pay_log->pay_id = 'test';
            $pay_log->result_notice = json_encode($data);
            Db::startTrans();
            $pay_log->save();
            $balancesub['money'] = $pay_log->amount;
            $balancesub['uid']   = $pay_log->uid;
            $balancesub['before_balance'] = $old_credit; // 修改前积分
            $balancesub['balance'] = $old_credit + $pay_log->amount; // 修改后的积分
            $balancesub['remark'] = '阿里余额'.$pay_log->amount;
            $balancesub['state'] = 2;
            $balancesub['create_time'] = time();
            $uprecord['uid'] = $pay_log->uid;
            $uprecord['way'] = 0;
            $uprecord['before_balance'] = $old_credit; // 修改前积分
            $uprecord['after_balance'] = $old_credit + $pay_log->amount; // 修改后的积分
            $uprecord['remark'] = '阿里余额'.$pay_log->amount;
            $uprecord['money'] = $pay_log->amount;
            $uprecord['state'] = 1;
            $uprecord['create_time'] =time();

            $uprecord['credit_type'] = 1;
            $balancesub['credit_type'] = 1;
            $save = FinaceBalancesub::insert($balancesub);
            Member::where('id', $pay_log->uid)->inc('credit2', $pay_log->amount)->update();
            $save = FinaceUprecord::insert($uprecord);
            Db::commit();
            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            Db::rollback();
            return api_return(0, '错误');
        }*/
        $pay_log = $data['pay_log'];
        $result = $data['result'];
        $this->assign('uid', $pay_log->id);
        $this->assign('pay_log', $pay_log);
        $this->assign('amount', $pay_log->amount);
        $this->assign('jsApiParameters', 'result');
//        $this->assign('redirect_url', $this->request->domain().'/#/paySuccess');
        $this->assign('redirect_url', $this->request->domain().'/#/paySuccess');
        return $this->fetch('/pay/wechat/jsapi_balance');
    }



    // 支付订单
    public function ali_no($id, $pay_id)
    {
        $order = Order::find($id);
        $get = $this->request->get();
        $pay_log = PayLog::where('id', $pay_id)->find();
        $ali_account = AliPay::where('id', $pay_log->pay_account)->find();
        $ali_account = !empty($ali_account)? $ali_account : null ;
        $ali_pay = new AliPays();
        // 获取支付订单时的微信配置参数
        $ali_pay->init($ali_account);
        $return_url = $this->request->domain().'/api/ali_front/ali_return/'.$pay_id.'/';
        $pay = $ali_pay->return_pay_obj($this->request->url(true), $pay_id, $return_url);
        try{
            $data = $pay->verify(); // 是的，验签就这么简单！
//            if ($data['trade_status'] !==  'TRADE_SUCCESS'){
//                throw new Exception('支付失败');
//            }
//            $pay_log = new PayLog([
//                'pay_id'=> $data['transaction_id'],
//                'pay_account'=> $data['transaction_id'],
//                'order_sn'=> $order->order_sn,
//                'pay_type'=> 1,
//                'result_notice'=> json_encode($data),
//                'log_type'=> 1,
//                'create_time'=> time(),
//            ]);
            $pay_log->status = 1;
            $pay_log->pay_id = 'test';
            $pay_log->result_notice = json_encode($data);
            Db::startTrans();
            $pay_log->save();
            $order->status = 1;
            $order->pay_type_id = 1;
            $order->pay_time = time();
            // 生成支付记录
            $order_pay = new OrderPay([
                'uid'=> $order->uid,
                'order_id'=> $order->id,
                'order_sn'=> $order->order_sn,
                'status'=> 1,
                'pay_type_id'=> 1,
                'pay_time'=> time(),
                'amount'=> $order->price,
            ]);
            $pay_save = $order_pay->save();
            // 商品是否是支付时扣除库存 如果是则扣除
            $goods_array = $order->goods;
            $goods_result = true;
            foreach ($goods_array as &$goods_obj) {
                $goods = $goods_obj->goods;
                if ($goods->reduce_stock_method === 1) {
                    $goods->stock -= $goods_obj->total;
//                        $goods->show_sales += $goods_obj->total;
                    $goods->real_sales += $goods_obj->total;
//                        $goods->virtual_sales += $goods_obj->total;
                    $goods_result = $goods->save();
                    if (!$goods_result) {
                        break;
                    }
                }
            }
            $save = $order->save();
            if ($save === false || $goods_result === false || $pay_save === false) {
                throw new \Exception('添加失败');
            }
            Db::commit();
            event('OrderPay',$order->id);
            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            Db::rollback();
//            $this->error('支付失败请稍后重试');
            return new Response('fail');
        }
        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }


    // 余额充值
    public function ali_balance($pay_id)
    {
        $pay_log = PayLog::where('id',$pay_id)->find();
        $ali_account = AliPay::where('id', $pay_log->pay_account)->find();
        $ali_account = !empty($ali_account)? $ali_account : null ;
        $ali_pay = new AliPays();
        // 获取支付订单时的微信配置参数
        $ali_pay->init($ali_account);
        $return_url = $this->request->domain().'/api/ali_front/ali_balance_return/'.$pay_id.'/';
        $pay = $ali_pay->return_pay_obj($this->request->url(true), $pay_id, $return_url);
        $user = Member::where('id', $pay_log->uid)->find();
        $old_credit = $user->credit2;
        try{
            $data = $pay->verify(); // 是的，验签就这么简单！
//            if ($data['trade_status'] !==  'TRADE_SUCCESS'){
//                throw new Exception('支付失败');
//            }
            $pay_log->status = 1;
            $pay_log->pay_id = $data['transaction_id'];
            $pay_log->result_notice = json_encode($data);
            Db::startTrans();
            $pay_log->save();
            $balancesub['money'] = $pay_log->amount;
            $balancesub['uid']   = $pay_log->uid;
            $balancesub['before_balance'] = $old_credit; // 修改前积分
            $balancesub['balance'] = $old_credit + $pay_log->amount; // 修改后的积分
            $balancesub['remark'] = '阿里充值余额'.$pay_log->amount;
            $balancesub['state'] = 2;
            $balancesub['create_time'] = time();
            $uprecord['uid'] = $pay_log->uid;
            $uprecord['way'] = 0;
            $uprecord['before_balance'] = $old_credit; // 修改前积分
            $uprecord['after_balance'] = $old_credit + $pay_log->amount; // 修改后的积分
            $uprecord['remark'] = '阿里充值余额'.$pay_log->amount;
            $uprecord['money'] = $pay_log->amount;
            $uprecord['state'] = 1;
            $uprecord['create_time'] =time();

            $uprecord['credit_type'] = 1;
            $balancesub['credit_type'] = 1;
            $save = FinaceBalancesub::insert($balancesub);
            Member::where('id', $pay_log->uid)->inc('credit2', $pay_log->amount)->update();
            $save = FinaceUprecord::insert($uprecord);
            Db::commit();
            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            Db::rollback();
//            $this->error('支付失败请稍后重试');
            return api_return(0, '支付失败请稍后重试');
        }
        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }




}