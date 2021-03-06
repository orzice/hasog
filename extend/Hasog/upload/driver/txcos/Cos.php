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
// | DateTime：2021-01-26 16:04:12
// +----------------------------------------------------------------------

namespace Hasog\upload\driver\txcos;

use Hasog\upload\interfaces\OssDriver;
use Qcloud\Cos\Client;
use think\Exception;

class Cos implements OssDriver
{

    protected static $instance;

    protected $secretId;

    protected $secretKey;

    protected $region;

    protected $bucket;

    protected $schema = 'https';

    protected $cosClient;

    protected function __construct($config)
    {
        $this->secretId = $config['txcos_secret_id'];
        $this->secretKey = $config['txcos_secret_key'];
        $this->region = $config['txcos_region'];
        $this->bucket = $config['tecos_bucket'];
        $this->cosClient = new Client(
            [
                'region'      => $this->region,
                'schema'      => $this->schema,
                'credentials' => [
                    'secretId'  => $this->secretId,
                    'secretKey' => $this->secretKey],
            ]);
        return $this;
    }

    public static function instance($config)
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($config);
        }
        return self::$instance;
    }

    public function save($objectName, $filePath)
    {
        try {
            $key = $objectName;
            $file = fopen($filePath, "rb");
            if ($file) {
                $result = $this->cosClient->putObject([
                        'Bucket' => $this->bucket,
                        'Key'    => $key,
                        'Body'   => $file]
                );

                // todo 腾讯云坑逼，返回保护变量，也不提供get方法
                $result = (array)$result;
                $result = $result[' * data'];
            } else {
                throw new Exception('文件信息有误');
            }
        } catch (\Exception $e) {
            return [
                'save' => false,
                'msg'  => $e->getMessage(),
            ];
        }
        if (!isset($result['Location'])) {
            return [
                'save' => false,
                'msg'  => '保存失败',
            ];
        }
        return [
            'save' => true,
            'msg'  => '上传成功',
            'url'  => $this->schema . '://' . $result['Location'],
        ];
    }
}