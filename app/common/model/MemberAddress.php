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
// | DateTime：2020-12-31 18:22:57
// +----------------------------------------------------------------------

namespace app\common\model;


use app\common\model\TimeModel;
use think\Exception;

class MemberAddress extends TimeModel
{

    const ALLOW_FIELDS = [
//        'status',
//        'change_price',
//        'change_dispatch_price',
//        'merchant_remark',
//        'express_code',
//        'express_company_name',
//        'express_sn',
//        'delete_time'
    ];

    public function member(){
        return $this->belongsTo('app\common\model\Member', 'uid');
    }

    public function area_name(){
        $this->province = $this->find_area($this->province_id);
        $this->city = $this->find_area($this->city_id);
        $this->district = $this->find_area($this->district_id);
        $this->street = $this->find_area($this->street_id);

    }

    public function find_area($id){
        try{
            $area_name = Area::where('id', $id)->find();
            if(empty($area_name)){
                throw new Exception('错误');
            }
            return $area_name->ext_name;
        }catch (Exception $exception){
            return '暂无';
        }
    }

}