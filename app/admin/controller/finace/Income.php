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
// | DateTime：2020-12-31 18:12:17
// +----------------------------------------------------------------------
namespace appadmincontrollerfinace;
use appcommonmodelFinaceIncome as Incomes;
use appcommoncontrollerAdminController;
use thinkApp;
use EasyAdminannotationControllerAnnotation;
use EasyAdminannotationNodeAnotation;
/**
 * Class Test
 * @package appadmincontrollerpage
 * @ControllerAnnotation(title="收入明细")
 */
class Income extends AdminController
{
    use appadmintraitsCurd;
    protected $sort = [
            'id'   => 'desc',
        ];
    public function __construct(App $app)
        {
        parent::__construct($app);
        $this->model = new Incomes();
    }
    /**
     * @NodeAnotation(title="收入明细列表")
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
}