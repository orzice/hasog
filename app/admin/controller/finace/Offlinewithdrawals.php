<?php



namespace app\admin\controller\finace;

use app\common\model\FinaceWithdrawalrecord;

use app\common\model\FinaceOfflinewithdrawals as FinaceOfflinewithdrawalss;

use app\common\model\FinaceWithdrawset;

use app\common\model\FinaceBalancesub;

use app\common\controller\AdminController;

use app\common\model\Member;

use app\common\model\Order;

use app\common\model\OrderPay;

use think\App;

use EasyAdmin\annotation\ControllerAnnotation;

use EasyAdmin\annotation\NodeAnotation;

use think\facade\Db;

/**

 * Class Test

 * @package app\admin\controller\page

 * @ControllerAnnotation(title="线下提现记录")

 */

class Offlinewithdrawals extends AdminController

{

    use \app\admin\traits\Curd;



    protected $sort = [

        'id'   => 'desc',

    ];



    public function __construct(App $app)

    {

        parent::__construct($app);

        $this->model = new FinaceOfflinewithdrawalss();

    }

    /**

     * @NodeAnotation(title="线下提现记录列表")

     */

    public function index()

    {

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

     * @NodeAnotation(title="线下提现记录修改")

     */

    public function edit($id)

    {

        $row = $this->model->find($id);

        $row->isEmpty() && $this->error('数据不存在');

        if ($this->request->isAjax()) {

            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();

            $rule = [

                'id' => 'require|number',

                'uid' => 'require|number',

                'states' => 'require|number',

                'money' => 'require|float',

                'procedure'=>'require|float',

                'state|收款状态' => 'require|number|in:0,1,2,3',

                'cord_id'=>'require|number'

            ];

            $this->validate($post, $rule);

            $off = FinaceOfflinewithdrawalss::find($post['id']);

            if ($off['state'] !==0){

                $this->error('非未审核状态不可更改');

            }

            if ($post['state']==1 && !$post['states']==1){

                $set = FinaceWithdrawset::select()->toArray();

                if (empty($set)){

                    $this->error('账户提现已关闭');

                }

                if ($set[0]['recharge'] !== 1){

                    $this->error('账户提现已关闭');

                }

            }

            $momber = Member::find($post['uid']);

            if (empty($momber)){$this->error('用户不存在');};

            $time = time();

            try {

                $save = FinaceOfflinewithdrawalss::update($post);

                if ($post['state']==1 && $post['states']!==1){

                    $save = FinaceWithdrawalrecord::update(['id'=>$post['cord_id'],'status'=>3]);

                }elseif ($post['state']==3 && !$post['states']!==3){

                    $credit2 = $momber['credit2']+$post['money'];

                    $save = FinaceWithdrawalrecord::update(['id'=>$post['cord_id'],'status'=>4]);

                    $save = Member::update(['id'=>$post['uid'],'credit2'=>$credit2]);

                    $save = FinaceBalancesub::insert(['uid'=>$id,'balance'=>$credit2,'state'=>3,'money'=>$post['money'],'create_time'=>$time]);

                }elseif ($post['state']==2 && $post['states']!==2){

                    $save = FinaceWithdrawalrecord::update(['id'=>$post['cord_id'],'status'=>5]);

                }

            } catch (\Exception $e) {

                $this->error('保存失败:'.$e->getMessage());

            }

            $save ? $this->success('保存成功') : $this->error('保存失败');

        }

        $row['moneys'] = $row['money']-$row['procedure'];

        $this->assign('row', $row);

        return $this->fetch();

    }

}