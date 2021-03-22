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
// | DateTime：2020-12-31 18:16:40
// +----------------------------------------------------------------------

namespace app\admin\controller\goods;


use think\App;
use think\facade\Config;
use app\common\model\Dispatch as Dispatchs;
use app\common\model\DispatchData;
use app\common\controller\AdminController;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

/**
 * Class Dispatch
 * @package app\admin\controller\goods
 * @ControllerAnnotation(title="配送管理")
 */
class Dispatch extends AdminController
{

    use \app\admin\traits\Curd;

    protected $sort = [
        'id'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Dispatchs();
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
     * @NodeAnotation(title="添加")
     */
    public function add()
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

            if($save){
                $this->model2 = new DispatchData();
                $post = array(
                    'did' => $this->model->id,
                    'display_order' => 1000,
                    'areas' => '[{"id":"91","name":"\u5168\u56fd","lv":0}]',
                    'areas_txt' => '全国',
                    'state' => 0,
                    );
                $save = $this->model2->save($post);
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="删除")
     */
    public function delete($id)
    {

        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $row = $this->model->whereIn('id', $id)->select();
        $row->isEmpty() && $this->error('数据不存在');

        $this->model2 = new DispatchData();
        $row2 = $this->model2->whereIn('did', $id)->select();

        try {
            $save = $row->delete();
        } catch (\Exception $e) {
            $this->error('删除失败');
        }
        if($save){
            $save = $row2->delete();
        }
        $save ? $this->success('删除成功') : $this->error('删除失败');
    }
    /**
     * @NodeAnotation(title="属性修改")
     */
    public function modify()
    {

        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $post = $this->request->post();
        $rule = [
            'id|ID'    => 'require',
            'field|字段' => 'require',
            'value|值'  => 'require',
        ];
        $this->validate($post, $rule);
        $row = $this->model->find($post['id']);
        if (!$row) {
            $this->error('数据不存在');
        }
        if (!in_array($post['field'], $this->allowModifyFileds)) {
            $this->error('该字段不允许修改：' . $post['field']);
        }
        if($post['field'] == 'state' && $post['value'] == '1'){
           $data = DispatchData::where('did',$row['id'])->count();
           if($data < 1){
            $this->error('没有发货逻辑！不能打开！');
           }
        }

        try {
            $row->save([
                $post['field'] => $post['value'],
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('保存成功');
    }

    /**
     * @NodeAnotation(title="配送逻辑")
     */
    public function data($id=0)
    {
        if($id==0){
            $this->error('缺少参数');
        }

        $row = $this->model->find($id);
        if(!$row){$this->error('数据不存在');}

        $this->model = new DispatchData();
        $data = $this->model->where('did',$id)->find();

        if ($this->request->isAjax()) {
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $where["did"] = $id;

            $count = $this->model
                ->where($where)
                ->count();
            $list = $this->model
                ->where($where)
                ->page($page, $limit)
                ->order('display_order', 'desc')
                ->select();
            $data = [
                'code'  => 0,
                'msg'   => '',
                'count' => $count,
                'data'  => $list,
            ];
            return json($data);
        }
        $this->assign('data', $data);
        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="编辑配送逻辑")
     */
    public function dataedit($id)
    {
        $this->model = new DispatchData();
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');

        if ($this->request->isAjax()) {
            
            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $post = $this->request->post();
            $rule = [
                'display_order|优先权' => 'require|number|between:0,1000',
                'state|类型' => 'require|number|in:0,1',

                'province|省地区' => 'require|chs|length:0,20',
                'province_id|省地区' => 'require|number',
                'city|市地区' => 'chs|length:0,20',
                'city_id|市地区' => 'number',
                'area|县区地区' => 'chs|length:0,20',
                'area_id|县区地区' => 'number',
                'street|街道地区' => 'chs|length:0,20',
                'street_id|街道地区' => 'number',

                'first_piece|首件(个/斤)' => 'require|number',
                'first_piece_price|运费(元)' => 'require|float',
                'another_piece|续件(个/斤)' => 'require|number',
                'another_piece_price|续费(元)' => 'require|float',
            ];
            $this->validate($post, $rule);

            // 放飞自我的字符串拼接读取 一举三得
            $lx = array('province','city','area','street');
            $sql = array();
            $sql_txt = '';

            for ($i=0; $i < count($lx); $i++) { 
                if(isset($post[$lx[$i]]) && $post[$lx[$i]] !== ''){
                    $sql[] = array(
                    'id' => $post[$lx[$i].'_id'],
                    'name' => $post[$lx[$i]],
                    'lv' => $i,
                    );
                    $sql_txt .= $post[$lx[$i]];
                }
            }
            if($post['province'] == '全国'){
                $sw = $this->model->where('did',$row['did'])->where('id','<>',$row['id'])->where('areas_txt','全国')->find();
                if($sw){$this->error('全国 的配送逻辑只能设置一个！不能重复添加！');}

                $sql = array();
                $sql[] = array(
                    'id' => 0,
                    'name' => '全国',
                    'lv' => 0,
                    );
                $sql_txt = '全国';
                $post['display_order'] = '1000';
            }

            $post['areas'] = json_encode($sql);
            $post['areas_txt'] = $sql_txt;
            if($post['areas'] == ''){
                $this->error('保存失败,地区为空！');
            }
            try {
                $save = $row->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        //解析地址
        $areas = json_decode($row['areas'],true);
        $row['province_id'] = isset($areas[0]['id'])?$areas[0]['id']:'';
        $row['city_id'] = isset($areas[1]['id'])?$areas[1]['id']:'';
        $row['area_id'] = isset($areas[2]['id'])?$areas[2]['id']:'';
        $row['street_id'] = isset($areas[3]['id'])?$areas[3]['id']:'';

        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="添加配送逻辑")
     */
    public function dataadd($id=0)
    {
        if($id==0){
            $this->error('缺少参数');
        }
        $row = $this->model->find($id);
        if(!$row){$this->error('数据不存在');}

        if ($this->request->isAjax()) {

            if(env('hasog.is_demo', false)){
                $this->error('演示环境下不允许修改');
            }
            $this->model = new DispatchData();
            $post = $this->request->post();
            $rule = [
                'display_order|优先权' => 'require|number|between:0,1000',
                'state|类型' => 'require|number|in:0,1',

                'province|省地区' => 'require|chs|length:0,20',
                'province_id|省地区' => 'require|number',
                'city|市地区' => 'chs|length:0,20',
                'city_id|市地区' => 'number',
                'area|县区地区' => 'chs|length:0,20',
                'area_id|县区地区' => 'number',
                'street|街道地区' => 'chs|length:0,20',
                'street_id|街道地区' => 'number',

                'first_piece|首件(个/斤)' => 'require|number',
                'first_piece_price|运费(元)' => 'require|float',
                'another_piece|续件(个/斤)' => 'require|number',
                'another_piece_price|续费(元)' => 'require|float',
            ];
            $this->validate($post, $rule);
            $post['did'] = $id;

            // 放飞自我的字符串拼接读取 一举三得
            $lx = array('province','city','area','street');
            $sql = array();
            $sql_txt = '';

            for ($i=0; $i < count($lx); $i++) { 
                if(isset($post[$lx[$i]]) && $post[$lx[$i]] !== ''){
                    $sql[] = array(
                    'id' => $post[$lx[$i].'_id'],
                    'name' => $post[$lx[$i]],
                    'lv' => $i,
                    );
                    $sql_txt .= $post[$lx[$i]];
                }
            }
            if($post['province'] == '全国'){
                $sw = $this->model->where('did',$id)->where('areas_txt','全国')->find();
                if($sw){$this->error('全国 的配送逻辑只能设置一个！不能重复添加！');}

                $sql = array();
                $sql[] = array(
                    'id' => 0,
                    'name' => '全国',
                    'lv' => 0,
                    );
                $sql_txt = '全国';
                $post['display_order'] = '1000';
            }

            $post['areas'] = json_encode($sql);
            $post['areas_txt'] = $sql_txt;
            if($post['areas'] == ''){
                $this->error('保存失败,地区为空！');
            }
            $sw = $this->model->where('did',$id)->where('areas_txt',$sql_txt)->find();
            if($sw){$this->error($sql_txt.' 的配送逻辑只能设置一个！不能重复添加！');}
            // print_r($post);
            // exit;
            try {
                $save = $this->model->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败:'.$e->getMessage());
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="删除配送逻辑")
     */
    public function datadelete($id)
    {

        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $this->model = new DispatchData();
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');

        if($row['areas_txt'] == '全国'){
           $this->error('全国 不能删除！这是默认配送！');
        }

        try {
            $save = $row->delete();
        } catch (\Exception $e) {
            $this->error('删除失败');
        }
        $save ? $this->success('删除成功') : $this->error('删除失败');
    }
    /**
     * @NodeAnotation(title="属性修改配送逻辑")
     */
    public function datamodify()
    {

        if(env('hasog.is_demo', false)){
            $this->error('演示环境下不允许修改');
        }
        $this->model = new DispatchData();
        $post = $this->request->post();
        $rule = [
            'id|ID'    => 'require',
            'field|字段' => 'require',
            'value|值'  => 'require',
        ];
        $this->validate($post, $rule);
        $row = $this->model->find($post['id']);
        if (!$row) {
            $this->error('数据不存在');
        }
        if (!in_array($post['field'], $this->allowModifyFileds)) {
            $this->error('该字段不允许修改：' . $post['field']);
        }
        if($row['areas_txt'] == '全国' && $post['field'] == 'display_order'){
            $this->error('不能修改全国的优先权！');
        }

        try {
            $row->save([
                $post['field'] => $post['value'],
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('保存成功');
    }
}
