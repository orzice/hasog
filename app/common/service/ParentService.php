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
// | DateTime：2021-02-07 12:53:09
// +----------------------------------------------------------------------

namespace app\common\service;

use app\common\model\Member;
use think\facade\Db;

/*
app\common\service\ParentService
  核心思想  如何可以随意修改上下级关系 且 数据量大的时候还有可靠性？？？

  parent_id   父ID
  parent_ids    父ID组 使用 /uid/ 进行分割
  parent_ids_s   0未初始化  1初始化  为0时 不可信   定时任务处理
    

1   0   
2   1   /1/
3   2   /1/2/
4   3   /1/2/3/
5   4   /1/2/3/4/

3 -> 1 下边

1   0   
2   1   /1/
3   1   /1/2/  ->  /1/
4   3   /1/2/3/  ->  /1/3/
5   4   /1/2/3/4/  ->  /1/3/4/

需要搜索 /1/2/3/  替换为  /1/3/

*/
class ParentService
{

    protected $adminId;
    /**
     *  获取上下级关系 返回用户数组
     */
    public function ParentGet($uid=0)
    {
        $this->model = new Member();
        $uids = $this->model->where('id',$uid)->find();
        $parent_ids = $this->ParentInit($uids['parent_id']);
        if ($parent_ids == '') {
            return [];
        }

        $arr = explode("/", $parent_ids);
        $arr = array_filter($arr);//清空空数据
        $arr = array_merge($arr);//索引重置
        $return = [];

        for ($i=0; $i < count($arr); $i++) {
            $row = $this->model->where('id',$arr[$i])->find();
            //不存在 到下一次
            if (!$row) {
                continue;
            }
            
            $return[] = $row->toArray();

        }
        return $return;
    }
    /**
     *  创建上下级关系【新建账号】 【从0改为其他】返回层级
     */
    public function ParentInit($parent_id=0)
    {
        $this->model = new Member();
        $parent_ids = '';

        $return = false; 
        $x = 0;
        $uid = $parent_id;

        while(!$return) {
            $parent = $this->model->where('id',$uid)->find();
            if ($parent_ids == '') {
                $parent_ids = '/'.$parent['id'].'/'.$parent_ids;
            }else{
                $parent_ids = '/'.$parent['id'].$parent_ids;
            }
            if($parent['parent_ids_s'] == 1){
                return str_replace("//","/",$parent['parent_ids'].$parent_ids);
            }
            if($parent['parent_id'] == 0){
                return $parent_ids;
            }
            $uid = $parent['parent_id'];
            $x++;
        }
        return '';
    }
    /**
     *  移动上下级关系【修改上级】 进行处理 只针对自己的下级进行排除 不针对自己
     */
    public function ParentEdit($uid=0,$parent_oid=0)
    {
        //先获取旧上级的层级
        $member = $this->ParentInit($parent_oid);
        if ($member !== '') {
            $member = $member.$uid.'/';
        }
        //获取自己的下级
        $this->model = new Member();
        $parent = $this->model->where('parent_ids', 'like',$member.'%')->select();//模糊查询下级 并给予下级失效
        $this->model->where('parent_ids_s',1)->where('parent_ids', 'like',$member.'%')->update(['parent_ids_s' => 0]);//置 不可信
        return true;
    }
}