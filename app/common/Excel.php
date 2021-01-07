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
// | DateTime：2020-12-31 18:22:57
// +----------------------------------------------------------------------


namespace app\common;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use app\BaseController;
class Excel
{
    /**
     * 导出excel表
     * $data：要导出excel表的数据，接受一个二维数组
     * $name：excel表的表名
     * $head：excel表的表头，接受一个一维数组
     * $key：$data中对应表头的键的数组，接受一个一维数组
     * $format: 格式:excel2003 = xls, excel2007 = xlsx
     */
    public function export($name='表名', $data=[], $head=[], $keys=[], $format = 'xls')
    {
        $count = count($head);  //计算表头数量
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //数字转字母从65开始，循环设置表头：
        for ($i = 65; $i < $count + 65; $i++) {
            $sheet->setCellValue(strtoupper(chr($i)) . '1', $head[$i - 65]);
            $spreadsheet->getActiveSheet()->getColumnDimension(strtoupper(chr($i)))->setWidth(20); //固定列宽
        }
        /*--------------开始提取数据插入Excel表中------------------*/
        foreach ($data as $key => $item) {//循环设置单元格：
            //$key+2,因为第一行是表头，所以写到表格时从第二行开始写，数字转字母从65开始：
            for ($i = 65; $i < $count + 65; $i++) {
                $sheet->setCellValue(strtoupper(chr($i)) . ($key + 2), $item[$keys[$i - 65]]);
            }
        }
        if($format == 'xlsx'){
            //输出07Excel版本
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $class = "\PhpOffice\PhpSpreadsheet\Writer\Xlsx";
        }elseif ($format == 'xls'){
            //输出Excel03版本
            header('Content-Type:application/vnd.ms-excel');
            $class = "\PhpOffice\PhpSpreadsheet\Writer\Xls";
        }else{
            return false;
        }
        header('Content-Disposition: attachment;filename="' . $name . '.'.$format.'"');
        header('Cache-Control: max-age=0');
        $writer = new $class($spreadsheet);
        $writer->save('php://output');
        //删除清空：
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        return true;
    }


    /**
     * 上传execl
     * $path：execl文件要保存的目录
     * 上传成功返回上传成功路径和文件格式,失败返回false
     */
    public function upload($path)
    {
        $has_file = request()->has('image','file',true);
        if(!$has_file){
            //上传文件为空
            return false;
        }
        // 获取表单上传文件
        $file = request()->file('image');
        //单图上传
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate(['ext'=>'xls,xlsx'])->move($path);
        if($info){
            //获取文件格式
            $file_format = $info->getExtension();
            // 输出上传的文件路径
            $file_path = $path.'/'.$info->getSaveName();
            return ['file_format'=>$file_format,'file_path'=>$file_path];

        }else{
            return false;
        }
    }

    /**
     * 读取execl文件内容
     * $file_path：execl文件地址
     * $file_format execl文件格式
     * 读取内容成功返回读取内容,失败返回false
     * 上传成功返回上传成功路径和文件格式,失败返回false
     */
    public function import($file_path,$file_format = 'xls')
    {
        if($file_format == 'xlsx'){
            $xlsx = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $can_read = $xlsx->canRead($file_path);
            if($can_read){
                $content = $xlsx->load($file_path)->getActiveSheet()->toArray();
                return $content;
            }else{
                return false;
            }
        }elseif ($file_format == 'xls'){
            $xls = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $can_read = $xls->canRead($file_path);
            if($can_read){
                $content = $xls->load($file_path)->getActiveSheet()->toArray();
                return $content;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}