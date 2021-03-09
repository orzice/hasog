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

namespace app\home\controller;

use app\common\controller\HomeController;
use Hasog\Response;
use think\facade\Db;
use think\facade\Config;
use app\home\service\SqlService;
use app\home\service\SqlMapService;

// 在线安装
class Install extends HomeController
{
    protected $fg = DIRECTORY_SEPARATOR;

    public function index()
    {
      $path  = public_path();
      $root  = root_path();
      $dic_r  = $root.'config'.$this->fg;
      $dic  = $path.'config'.$this->fg;
      $lock = $dic .'install'.$this->fg;
      $currentHost = ($_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/';
      $errorInfo = null;
      $hasog = config_plus("hasog");


      if (is_file($lock.'install.lock')) {
        $errorInfo = '已安装系统，如需重新安装请删除文件：public/config/install/install.lock';
      } elseif (!isReadWrite($dic)) {
          $errorInfo = $dic . '：读写权限不足';
      } elseif (!isReadWrite($root . 'runtime' . $this->fg)) {
          $errorInfo = $root . 'runtime' . $this->fg . '：读写权限不足';
      } elseif (!isReadWrite($root . 'public' . $this->fg)) {
          $errorInfo = $root . 'public' . $this->fg . '：读写权限不足';
      } elseif (!checkPhpVersion('7.1.0')) {
          $errorInfo = 'PHP版本不能小于7.1.0';
      } elseif (!extension_loaded("PDO")) {
          $errorInfo = '当前未开启PDO，无法进行安装';
      } elseif (!extension_loaded("redis")) {
          $errorInfo = '当前未开启Redis，无法进行安装';
      }

      if ($this->request->isAjax()) {
        $post = $this->request->post();
        if ($errorInfo !== null) {
          return json([
              'code' => 0,
              'msg'  => $errorInfo,
          ]);
        }

        $cover = $post['cover'] == 1 ? true : false;
        $database = $post['database'];
        $hostname = $post['hostname'];
        $hostport = $post['hostport'];
        $dbUsername = $post['db_username'];
        $dbPassword = $post['db_password'];
        $prefix = $post['prefix'];
        $username = $post['username'];
        $password = $post['password'];
        $key = $post['key'];
        $key_user = $post['key_user'];
        $key_admin = $post['key_admin'];


        // 参数验证
        $validateError = null;
        if (strlen($password) < 5) {
            $validateError = '管理员密码不能小于5位数';
        } elseif (strlen($username) < 4) {
            $validateError = '管理员账号不能小于4位数';
        } elseif (!preg_match("/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i",$key)) {
            $validateError = '后台加密必须为英文和数字组合！';
        }elseif (!preg_match("/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i",$key_user)) {
            $validateError = '用户加密必须为英文和数字组合！';
        }elseif (!preg_match("/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i",$key_admin)) {
            $validateError = '后台地址必须为英文和数字组合！';
        }
        if (!empty($validateError)) {
           return json([
                'code' => 0,
                'msg'  => $validateError,
            ]);
        }
        
        // HaSog配置初始化
        $hasog['pwSDK'] = $key;
        $hasog['userPW'] = $key_user;
        @file_put_contents($dic_r.'hasog.php', $this->getHaSogConfig($hasog),$key_admin);

        // DB类初始化
        $config = [
            'type'     => 'mysql',
            'hostname' => $hostname,
            'username' => $dbUsername,
            'password' => $dbPassword,
            'hostport' => $hostport,
            'charset'  => 'utf8',
            'prefix'   => $prefix,
            'debug'    => true,
        ];
        $cons = [
            'default'     => 'mysql',
            'connections' => [
                'mysql'   => $config,
                'install' => array_merge($config, ['database' => $database]),
            ],
        ];

        Config::set($cons,'database');
        //Db::setConfig($cons);

        // 检测数据库连接
        if (!$this->checkConnect()) {
           return json([
                'code' => 0,
                'msg'  => '数据库连接失败',
            ]);
        }

        // 检测数据库是否存在
        if (!$cover && $this->checkDatabase($database)) {
           return json([
                'code' => 0,
                'msg'  => '数据库已存在，请选择覆盖安装或者修改数据库名',
            ]);
        }
        // 创建数据库
        try {
            Db::execute("CREATE DATABASE IF NOT EXISTS `{$database}` DEFAULT CHARACTER SET utf8mb4");
        } catch (\Throwable $e) {
           return json([
                'code' => 0,
                'msg'  => '创建数据库失败',
            ]);
        }

        //置入SQL安装逻辑
        $install = false;

        $Sql = new SqlService();
        $or = $Sql->install();
        if (!$or) {
           return json([
                'code' => 0,
                'msg'  => '创建数据库表失败',
            ]);
        }

        $Sql = new SqlMapService();
        $or = $Sql->install();
        if (!$or) {
           return json([
                'code' => 0,
                'msg'  => '创建地图数据库表失败',
            ]);
        }

    //创建管理员账号
    Db::startTrans();
    $erro = '';
    try {
        Db::connect('install')
            ->name('system_admin')
            ->where('id', 1)
            ->delete();
        Db::connect('install')
            ->name('system_admin')
            ->insert([
                'id'          => 1,
                'username'    => $username,
                'head_img'    => '/static/admin/images/head.jpg',
                'password'    => password($password),
                'create_time' => time(),
            ]);
        $install = true;

        // 处理安装文件
        !is_dir($lock) && @mkdir($lock);
        @file_put_contents($lock.'install.lock', date('Y-m-d H:i:s'));
        @file_put_contents($dic_r.'app.php', $this->getAppConfig(),$key_admin);
        @file_put_contents($dic_r.'database.php', $this->getDatabaseConfig($cons['connections']['install']),$key_admin);
        Db::commit();
    } catch (\Throwable $e) {
        Db::rollback();
        $install = false;
        $erro = $e->getMessage();
    }



        if (!$install) {
            $data = [
                'code' => 0,
                'msg'  => '系统安装失败：' . $erro,
            ];
            return json($data);
        }
        $data = [
            'code' => 1,
            'msg'  => '系统安装成功，正在跳转登录页面',
            'url'  => '/admin',
        ];
        return json($data);
      }

        $this->assign('hasog',$hasog);
        $this->assign('errorInfo',$errorInfo);
        $this->assign('currentHost',$currentHost);
        return $this->fetch();
    }

function getAppConfig($key_admin)
{
    $config = <<<EOT
<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'         => env('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 是否启用事件
    'with_event'       => true,
    // 开启应用快速访问
    'app_express'      => true,
    // 默认应用
    'default_app'      => 'home',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [
        '{$key_admin}' => 'admin'
    ],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => ['common'],

    // 异常页面的模板文件 [查看错误]
    // 'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',
    // 异常页面的模板文件
    'exception_tmpl'   => app()->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'think_exception.tpl',

    // 跳转页面的成功模板文件
    'dispatch_success_tmpl'   => app()->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
    // 跳转页面的失败模板文件
    'dispatch_error_tmpl'   => app()->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
    
    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => false,
];


EOT;
    return $config;
}

function getDatabaseConfig($data)
{
    $config = <<<EOT
<?php
use think\\facade\Env;

return [
    // 默认使用的数据库连接配置
    'default'         => env('database.driver', 'mysql'),

    // 自定义时间查询规则
    'time_query_rule' => [],

    // 自动写入时间戳字段
    // true为自动识别类型 false关闭
    // 字符串则明确指定时间字段类型 支持 int timestamp datetime date
    'auto_timestamp'  => true,

    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',

    // 数据库连接配置信息
    'connections'     => [
        'mysql' => [
            // 数据库类型
            'type'              => env('database.type', 'mysql'),
            // 服务器地址
            'hostname'          => env('database.hostname', '{$data['hostname']}'),
            // 数据库名
            'database'          => env('database.database', '{$data['database']}'),
            // 用户名
            'username'          => env('database.username', '{$data['username']}'),
            // 密码
            'password'          => env('database.password', '{$data['password']}'),
            // 端口
            'hostport'          => env('database.hostport', '{$data['hostport']}'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => env('database.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => env('database.prefix', '{$data['prefix']}'),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => true,
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'     => env('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => false,
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],

        // 更多的数据库配置信息
    ],
];

EOT;
    return $config;
}

function getHaSogConfig($data,$key_admin)
{
    $config = <<<EOT
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
// | DateTime：2021-03-06 17:52:38
// +----------------------------------------------------------------------

return [
    // 版本
    'version'         => '{$data['version']}',
    // Session配置
    'SessionName'         => '{$data['SessionName']}',
    // 后台管理员密码加密
    'pwSDK'         => '{$data['pwSDK']}',
    // 前台用户密码加密
    'userPW'         => '{$data['userPW']}',
    // 云平台配置
    'CloudUrl'         => '{$data['CloudUrl']}',
    //  后台访问目录
    'Admin'         => '{$key_admin}',
];

EOT;
    return $config;
}

public function checkDatabase($database)
{
    $check = Db::query("SELECT * FROM information_schema.schemata WHERE schema_name='{$database}'");
    if (empty($check)) {
        return false;
    } else {
        return true;
    }
}
  public function checkConnect()
  {
      try {
          Db::query("select version()");
      } catch (\Throwable $e) {
          return false;
      }
      return true;
  }
}