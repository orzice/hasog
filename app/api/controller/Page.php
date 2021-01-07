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
use app\common\model\PageCarousel;
use app\common\model\PageNotice;


class Page extends ApiController
{
    //轮播图
    public function carousel(){
        $data = PageCarousel::where('state',1)->order('weight','desc')->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //公告列表
    public function noticelist(){
        $data = PageNotice::where('state',1)->order('create_time','desc')->select();
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }
    //公告详情
    public function noticelists(){
        $post = $this->request->post();
        $rule = [
            'id'=>'require|number',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        try {
            $save = PageNotice::where('id',$post['id'])->select();
        } catch (\Exception $e) {
            return api_return(0,'查询失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'查询成功',$save);}else{return api_return(0,'查询失败');}
    }
}