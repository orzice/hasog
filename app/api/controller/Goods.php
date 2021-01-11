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
use app\common\model\Category;
use app\common\model\GoodsCategory;
use app\common\model\Member;
use app\common\model\Goods as GoodsModel;
use think\facade\Config;
use think\facade\Event;

class Goods  extends ApiController
{
    // 获取商品列表
    public function goods_list(){
        // 可以通过 中间件 省略步骤
//        $goods_list = GoodsModel::select();
        $get = $this->request->get();
        $category_id = isset($get['category_id']) ? $get['category_id'] : null;
        $msg = '获取分类下的商品失败，返回全部商品';
        $goods_list = GoodsModel::select();
        if($category_id){
            $category = Category::where('id', '=', $category_id)->where('enabled', 1)->find();
            if(!empty($category)){
                $msg = '获取分类成功';
                // 这种方法 分类如果enabled 或者 delete 就还能查出
                $goods_category = GoodsCategory::where('category_ids', 'like', $category_id . ',%')
                    ->whereOr('category_ids', 'like', '%,' . $category_id . ',%')
                    ->whereOr('category_ids', 'like', '%,' . $category_id);
//                    ->order('sort', 'desc');
//                ->paginateX([
//                    'query'     => [], //url额外参数
//                    'fragment'  => '', //url锚点
//                    'var_page'  => 'page', //分页变量
//                    'list_rows' => 1, //每页数量
//                ]);
                $goods_ids = $goods_category->column('goods_id');
//                print_r($goods_ids);die();
//                $goods_count = $goods_list->count();
                $goods_list = GoodsModel::whereIn('id', $goods_ids)->where('status', 1)
                    ->hidden(['cost_price','reduce_stock_method', 'real_sales', 'virtual_sales' ])
//                    ->limit(0,1)
                    ->paginatefront($get)
                    ->select();
//                    ->select();
/*                foreach ($goods_list as &$goods){
                    $category_goods = $goods_category->where('goods_id','=', $goods->id)->findOrEmpty();
                    $goods['category'] = $category_goods;
                }*/
            }
            else{$this->error('分类不存在或暂时被禁用');}
        }
        foreach ($goods_list as &$goods){
            $category_goods = GoodsCategory::where('goods_id','=', $goods->id)->find();
            $goods['category'] = $category_goods;
        }
        $goods_count = $goods_list->count();

        $this->success($msg,['goods_count'=> $goods_count, 'goods_list'=> $goods_list]);
    }

    // 商品分类列表
    public function goods_category_list(){
        $categories = Category::where('enabled', 1)
            ->order('sort')
            ->select();
        $this->success('获取分类成功', ['categories'=> $categories]);
    }

    // 商品详情列表
    public function goods_detail(){
        $get = $this->request->get();
        $goods_id = isset($get['goods_id']) ? $get['goods_id'] : null;
        $goods = GoodsModel::where('id', '=', $goods_id)->hidden(['cost_price','reduce_stock_method', 'real_sales', 'virtual_sales' ])->find();
        $user_id = $this->MemberId();
        $is_favor = false;
        if($user_id){
            $user = Member::where('id', $user_id)->find();
            if (!empty($user)){
//                $favor_obj = GoodsFavor::where('uid', $user_id)
                $favor_obj = $user->favors()
                    ->where('goods_id', $goods->id)
                    ->find();
                !empty($favor_obj) && $is_favor = true;
            }
        }
        empty($goods) && $this->error('商品不存在');
//        $goods->status === 0 && $this->error('商品已下架');
        $goods->status === 0 && $this->error('商品已下架');
        $this->success('获取商品信息成功', ['goods'=> $goods, 'is_favor'=> $is_favor]);
    }





}