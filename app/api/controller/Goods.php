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
use app\common\model\CreditType;
use app\common\model\GoodsCategory;
use app\common\model\Member;
use app\common\model\Goods as GoodsModel;
use Complex\Exception;
use think\facade\Config;
use think\facade\Event;

class Goods  extends ApiController
{
    // 获取商品列表
    public function goods_list(){
        $get = $this->request->get();
        $category_id = isset($get['category_id']) ? $get['category_id'] : null;
        $msg = '获取分类下的商品失败，返回全部商品';
        if($category_id){
            $category = Category::where('id', '=', $category_id)->where('enabled', 1)->find();
            if(!empty($category)){
                $msg = '获取分类成功';
                // 这种方法 分类如果enabled 或者 delete 就还能查出
                $goods_category = GoodsCategory::where('category_ids', 'like', $category_id . ',%')
                    ->whereOr('category_ids', 'like', '%,' . $category_id . ',%')
                    ->whereOr('category_ids', 'like', '%,' . $category_id);
                $goods_ids = $goods_category->column('goods_id');
                $goods_list = GoodsModel::whereIn('id', $goods_ids)->where('status', 1)
                    ->hidden(['cost_price','reduce_stock_method', 'show_sales' ]);
                $goods_count = $goods_list->count();
                $goods_list = $goods_list->paginatefront($get)->select();
            }
            else{
//                $this->error('分类不存在或暂时被禁用');
                return api_return(0, '分类不存在或暂时被禁用');
            }
        }else{
            $goods_list = GoodsModel::where('status', 1);
            $goods_count = $goods_list->count();
            $goods_list = $goods_list->paginatefront($get)->select();
        }
        foreach ($goods_list as &$goods){
            $category_goods = GoodsCategory::where('goods_id','=', $goods->id)->find();
            $goods['category'] = $category_goods;
            $goods->show_sales = $goods->real_sales + $goods->virtual_sales;
            $goods->hidden(['real_sales', 'virtual_sales']);
        }
        $list_count = $goods_list->count();
        //支持HTTPS
        $host = "//".$this->request->host();
        for ($i=0; $i < count($goods_list); $i++) { 
           $goods_list[$i]['thumb'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['thumb']);
           $goods_list[$i]['thumb_url'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['thumb_url']);
           $goods_list[$i]['content'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['content']);
        }
        $this->success($msg,['goods_count'=> $goods_count,'list_count'=> $list_count, 'goods_list'=> $goods_list]);
    }


    // 获取商品列表
    public function goods_search(){
        $get = $this->request->get();
        $goods_title = isset($get['goods_title']) ? $get['goods_title'] : null;
        $msg = '获取失败';
        if($goods_title){
                $msg = '获取商品成功';
                // 这种方法 分类如果enabled
                $goods_list = GoodsModel::where('title', 'like', '%'.$goods_title . '%')->where('status', 1)
                    ->hidden(['cost_price','reduce_stock_method', 'show_sales']);
                $goods_count = $goods_list->count();
                $goods_list = $goods_list->paginatefront($get)->select();
                $list_count = $goods_list->count();
        }else{
            $goods_count = 0;
            $goods_list = [];
            $list_count = 0;
        }
        foreach ($goods_list as &$goods){
            $category_goods = GoodsCategory::where('goods_id','=', $goods->id)->find();
            $goods['category'] = $category_goods;
            $goods->show_sales = $goods->real_sales + $goods->virtual_sales;
            $goods->hidden(['real_sales', 'virtual_sales']);
        }

        //支持HTTPS
        $host = "//".$this->request->host();
        for ($i=0; $i < count($goods_list); $i++) { 
           $goods_list[$i]['thumb'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['thumb']);
           $goods_list[$i]['thumb_url'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['thumb_url']);
           $goods_list[$i]['content'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['content']);
        }
        $this->success($msg,['goods_count'=> $goods_count,'list_count'=> $list_count, 'goods_list'=> $goods_list]);
    }


