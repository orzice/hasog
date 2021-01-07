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
// | Author：梗集(王国骁)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------


namespace app\api\controller;

use app\BaseController;
use app\common\controller\ApiController;
use think\facade\Config;
use think\facade\Event;
use app\common\model\MemberAddress as MemberAddresss;

class Member extends ApiController
{
    //收货地址列表
    public function index(){
        $id=$this->MemberId();
        $data = MemberAddresss::where('uid',$id)->where('delete_time','null')->order('is_default','desc')->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //收货地址添加
    public function add(){
        $post = $this->request->post();
        $id=$this->MemberId();
        $rule = [
            'name|收货人姓名'      => 'require|chsAlphaNum',
            'connect_mobile|收货人电话'      => 'require|mobile',
            'is_default|是否默认地址'      => 'require|in:0,1',
            'province_id|省id'      => 'require|number',
            'city_id|市id'      => 'require|number',
            'district_id|区id'      => 'require|number',
            'area|详细地址'      => 'require|chsDash',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $post['create_time'] = time();
        $post['uid'] = $id;
        try {
            if ($post['is_default'] == 1){
                $data = MemberAddresss::where('uid',$id)->where('is_default',1)->select();
                if (count($data) !== 0) {
                    $saves = MemberAddresss::where('uid',$id)->update(['is_default'=>0]);
                }
            }
            $save = MemberAddresss::insert($post);
        } catch (\Exception $e) {
            return api_return(0,'添加失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'添加成功');}else{return api_return(0,'添加失败');}
    }
    //收货地址修改
    public function edit(){
        $post = $this->request->post();
        $id=$this->MemberId();
        $rule = [
            'id|ID'=>'require|number',
            'name|收货人姓名'      => 'require|chsAlphaNum',
            'connect_mobile|收货人电话'      => 'require|mobile',
            'is_default|是否默认地址'      => 'require|in:0,1',
            'province_id|省id'      => 'require|number',
            'city_id|市id'      => 'require|number',
            'district_id|区id'      => 'require|number',
            'area|详细地址'      => 'require|chsDash',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $det = MemberAddresss::where('uid',$id)->where('id',$post['id'])->select();
        if (count($det) == 0){
            return api_return(0,'修改失败:没有该地址');
        }
        $post['update_time'] = time();
        $post['uid'] = $id;
        try {
            if ($post['is_default'] == 1){
                $data = MemberAddresss::where('uid',$id)->where('is_default',1)->select();
                if (count($data) !== 0) {
                    $saves = MemberAddresss::where('uid',$id)->update(['is_default'=>0]);
                }
            }
            $save = MemberAddresss::update($post);
        } catch (\Exception $e) {
            return api_return(0,'修改失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'修改成功');}else{return api_return(0,'修改失败');}
    }
    //收货地址删除
    public function del(){
        $post = $this->request->post();
        $id=$this->MemberId();
        $rule = [
            'id'=>'require|number',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $det = MemberAddresss::where('uid',$id)->where('id',$post['id'])->select();
        if (count($det) == 0){
            return api_return(0,'删除失败:没有该地址');
        }
        $post['delete_time'] = time();
        try {
            $save = MemberAddresss::update($post);
        } catch (\Exception $e) {
            return api_return(0,'删除失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'删除成功');}else{return api_return(0,'删除失败');}
    }
}