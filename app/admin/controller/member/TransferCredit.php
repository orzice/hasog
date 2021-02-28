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
// | DateTime：2020-12-31 18:16:29
// +----------------------------------------------------------------------

namespace app\admin\controller\member;


use app\common\model\CreditType;
use app\common\model\TransferCredit as TransferCreditMode;
use think\App;
use think\facade\Config;
use app\common\model\Member;
use app\common\controller\AdminController;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

/**
 * Class User
 * @package app\admin\controller\member
 * @ControllerAnnotation(title="积分管理")
 */
class TransferCredit extends AdminController
{

    use \app\admin\traits\Curd;


    protected $allowModifyFileds = CreditType::IS_WAY;

    protected $sort = [
        'id'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new CreditType();
    }


    /**
     * @NodeAnotation(title="列表")
     */
    public function index()
    {
        if ($this->request->isAjax()) {
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
     * @NodeAnotation(title="积分配置列表")
     */
    public function credit_set()
    {
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [];
            $this->validate($post, $rule);
            try {
                $save = $this->model->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        return $this->fetch();
    }

    /**
     * @NodeAnotation(title="属性修改")
     */
    public function modify()
    {
        $post = $this->request->post();
        $rule = [
            'id|ID'    => 'require',
            'field|字段' => 'require',
            'value|值'  => 'require',
        ];
        $this->validate($post, $rule);

        if (!in_array($post['field'], $this->allowModifyFileds)) {
            $this->error('该字段不允许修改：' . $post['field']);
        }
        $row = $this->model->find($post['id']);
        empty($row) && $this->error('数据不存在');
        event('MemberModify',$post);
        try {
            $row->save([
                $post['field'] => $post['value'],
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        event('MemberModifyEnd',$post);
        $this->success('保存成功');
    }

    /**
     * @NodeAnotation(title="转账数据列表")
     */
    public function list()
    {
        if ($this->request->isAjax()) {
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $count = TransferCreditMode::where($where)->where('type', 1)
                ->count();
            $list = TransferCreditMode::where($where)->where('type', 1)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();
            foreach ($list as $item){
                $item->credit_type = CreditType::find($item->credit_type);
                $item->credit_type = isset($item->credit_type) ? $item->credit_type->title : '暂无';
                if($item->type == 1){
                    $item->type = '积分转余额';
                    $item->umobile = Member::where('id', $item->uid)->find();
                    $item->umobile = isset($item->umobile)? $item->umobile->mobile : '暂无';
                }else{
                    $item->type = '积分转账';
                    $item->umobile = '暂无';
                    $item->target_mobile = '暂无';
                }
//                $item->umobile = Member::where('id', $item->credit_type)->find();
//                $item->umobile = isset($item->umobile)? $item->umobile->mobile : '暂无';
            }
            $data = [
                'code'  => 0,
                'msg'   => '',
                'count' => $count,
                'data'  => $list,
            ];
            return json($data);
        }
        $credits = CreditType::field('id,title')->select();
        $this->assign('credits', $credits);
        return $this->fetch();
    }

}