    // 商品分类列表
    public function goods_category_list(){
        $categories = Category::where('enabled', 1)->where('level', 1)
            ->order('sort')
            ->select();
        foreach ($categories as $item){
            $item->child_category;
            foreach ($item->child_category as $second_item){
                $second_item->child_category;
            }
        }
        
        $this->success('获取分类成功', ['categories'=> $categories]);
    }

    // 商品详情列表
    public function goods_detail(){
        $get = $this->request->get();
        $goods_id = isset($get['goods_id']) ? $get['goods_id'] : null;
        $goods = GoodsModel::where('id', '=', $goods_id)->hidden(['cost_price','reduce_stock_method', 'show_sales'])->find();
//        empty($goods) && $this->error('商品不存在');
        if(empty($goods)){
            return api_return(0, '商品不存在');
        }
        $goods->show_sales = $goods->real_sales + $goods->virtual_sales;
        $goods->hidden(['real_sales', 'virtual_sales']);
        $user_id = $this->MemberId();
        $is_favor = false;
        if($user_id){
            $user = Member::where('id', $user_id)->find();
            if (!empty($user)){
                $favor_obj = $user->favors()
                    ->where('goods_id', $goods->id)->whereNull('delete_time')
                    ->find();
                !empty($favor_obj) && $is_favor = true;
            }
        }
        $description = json_decode($goods->description, true);
        $description_array = [];
        $save_description = [];
        foreach ($description as $item){
            if (in_array($item['title'], $description_array)){
                $save_description[array_search($item['title'],$description_array)]['value'][]= $item['value'];
            }else {
                $save_description[] = ['title'=> $item['title'], 'value'=>[$item['value']]];
                $description_array[] = $item['title'];
            }
        }
        $goods->description = $save_description;
        $credit_type = CreditType::find($goods->deduction);
//        $goods->credit_type = $credit_type;
        $goods->credit_title = $credit_type->title;
//        print_r($description_array);die();
//        empty($goods) && $this->error('商品不存在');
//        $goods->status === 0 && $this->error('商品已下架');
        if($goods->status === 0){
            return api_return(0, '商品已下架');
        }
//        $this->success('获取商品信息成功', ['goods'=> $goods, 'is_favor'=> $is_favor]);

        //支持HTTPS
        $host = "//".$this->request->host();
        $goods['thumb'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods['thumb']);
        $goods['thumb_url'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods['thumb_url']);
        $goods['content'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods['content']);
        

        return api_return(1, '获取商品信息成功', ['goods'=> $goods, 'is_favor'=> $is_favor]);
    }

    // 获取标签商品列表
    public function goods_tag_list(){
        $get = $this->request->get();
        // 这种方法 分类如果enabled 或者 delete 就还能查出
        $goods_list = GoodsModel::where('status', 1)->where('is_new', 1)->whereOr('is_hot', 1)->whereOr('is_discount', 1)
            ->hidden(['cost_price','reduce_stock_method', 'show_sales' ]);
        $goods_count = $goods_list->count();
        $goods_list = $goods_list->paginatefront($get)->select();
        foreach ($goods_list as &$goods){
            $category_goods = GoodsCategory::where('goods_id','=', $goods->id)->find();
            $goods['category'] = $category_goods;
            $goods->show_sales = $goods->real_sales + $goods->virtual_sales;
            $goods->hidden(['real_sales', 'virtual_sales']);
        }
        $list_count = $goods_list->count();

        //支持HTTPS
        $host = "//".$this->request->host();
        for ($i=0; $i < count($goods_list); $i++) { 
           $goods_list[$i]['thumb'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['thumb']);
           $goods_list[$i]['thumb_url'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['thumb_url']);
           $goods_list[$i]['content'] = str_replace(['http:'.$host,'https:'.$host],$host, $goods_list[$i]['content']);
        }

        $this->success('获取标签商品成功',['goods_count'=> $goods_count,'list_count'=> $list_count, 'goods_list'=> $goods_list]);
    }

}