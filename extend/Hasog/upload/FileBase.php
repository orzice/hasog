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
// | DateTime：2021-01-26 16:03:08
// +----------------------------------------------------------------------

namespace Hasog\upload;


use think\facade\Filesystem;
use think\File;

/**
 * 基类
 * Class Base
 * @package Hasog\upload
 */
class FileBase
{

    /**
     * 上传配置
     * @var array
     */
    protected $uploadConfig;

    /**
     * 上传文件对象
     * @var object
     */
    protected $file;

    /**
     * 上传完成的文件路径
     * @var string
     */
    protected $completeFilePath;

    /**
     * 上传完成的文件的URL
     * @var string
     */
    protected $completeFileUrl;

    /**
     * 保存上传文件的数据表
     * @var string
     */
    protected $tableName;

    /**
     * 上传类型
     * @var string
     */
    protected $uploadType = 'local';

    /**
     * 保存上传文件的用户
     * @var string
     */
    protected $uid = 0;
    /**
     * 保存上传文件的数据表
     * @var string
     */
    protected $state = 0;

    /**
     * 设置上传用户
     * @param $value
     * @return $this
     */
    public function setUid($value)
    {
        $this->uid = $value;
        return $this;
    }
    /**
     * 设置状态
     * @param $value
     * @return $this
     */
    public function setState($value)
    {
        $this->state = $value;
        return $this;
    }
    /**
     * 设置上传方式
     * @param $value
     * @return $this
     */
    public function setUploadType($value)
    {
        $this->uploadType = $value;
        return $this;
    }

    /**
     * 设置上传配置
     * @param $value
     * @return $this
     */
    public function setUploadConfig($value)
    {
        $this->uploadConfig = $value;
        return $this;
    }

    /**
     * 设置上传配置
     * @param $value
     * @return $this
     */
    public function setFile($value)
    {
        $this->file = $value;
        return $this;
    }

    /**
     * 设置保存文件数据表
     * @param $value
     * @return $this
     */
    public function setTableName($value)
    {
        $this->tableName = $value;
        return $this;
    }

    /**
     * 保存文件
     */
    public function save()
    {
        // $this->completeFilePath = Filesystem::disk('public')->putFile('upload', $this->file,"md5");
        // $this->completeFileUrl = request()->domain() . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $this->completeFilePath);
        // $this->completeFile =  str_replace(DIRECTORY_SEPARATOR, '/', $this->completeFilePath);
        $this->completeFilePath = Filesystem::disk('public')->putFile('uploads', $this->file,"md5");
        $this->completeFileUrl = request()->domain() . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $this->completeFilePath);
        $this->completeFile =  str_replace(DIRECTORY_SEPARATOR, '/', $this->completeFilePath);
    }

    /**
     * 删除保存在本地的文件
     * @return bool|string
     */
    public function rmLocalSave()
    {
        try {
            $rm = unlink($this->completeFilePath);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $rm;
    }

}