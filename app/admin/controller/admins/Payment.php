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
// | DateTime：2020-12-31 18:12:04
// +----------------------------------------------------------------------

namespace app\admin\controller\admins;

use app\common\controller\AdminController;
use app\common\model\AdminsPayment as Payments;
use think\App;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

/**
 * Class Test
 * @package app\admin\controller\page
 * @ControllerAnnotation(title="线下付款配置")
 */
class Payment extends AdminController
{
    use \app\admin\traits\Curd;

    protected $sort = [
        'create_time' => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Payments();
    }
    /**
     * @NodeAnotation(title="线下付款配置列表")
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
     * @NodeAnotation(title="线下付款配置添加")
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'accnumber|开户卡号' => 'require|number',
                'thumb|二维码' => 'require|url',
                'accname|开户名' => 'require',
                'name|名称' => 'require',
                'bankdeposit|开户行' => 'require',
                'bankdeposits|开户支行' => 'require',
                'state|状态' => 'require|number|in:0,1',
            ];
            $this->validate($post, $rule);
            $post['qrcode'] = $post['thumb'];
            Uploadfile($post['qrcode']);
            unset($post['thumb']);
            unset($post['file']);
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
     * @NodeAnotation(title="线下付款配置修改")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()){

            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'accnumber|权重' => 'require|number',
                'thumb|二维码' => 'require|url',
                'accname|开户名' => 'require',
                'bankdeposit|开户行' => 'require',
                'bankdeposits|开户支行' => 'require',
                'state|状态' => 'require|number|in:0,1',
            ];
            $this->validate($post, $rule);
            $post['qrcode'] = $post['thumb'];
            unset($post['thumb']);
            unset($post['file']);
            try {
                $save = $this->model->where('id',$post['id'])->update($post);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row',$row);
        return $this->fetch();
    }
}