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
// | DateTime：2020-12-31 18:13:43
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\controller\AdminController;
use think\facade\Config;
use app\common\Plugins;
use think\facade\Db;
use app\admin\model\SystemAdmin;
use app\admin\model\SystemQuick;
use app\common\model\Member;
use app\common\model\Goods;
use app\common\model\Order;

use EasyAdmin\auth\Node as NodeService;


class Index extends AdminController
{
    /**
     * 后台主页
     * @return string
     * @throws \Exception
     */
    public function index()
     {
        // 触发UserLogin事件 用于执行用户登录后的一系列操作
        event('AdminHome');

        return $this->fetch();
        //return "-结束";
    }
    /**
     * 后台欢迎页
     * @return string
     * @throws \Exception
     */
    public function home()
     {
        // 触发UserLogin事件 用于执行用户登录后的一系列操作
        event('AdminHome');

        $serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
        $serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
        $serversoft = $_SERVER['SERVER_SOFTWARE'];

        $mysqlinfo = \think\facade\Db::query("select VERSION()");
        $dbversion = $mysqlinfo[0]['VERSION()'];
        $res['member'] = Member::where('delete_time','NULL')->count();
        $res['goods'] = Goods::where('delete_time','NULL')->count();
         $res['order'] = Order::where('delete_time','NULL')->count();
         $res['list'] = Db::name('member')->whereDay('create_time')->count();

         $member = Member::where('delete_time','NULL')->order('credit2','desc')->limit(4)->select()->toArray();
         if (empty($member)){
             for ($i=0;$i<4;$i++){
                 $member[$i]['id'] = '无';
                 $member[$i]['credit2'] = '无';
             }
         }
         for ($i=0;$i<4;$i++){
             if ($i<count($member)){
                 $a = $i+1;
                 $member[$i]['ph']="第"."$a"."名";
             }else{
                 $a = $i+1;
                 $member[$i]['id'] = '无';
                 $member[$i]['credit2'] = '无';
                 $member[$i]['ph']="第"."$a"."名";
             }
         }
         $data = array();
         $list=Db::name("member")
             ->alias('a')
             ->where('a.delete_time','NULL')
             ->join('order b','a.id=b.uid')
             ->where('b.delete_time','NULL')
             ->where('b.status','3')
             ->field(['a.id,count(*) as count'])
             ->group('a.id')
             ->order('count','desc')
             ->limit('4')
             ->select()->toArray();
         if (empty($list)){
             for ($i=0;$i<4;$i++){
                 $list[$i]['id'] = '无';
                 $list[$i]['count'] = '无';
             }
         }
         for ($i=0;$i<4;$i++){
             if ($i<count($list)){
                 $a = $i+1;
                 $data[$i] = $list[$i];
                 $data[$i]['ph']="第"."$a"."名";
             }else{
                 $a = $i+1;
                 $data[$i]['id'] = '无';
                 $data[$i]['count'] = '无';
                 $data[$i]['ph']="第"."$a"."名";
             }


         }
         $this->assign('list',$data);
         $this->assign('member',$member);
        $this->assign('res',$res);
        $this->assign('serverinfo', $serverinfo);
        $this->assign('serversoft', $serversoft);
        $this->assign('dbversion', $dbversion);
        return $this->fetch();
    }

    /**
     * 修改管理员信息
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editAdmin()
    {
        $id = Sessions('id');
        $row = (new SystemAdmin())
            ->withoutField('password')
            ->find($id);
        empty($row) && $this->error('用户信息不存在');
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [];
            $this->validate($post, $rule);
            try {
                $save = $row
                    ->allowField(['phone', 'remark', 'update_time'])
                    ->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }

    /**
     * 修改密码
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editPassword()
    {
        $id = Sessions('id');
        $row = (new SystemAdmin())
            ->withoutField('password')
            ->find($id);
        if (!$row) {
            $this->error('用户信息不存在');
        }
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'password|登录密码'       => 'require|alphaNum|length:4,20',
                'password_again|确认密码' => 'require|alphaNum|length:4,20',
            ];
            $this->validate($post, $rule);
            if ($post['password'] != $post['password_again']) {
                $this->error('两次密码输入不一致');
            }

            try {
                $save = $row->save([
                    'password' => password($post['password']),
                ]);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if ($save) {
                $this->success('保存成功');
            } else {
                $this->error('保存失败');
            }
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
}