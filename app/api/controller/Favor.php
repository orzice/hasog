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
use app\common\model\GoodsFavor;
use app\common\model\Goods;

class Favor extends ApiController
{
    public function favorlist(){
        $id = $this->MemberId();
        $data = GoodsFavor::where('uid',$id)->where('delete_time','null')->order('create_time','desc')->select();
        foreach ($data as $dat){
            $dat->goods;
        }
        if (count($data) == 0) {
            return api_return(0,'没有数据');
        }
        $data = $data->toArray();
        return api_return(1,'查询成功',$data);
    }

    public function favoradd(){
        $id = $this->MemberId();
        $post = $this->request->post();
        $rule = [
            'goods_id|商品id'      => 'require|number',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $post['uid'] = $id;
        $post['create_time'] = time();
        $data = $this->goods($post['goods_id']);
        if (!count($data)){api_return(0,'商品不存在');}
        $data = GoodsFavor::where('uid',$id)->where('goods_id',$post['goods_id'])->where('delete_time','null')->select();
        if (count($data)){
            return api_return(0,'已收藏');
        }
        try {
            $datas = GoodsFavor::where('uid',$id)->where('goods_id',$post['goods_id'])->select();
            if (count($datas)){
                $post['delete_time']=Null;
                $save = GoodsFavor::where('uid',$id)->where('goods_id',$post['goods_id'])->update($post);
            }else{
                $save = GoodsFavor::insert($post);
            }
        } catch (\Exception $e) {
            return api_return(0,'收藏失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'收藏成功');}else{return api_return(0,'收藏失败');}
    }

    public function favordel(){
        $id = $this->MemberId();
        $post = $this->request->post();
        $rule = [
            'goods_id|商品id'      => 'require|number',
        ];
        $validate = $this->validate($post, $rule);
        //验证失败
        if($validate !== true){
            return api_return(0,$validate);
        }
        $data = $this->goods($post['goods_id']);
        if (!count($data)){api_return(0,'商品不存在');}
        $data = GoodsFavor::where('uid',$id)->where('goods_id',$post['goods_id'])->where('delete_time','<>','null')->select();
        if (count($data)){
            return api_return(0,'未收藏');
        }
        $post['delete_time'] = time();
        $post['uid'] = $id;
        try {
            $save = GoodsFavor::where('uid',$id)->where('goods_id',$post['goods_id'])->update($post);
        } catch (\Exception $e) {
            return api_return(0,'取消收藏失败:'.$e->getMessage());
        }
        if ($save){return api_return(1,'取消收藏成功');}else{return api_return(0,'取消收藏失败');}
    }
     public function goods($goods_id){
        $data = Goods::where('id',$goods_id)->select();
        return $data;
     }

}