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
// | Author：王火火(王琰豪)  https://gitee.com/w321
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------

namespace app\api\controller;


use app\common\controller\ApiController;
use app\common\model\Member;
use app\common\model\Goods;
use app\common\model\Cart as CartModel;
use think\Exception;
use think\facade\Config;
use think\facade\Event;

class Cart extends ApiController
{
    // 获取购物车列表列表
    public function cart_list()
    {
        $user_id = $this->MemberId();
        $user = Member::where('id', $user_id)->find();
        $get = $this->request->get();
        if (empty($user)) {
            Sessions('member_id', null);
            $this->error('用户信息异常请重新登录');
        }
        $carts = $user->carts()->order('id', 'desc')
            ->hidden(['sku', 'title', 'thumb',])
            ->order('id', 'desc')
            ->paginatefront($get)
            ->select();
        foreach ($carts as &$item) {
            $goods = $item->goods
                ->hidden(['cost_price', 'reduce_stock_method', 'real_sales', 'virtual_sales']);
//                ->select();
            $item->goods = $goods;
            $item->is_valid = $goods->status === 1 ? true : false ;
        }
        $this->success('请求成功', ['carts' => $carts]);
    }


    // 添加商品到购物车列表
    public function add_cart()
    {
        $user_id = $this->MemberId();
        $user = Member::where('id', $user_id)->find();
        if (empty($user)) {
            Sessions('member_id', null);
            $this->error('用户信息异常请重新登录');
        }
        $post = $this->request->post();
//        $goods_data = isset($post['goods']) ? $post['goods'] : [] ;
//        print_r(json_encode(['goods_id'=> 2,'goods_num'=> 10,]));die();
//        {"goods_id":2,"goods_num":10}
        $goods_id = isset($post['goods_id']) ? $post['goods_id'] : null;
        $goods_num = isset($post['goods_num']) ? $post['goods_num'] : null;
        $goods_data = ['goods_id' => $goods_id, 'goods_num' => $goods_num];
        $message = [
            'goods_id' => 'number|require',
            'goods_num' => 'number|require',
        ];
        $validate_result = $this->validate($goods_data, $message);
        if ($validate_result !== true) {
            $this->error('请求参数有误请稍后重试');
        }
        $goods_obj = Goods::where('id', $goods_id)->where('status', 1)->find();
        empty($goods_obj) && $this->error('商品不存在或已下架');
        $old_obj = CartModel::where('goods_id', $goods_id)->where('uid', $user_id)->find();
//        !empty($old_obj) && $this->error('商品已在购物车中');
        if (!empty($old_obj)){
            $old_obj->stock = $old_obj->stock + $goods_num > 200 ? 200 : $old_obj->stock + $goods_num;
            try{
                $save = $old_obj->save();
                if ($save === false){
                    throw new Exception('加入购物车失败了');
                }
            }catch (Exception $e){
                $this->error('加入购物车失败,请稍后重试');
            }
            $this->success('加入购物车成功');
        }
//        if ($goods_obj->stock < $goods_num) {
//            $this->error('购物车商品数量不得大于商品库存');
//        }
        if ($goods_num > 200) {
            $goods_num = 200;
        }
        $cart_goods_data = [
            'uid'=> $user_id,
            'goods_id'=> $goods_id,
            'title'=> $goods_obj->title,
            'thumb'=> $goods_obj->thumb,
            'market_price'=> $goods_obj->market_price,
            'price'=> $goods_obj->price,
            'stock'=> $goods_num,
            'sku'=> $goods_obj->sku,
        ];
        try{
            $cart_goods_obj = new CartModel;
            $save = $cart_goods_obj->save($cart_goods_data);
            if ($save === false){
                throw new Exception('加入购物车失败了');
            }
        }catch (Exception $e){
            $this->error('加入购物车失败,请稍后重试');
        }
        $this->success('加入购物车成功');

    }

    // 修改购物车商品数量
    public function change_cart()
    {
        $user_id = $this->MemberId();
        $user = Member::where('id', $user_id)->find();
        if (empty($user)) {
            Sessions('member_id', null);
            $this->error('用户信息异常请重新登录');
        }
        $post = $this->request->post();
//        $goods_data = isset($post['goods']) ? $post['goods'] : [] ;
//        print_r(json_encode(['goods_id'=> 2,'goods_num'=> 10,]));die();
//        {"goods_id":2,"goods_num":10}
        $cart_goods_id = isset($post['cart_goods_id']) ? $post['cart_goods_id'] : null;
        $cart_goods_obj = CartModel::where('id', $cart_goods_id)->find();
        $goods = $cart_goods_obj->goods;
        empty($cart_goods_obj) && $this->error('购物车商品已删除或不存在');
//        empty($cart_goods_obj) && $this->error('不存在, 请稍后重试');
        $goods_num = isset($post['goods_num']) ? $post['goods_num'] : null;
        $goods_data = ['cart_goods_id' => $cart_goods_id, 'goods_num' => $goods_num];
        $message = [
            'cart_goods_id' => 'number|require',
            'goods_num' => 'number|require',
        ];
        $validate_result = $this->validate($goods_data, $message) ;
        if ($validate_result !== true ){
            $this->error('请求参数有误请稍后重试');
        }
//        if ($goods->stock < $goods_num) {
//            $this->error('购物车商品数量不得大于商品库存');
//        }
        if ($goods_num > 200) {
            $goods_num = 200;
        }
        try{
            $cart_goods_obj->stock = $goods_num;
            $save = $cart_goods_obj->save();
            if ($save === false){
                throw new Exception('错误请稍后重试');
            }
        }catch (Exception $e){
            $this->error('修改失败请稍后重试');
        }
        $this->success('修改成功');
    }

    // 删除购物车商品
    public function delete_cart()
    {
        $user_id = $this->MemberId();
        $user = Member::where('id', $user_id)->find();
        if (empty($user)) {
            Sessions('member_id', null);
            $this->error('用户信息异常请重新登录');
        }
        $post = $this->request->post();
//        {"cart_goods_ids":[1,2,3,4]}
        $cart_goods_ids = isset($post['cart_goods_ids']) ? $post['cart_goods_ids'] : null;
//        is_numeric();
        if(!is_array($cart_goods_ids) && count($cart_goods_ids)){
            $this->error('传输参数有误或没有选中要删除的商品');
        }
//        print_r(implode(',', $cart_goods_ids));die();
        $cart_goods_objs = CartModel::where('uid', $user_id)->whereIn('id',implode(',', $cart_goods_ids))->select();

        try{
            $result = $cart_goods_objs->delete();
            print_r($result);
            if($result === false){
                $this->error('删除失败请稍后重试');
            }
        }catch (Exception $e){
            $this->error('删除失败请稍后重试');
        }
        $this->success('删除成功');
    }


}