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
// | DateTime：2020-12-31 18:12:53
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
 * @ControllerAnnotation(title="提现统计")
 */
class Withdrawsts extends AdminController
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
     * @NodeAnotation(title="提现统计列表")
     */
    public function index(){
        if ($this->request->isAjax()){
            if (input('selectFields')) {
                return $this->selectList();
            }
            $a=$this->request->get();
            list($page, $limit, $where) = $this->buildTableParames();
            if ($where !== array()){
                $stime=$where[0][2];
                $etime=$where[1][2];
                $save[0]['money']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->sum('money');
                $save[0]['wechat']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',0)->count();
                $save[0]['alipay']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',1)->count();
                $save[0]['balance']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',2)->count();
                $save[0]['manual']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',3)->count();
                $save[0]['create_time']="搜索时间";
                $data = [
                    'code' => 0,
                    'msg' => '',
                    'data' => $save,
                ];
                return json($data);
            }
            $save = array();
            for ($i=0; $i<=6; $i++){
                $stime = mktime(0,0,0,date('m'),date('d')-$i,date('y'));
                $etime = mktime(23,59,59,date('m'),date('d')-$i,date('y'));
                $save[$i]['money']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->sum('money');
                $save[$i]['wechat']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',0)->count();
                $save[$i]['alipay']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',1)->count();
                $save[$i]['balance']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',2)->count();
                $save[$i]['manual']=$this->model->whereTime('create_time','between',[$stime,$etime])->where('status',3)->where('numstatus',3)->count();
                $save[$i]['create_time']=date("Y-m-d",$stime) ;
            }
            $data = [
                'code' => 0,
                'msg' => '',
                'data' => $save,
            ];
            return json($data);
        }

        return $this->fetch();
    }
}