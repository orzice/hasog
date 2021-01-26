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
// | DateTime：2021-01-26 16:03:15
// +----------------------------------------------------------------------
namespace Hasog\upload;

use Hasog\upload\driver\Alioss;
use Hasog\upload\driver\Local;
use Hasog\upload\driver\Qnoss;
use Hasog\upload\driver\Txcos;
use think\File;

/**
 * 上传组件
 * Class Uploadfile
 * @package Hasog\upload
 */
class Uploadfile
{

    /**
     * 当前实例对象
     * @var object
     */
    protected static $instance;

    /**
     * 上传方式
     * @var string
     */
    protected $uploadType = 'local';

    /**
     * 上传配置文件
     * @var array
     */
    protected $uploadConfig;

    /**
     * 需要上传的文件对象
     * @var File
     */
    protected $file;

    /**
     * 保存上传文件的数据表
     * @var string
     */
    protected $tableName = 'member_uploadfile';
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
     * 获取对象实例
     * @return Uploadfile|object
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 设置上传对象
     * @param $value
     * @return $this
     */
    public function setFile($value)
    {
        $this->file = $value;
        return $this;
    }

    /**
     * 设置上传文件
     * @param $value
     * @return $this
     */
    public function setUploadConfig($value)
    {
        $this->uploadConfig = $value;
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
     * 设置保存数据表
     * @param $value
     * @return $this
     */
    public function setTableName($value)
    {
        $this->tableName = $value;
        return $this;
    }
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
     * 保存文件
     * @return array|void
     */
    public function save()
    {
        $obj = null;
        if ($this->uploadType == 'local') {
            $obj = new Local();
        } elseif ($this->uploadType == 'alioss') {
            $obj = new Alioss();
        } elseif ($this->uploadType == 'qnoss') {
            $obj = new Qnoss();
        } elseif ($this->uploadType == 'txcos') {
            $obj = new Txcos();
        }
        $save = $obj->setUploadConfig($this->uploadConfig)
            ->setUploadType($this->uploadType)
            ->setTableName($this->tableName)
            ->setFile($this->file)
            ->setUid($this->uid)
            ->setState($this->state)
            ->save();
        return $save;
    }
}