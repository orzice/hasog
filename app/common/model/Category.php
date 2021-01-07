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
use think\facade\Db;
use think\Model;
use think\model\concern\SoftDelete;

class Category extends TimeModel
{

    use SoftDelete;
    const ALLOW_FIELDS = ['parent_id', 'sort', 'thumb', 'name', 'description', 'enabled', 'delete_time'];
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = null;

    // 删除分类执行的
    public static function before_delete_data(Category $model)
    {
        Db::startTrans();
        try {
            Category::delete_all_child($model);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
        return true;
    }

    // 删除全部的子分类
    static function delete_all_child(Category $model)
    {
        if (!$model) {
            return false;
        }
        $documentOne = $model->child_category;
        if (!empty($documentOne)) {
            foreach ($documentOne as $item) {
                self::delete_all_child($item);
            }
            $model->delete();
            return true;
        } else {
            return true;
        }
    }

    // 获取分类关系结构
    public static function get_id_tree($category_id = null)
    {
        $category = Category::where('id', $category_id)->find();
        !empty($category) && $tree = [$category->id];
        if ($category->parent_id) {
            $category_parent = Category::where('id', $category->parent_id)->find();
            !empty($category_parent) && array_unshift($tree, $category_parent->id);
            !empty($category_parent) && array_unshift($tree, $category_parent->parent_id);
        }

        return $tree;
    }


    // 商品分类列表
    public function getCategoryList()
    {
        $list = $this->field('id,parent_id,name,level')
            ->where([
                ['level', '=', 1],
                ['enabled', '=', 1],
            ])
            ->select()
            ->order('sort', 'desc')
            ->toArray();
//        $pidMenuList = $this->get_child_category($list);
        $pidMenuList = [];
        foreach ($list as $item){
            $pidMenuList = array_merge($pidMenuList, $this->get_child_category($item));
        }
        $pidMenuList = array_merge([[
            'id' => 0,
            'parent_id' => 0,
            'name' => '无',
        ]], $pidMenuList);
        return $pidMenuList;
    }

/*    protected function get_child_category1($list)
    {
        $new_result = [];
        foreach ($list as $vo) {
            $child_list = $this->field('id,parent_id,name,level')
                ->where([
                    ['parent_id', '=', $vo['id']],
                    ['level', '=', 2],
                    ['enabled', '=', 1]])
                ->select()->order('sort', 'desc')->toArray();
            $new_result[] = $vo;
            foreach ($child_list as $child) {
                $child_array = $this->field('id,parent_id,name,level')
                    ->where([
                        ['parent_id', '=', $child['id']],
                        ['level', '=', 3],
                        ['enabled', '=', 1]])
                    ->select()->order('sort', 'desc')->toArray();
                $new_result[] = $child;
                $new_result = array_merge($new_result, $child_array);
            }
            $new_result = array_merge($new_result, $child_list);
        }
        foreach ($new_result as &$item) {
            $repeatString = "  ";
            $markString = str_repeat("{$repeatString}├{$repeatString}", $item['level'] - 1);
            $item['name'] = $markString . $item['name'];
        }
        return $new_result;
    }*/

    // 获取某个分类的子分类链
    public function get_child_category($child)
    {
        $new_result = [];
//        $level++;
        $repeatString = " ";
        $new_result[] = $child;
        $child_list = $this->field('id,parent_id,name,level')
            ->where([
                ['parent_id', '=', $child['id']],
//                ['level', '=', $level],
                ['enabled', '=', 1]])
            ->select()->order('sort', 'desc')->toArray();
        if (count($child_list) > 0) {
            foreach ($child_list as $children) {
                $children['name'] = str_repeat("{$repeatString}├{$repeatString}", $children['level'] - 1).$children['name'];
                $result = $this->get_child_category($children);
                $new_result = array_merge($new_result, $result);
            }
        }
        return $new_result;
    }

    public function getPidMenuList()
    {
        $list = $this->field('id,parent_id,name,level')
            ->where([
//                ['parent', '<>', MenuConstant::HOME_PID],
                ['level', '=', 1],
                ['enabled', '=', 1],
            ])
            ->select()
            ->order('sort', 'desc')
            ->toArray();
//        $pidMenuList = $this->get_tre_category(0, $list, 1);
        $pidMenuList = $this->append_space($list);
        $pidMenuList = array_merge([[
            'id' => 0,
            'parent_id' => 0,
            'name' => '无',
        ]], $pidMenuList);
//        print_r(json_encode($pidMenuList));
//        exit();
        return $pidMenuList;
    }

    protected function append_space($list)
    {
        $new_result = [];
        foreach ($list as $vo) {
            $child_list = $this->field('id,parent_id,name,level')
                ->where([
                    ['parent_id', '=', $vo['id']],
                    ['level', '=', 2],
                    ['enabled', '=', 1]])
                ->select()->order('sort', 'desc')->toArray();
            $new_result[] = $vo;
            $new_result = array_merge($new_result, $child_list);
        }
        foreach ($new_result as &$item) {
            if ($item['level'] == 2) {
                $repeatString = " ";
                $markString = str_repeat("{$repeatString}├{$repeatString}", $item['level'] - 1);
                $item['name'] = $markString . $item['name'];
            }
        }
        return $new_result;
    }

    public function childCategory()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    // 获取分类id关系

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

}