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
// | DateTime：2020-12-31 18:12:38
// +----------------------------------------------------------------------
namespace app\admin\controller\finace;

use app\common\controller\AdminController;
use app\common\model\FinaceWithdrawalrecord as Withdrawalrecords;
use app\common\model\Member;
use think\App;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="用户提现记录")
 */
class Withdrawalrecord extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'create_time'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Withdrawalrecords();
    }
    /**
     * @NodeAnotation(title="用户提现记录列表")
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $w1 = false;
            $where1 = array();
            $where2 = array();

            for ($i=0; $i < count($where); $i++) {
                if(strpos($where[$i][0],'member')!==false){
                    $where[$i][0] = str_replace("member.","",$where[$i][0]);
                    $where1[] = $where[$i];
                }else{
                    $where2[] = $where[$i];
                }
            }
            if (count($where1) !== 0) {
                $where1 = Member::where($where1);
                $w1 = true;
            }

            $count = $this->model;
            if ($w1) {
                $count = $count->hasWhere('member',$where1);
            }
            $count = $count->with(['member'])
                ->where($where2)
                ->count();
            $list = $this->model;
            if ($w1) {
                $list = $list->hasWhere('member',$where1);
            }
            $list = $list->with(['member'])
                ->where($where2)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();

            $data = [
                'code'  => 0,
                'msg'   => '',
                'count' => $count,
                'data'  => $list,
            ];
            return json($data);
        }
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="修改")
     */
//    public function edit($id)
//    {
//        $row = $this->model->find($id);
//        $row->isEmpty() && $this->error('数据不存在');
//        if ($this->request->isAjax()){
//            $post = $this->request->post();
//            $rule = [
//                'id'=>'require|number',
//                'uid'=>'require|number',
//                'number'=>'require|number',
//                'money'=>['^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$'],
//                'numstatus'=>'require|number|in:0,1,2,3',
//                'status'=>'require|number|in:0,1,2,3,4,5',
//            ];
//            $this->validate($post['goods'], $rule);
//            try {
//                $save = $this->model->where('id',$post['goods']['id'])->update($post['goods']);
//            } catch (\Exception $e) {
//                $this->error('保存失败:'.$e->getMessage());
//            }
//            $save ? $this->success('保存成功') : $this->error('保存失败');
//        }
//        $this->assign('row',$row);
//        return $this->fetch();
//    }

}