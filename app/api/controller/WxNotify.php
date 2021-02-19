<?php


namespace app\api\service;


class WxNotify extends \WxPayNotify
{
    //重写微信回调通知函数
    //用ngrox软件进行测试使用
    public function NotifyProcess($objData, $config, &$msg)
    {
        //返回结果里面result_code为业务结果,return_code为通信结果,所以这里判断要用result_code判断
        if ($objData['return_code'] == "SUCCESS") {
            //获取订单号
            $orderNo=$objData['out_trade_no'];
            /*业务逻辑
            1.检查库存量,超卖
            2.更新这个订单的status状态
            3.减库存*/
            DB::beginTransaction(); //开启事务
            try{
                //获取数据库查询的订单号,伪代码
                $order=Order::where('order_no',$orderNo)->get();
                //因为微信的回调是不断进行的,需要判断哪些情况进行处理.
                //这里需要加一个判断,只处理订单状态为未支付的,避免重复操作
                if($order->status==1){
                    //1更新订单状态
                    //2消减库存量
                }
                DB::commit();  //提交
                return true;
            }catch (\Exception $e)
            {
                //日志记录错误
                DB::rollback();  //回滚
                return false;
            }
        }else{
            //这里控制微信是否继续发送异步通知
            return true;
        }
    }
}