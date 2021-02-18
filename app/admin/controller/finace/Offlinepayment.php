<?php


namespace app\admin\controller\finace;
use app\common\model\FinaceBalancesub;
use app\common\model\FinaceOfflinepayment as FinaceOfflinepayments;
use app\common\model\FinaceBalanceset;
use app\common\controller\AdminController;
use app\common\model\FinaceUprecord;
use app\common\model\Member;
use think\App;
use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;
/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="线下收款记录")
 */
class Offlinepayment extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'id'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new FinaceOfflinepayments();
    }
    /**
     * @NodeAnotation(title="列表")
     */
    public function index(){
        if ($this->request->isAjax()){
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $count = $this->model
                ->where($where)
                ->count();
            $list = $this->model
                ->where($where)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();
            $data = [
                'code' => 0,
                'msg' => '',
                'count' => $count,
                'data' => $list,
            ];
            return json($data);
        }
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="查看")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()){
            $post = $this->request->post();
            $rule = [
                'id'=>'require|number',
                'uid'=>'require|number',
                'states'=>'require|number',
                'money'=>'require|float',
                'a_state'=>'require|number',
                'state|收款状态' => 'require|number|in:0,1,2',
            ];
            $this->validate($post, $rule);
            $moneys = 0;

            if ($post['state']==1 && !$post['states']==1 &&$post['a_state']==0){
               $set =  FinaceBalanceset::select()->toArray();
               if (empty($set)){
                   $this->error('用户充值已关闭');
               }
                if ($set[0]['recharge'] !== 1){
                    $this->error('用户充值已关闭');
                }
                $s = json_decode($set[0]['sole'],true);
                $money = array();
                foreach ($s as $k=>$v){
                    if ($post['money']>=$v['enough']){
                        $money[$k]['money'] = $v['give'];
                    }
                }
                if (!empty($money)){
                    $money = max($money);
                    if ($set[0]['proportion_status'] == 0){
                        $moneys = $money['money'];
                    }else{
                        $moneys = $post['money']*$money['money']/100;
                    }
                }
            }
            $momber = Member::find($post['uid']);
            if (empty($momber)){$this->error('用户不存在');};
            $moneys = $post['money']+$moneys;
            $time = time();
            try {
                $save = FinaceOfflinepayments::update($post);
                if ($post['state'] == 1 && !$post['states']==1&&$post['a_state']==0){
                    $balance = $momber['credit2']+$moneys;
                    $save = Member::where('id',$post['uid'])->update(['credit2'=>$balance]);
                    $save = FinaceBalancesub::insert(['uid'=>$post['uid'],'balance'=>$balance,'state'=>2,'money'=>$moneys,'create_time'=>$time]);
                    $save = FinaceUprecord::insert(['uid'=>$post['uid'],'way'=>1,'money'=>$moneys,'state'=>1,'create_time'=>$time]);
                }
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
}