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

class OrderAddress extends TimeModel
{
	public function orders()
    {
		return $this->belongsTo('app\common\model\Order','order_id');
    }

    public function province()
    {
        return $this->belongsTo('app\common\model\Area','province_id');
    }

    public function city()
    {
        return $this->belongsTo('app\common\model\Area','city_id');
    }

    public function district()
    {
        return $this->belongsTo('app\common\model\Area','district_id');
    }

    public function street()
    {
        return $this->belongsTo('app\common\model\Area','street_id');
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



//    public function getProvinceIdAttr($value)
//    {
//        $area = Area::where('id', $value)->findOrEmpty();
//        $province = !empty($area)?$area->name: '暂无';
//        print_r($province);die();
//        return $province;
//    }
//
//    public function getCityIdAttr($value)
//    {
//        $area = Area::where('id', $value)->findOrEmpty();
//        $city = !empty($area)?$area->name: '暂无';
//        return $city;
//    }
//
//    public function getDistrictIdAttr($value)
//    {
//        $area = Area::where('id', $value)->findOrEmpty();
//        $district = !empty($area)?$area->name: '暂无';
//        return $district;
//    }
//
//    public function getStreetIdAttr($value)
//    {
//        $area = Area::where('id', $value)->findOrEmpty();
//        $street = !empty($area)?$area->name: '暂无';
//        return $street;
//    }


}