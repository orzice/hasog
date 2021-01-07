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
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------


namespace app\api\controller;

use app\BaseController;
use app\common\controller\ApiController;
use think\facade\Config;
use think\facade\Event;
use app\common\model\FinaceUprecord;
use app\common\model\FinaceIncome;
use app\common\model\FinaceWithdrawalrecord;

class Finace extends ApiController
{
    //充值记录
    public function uprecord(){
        $id=$this->MemberId();
        $data = FinaceUprecord::where('uid',$id)->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //收入明细
    public function income(){
        $id=$this->MemberId();
        $data = FinaceIncome::where('uid',$id)->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //提现记录
    public function withdrawalrecord(){
        $id=$this->MemberId();
        $data = FinaceWithdrawalrecord::where('uid',$id)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
}