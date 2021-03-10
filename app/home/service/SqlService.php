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
// | DateTime：2020-12-31 18:18:40
// +----------------------------------------------------------------------

namespace app\home\service;


use think\facade\Db;
use think\facade\Config;

/**
 * 创建SQL数据表
 * Class SqlService
 * @package app\home\service
 */
class SqlService
{
    /**
     * 表前缀
     * @var string
     */
    protected $tablePrefix;

    /**
     * 检测数据表 并插入
     * @return bool
     */
    protected function detectTable($names,$sql='')
    {
        $name = $this->tablePrefix.$names;
        $sql = str_replace('`'.$names.'`',  '`'.$name.'`', $sql);
        $check = Db::connect('install')->query("show tables like '{$name}'");
        if (empty($check)) {
            if (!empty($sql)) {
                Db::connect('install')->execute($sql);
            }
        }
        return true;
    }
    /**
     * 检测数据表 并插入  insert
     * @return bool
     */
    protected function insertTable($names,$sql='')
    {
        $name = $this->tablePrefix.$names;
        $sql = str_replace('`'.$names.'`',  '`'.$name.'`', $sql);
       
        Db::connect('install')->query("truncate table `{$name}`");

        if (!empty($sql)) {
            Db::connect('install')->execute($sql);
        }
        
        return true;
    }

    /**
     * 安装
     * @param $data
     * @return bool|string
     */
    public function install()
    {
      $this->tablePrefix = Config::get('database.connections.mysql.prefix');
 
 try {
//=================================================
    $tableName = 'admins_feedback';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
      `state` int(1) DEFAULT NULL COMMENT '1已解决 2未解决',
      `imgs` varchar(255) DEFAULT NULL COMMENT '图片',
      `kf_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '客服回复',
      `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '内容',
      `create_time` int(11) DEFAULT NULL,
      `update_time` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户反馈表';
ETO;
    $this->detectTable($tableName,$Sql);

//=================================================

    $tableName = 'admins_feedbackset';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
      `uid` int(11) NOT NULL DEFAULT '0',
      `create_time` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='反馈权限表';
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'admins_payment';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) DEFAULT NULL COMMENT '名称',
      `qrcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
      `a_state` int(1) DEFAULT NULL,
      `bankdeposit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
      `bankdeposits` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
      `accname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
      `accnumber` varchar(20) DEFAULT NULL,
      `state` int(1) DEFAULT NULL COMMENT '状态 1开启 0关闭',
      `create_time` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='线下付款配置列表';
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'ali_pay';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `app_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `rsa_private_key` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '开发者私钥',
  `rsa_public_key` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '支付宝公钥',
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_union` tinyint(1) DEFAULT '0' COMMENT '是否唯一支付',
  `open_status` tinyint(1) DEFAULT '0' COMMENT '0关闭1打开(只能有一个打开)',
  `is_login` tinyint(1) DEFAULT '0' COMMENT '0 1可以登录',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'area';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
  `id` bigint(20) NOT NULL COMMENT '城市编号',
  `pid` int(11) DEFAULT NULL COMMENT '上级ID',
  `deep` int(11) DEFAULT NULL COMMENT '层级深度；0：省，1：市，2：区，3：镇',
  `name` varchar(16) DEFAULT NULL COMMENT '城市名称；省市区三级为统计局的名称精简过后的，镇级主要为腾讯地图行政区划的名称精简过后的',
  `pinyin_prefix` varchar(2) DEFAULT NULL COMMENT '拼音前缀',
  `pinyin` varchar(62) DEFAULT NULL COMMENT '完整拼音',
  `ext_id` int(11) DEFAULT NULL COMMENT '原始的编号',
  `ext_name` varchar(16) DEFAULT NULL COMMENT '原始的名称',
  KEY `pid` (`pid`),
  KEY `deep` (`deep`),
  KEY `pinyin_prefix` (`pinyin_prefix`),
  KEY `ext_name` (`ext_name`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'cart';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(11) unsigned DEFAULT '0' COMMENT '用户id',
  `goods_id` int(11) unsigned DEFAULT '0' COMMENT '商品id',
  `goods_options` text,
  `title` char(60) CHARACTER SET utf8 DEFAULT '' COMMENT '标题',
  `thumb` char(255) DEFAULT '' COMMENT '封面图片',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '添加时原价(original_price)',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '添加时销售价格',
  `stock` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `sku` text COMMENT '规格(单位spec)',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) unsigned DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`uid`),
  KEY `goods_id` (`goods_id`),
  KEY `title` (`title`),
  KEY `stock` (`stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='购物车';
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'category';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `description` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT '0',
  `enabled` tinyint(1) DEFAULT '1',
  `is_home` tinyint(1) DEFAULT '0',
  `adv_img` varchar(255) DEFAULT '',
  `adv_url` varchar(500) DEFAULT '',
  `level` tinyint(1) DEFAULT '0',
  `advimg_pc` varchar(255) NOT NULL DEFAULT '',
  `advurl_pc` varchar(500) NOT NULL DEFAULT '',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `filter_ids` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'credit_type';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '是否支持支付0否1是',
  `is_withdraw` tinyint(1) DEFAULT '0' COMMENT '是否支持提现0否1是',
  `is_transfer` tinyint(1) DEFAULT '0' COMMENT '是否支持转账0否1是',
  `is_convert` tinyint(1) DEFAULT '0' COMMENT '是否转换余额',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分设置';
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'dispatch';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `dispatch_name` varchar(50) DEFAULT NULL COMMENT '配送模板名称',
      `calculate_type` tinyint(1) DEFAULT NULL COMMENT '计费方式（0：记重；1：记件）',
      `state` tinyint(1) DEFAULT NULL COMMENT '是否启用（1：是；0：否）',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='配送模板表';
ETO;
    $this->detectTable($tableName,$Sql);
//=================================================

    $tableName = 'dispatch_data';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `did` int(11) DEFAULT NULL COMMENT '配送父ID',
      `display_order` int(11) DEFAULT NULL COMMENT '排序',
      `areas` text COMMENT '地区数据块',
      `areas_txt` varchar(255) DEFAULT NULL COMMENT '地区文本',
      `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0可配送 1禁止配送',
      `first_piece_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首件价格',
      `another_piece_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '续件价格',
      `first_piece` int(11) NOT NULL DEFAULT '0' COMMENT '首件个数',
      `another_piece` int(11) NOT NULL DEFAULT '0' COMMENT '续件个数',
      `create_time` int(11) DEFAULT NULL,
      `update_time` int(11) DEFAULT NULL,
      `delete_time` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='配送模板逻辑表';

ETO;
    $this->detectTable($tableName,$Sql);
//=================================================
    $tableName = 'finace_balanceset';
    $Sql = <<<ETO
    CREATE TABLE `{$tableName}` (
        `id` int(1) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
        `recharge` int(1) DEFAULT NULL COMMENT '是否开启账户充值 1 开启 0关闭',
        `proportion_status` int(1) DEFAULT NULL COMMENT '赠送状态 0固定元 1百分比',
        `sole` varchar(255) DEFAULT NULL COMMENT '赠送条件',
        `transfer` int(1) DEFAULT NULL COMMENT '是否开启余额转账 1开启 0关闭',
        `manual_wechat` int(1) DEFAULT NULL COMMENT '微信提现 0关闭 1开启',
        `manual_alipay` int(1) DEFAULT NULL COMMENT '支付宝提现 0关闭 1 开启',
        `manual_offline` int(1) DEFAULT NULL COMMENT '线下提现 0关闭 1开启',
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='余额设置';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================

$tableName = 'finace_balancesub';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `uid` int(11) DEFAULT NULL COMMENT '会员id',
    `remark` varchar(255) DEFAULT NULL COMMENT '备注',
    `before_balance` decimal(9,3) DEFAULT NULL COMMENT '更改前余额',
    `balance` decimal(9,3) DEFAULT NULL COMMENT '更改后余额',
    `state` int(1) DEFAULT NULL COMMENT '业务类型 0平台扣款 1后台充值2用户充值3用户提现',
    `money` decimal(9,3) DEFAULT NULL COMMENT '金额',
    `create_time` int(11) DEFAULT NULL,
    `credit_type` int(11) NOT NULL COMMENT '积分类型id',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='余额明细表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================

$tableName = 'finace_income';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `money` decimal(9,3) DEFAULT NULL COMMENT '收入金额',
    `tos` int(1) DEFAULT NULL COMMENT '业务类型 0余额提现',
    `withstate` int(1) DEFAULT NULL COMMENT '提现状态 0未提现 1已提现',
    `moneystate` int(1) DEFAULT NULL COMMENT '打款状态 0无效 1未审核 2未打款 3已打款 4已驳回',
    `create_time` int(11) DEFAULT NULL,
    `uid` int(11) DEFAULT NULL COMMENT '会员id',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='收入明细表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================

$tableName = 'finace_offlinepayment';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
    `a_state` int(11) DEFAULT NULL COMMENT '收款路径 0充值余额 1购物支付',
    `order_id` int(11) DEFAULT NULL,
    `order_sn` varchar(255) DEFAULT NULL,
    `uid` int(11) DEFAULT NULL COMMENT '会员id',
    `money` decimal(9,3) DEFAULT NULL COMMENT '收款金额',
    `state` int(1) DEFAULT NULL COMMENT '收款时间 0 未审核 1收款成功 2收款失败',
    `create_time` int(11) DEFAULT NULL COMMENT '收款时间',
    `pay_id` int(11) DEFAULT NULL COMMENT '线下支付方式',
    `thumb` varchar(255) DEFAULT NULL COMMENT '付款截图',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'finace_offlinewithdrawals';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `uid` int(11) DEFAULT NULL COMMENT '会员id',
    `money` decimal(9,3) DEFAULT NULL COMMENT '收款金额',
    `state` int(1) DEFAULT NULL COMMENT '提现状态 0未审核 1提现成功 2提现失败',
    `pay_id` int(1) DEFAULT NULL COMMENT '线下提现方式',
    `thumb` varchar(255) DEFAULT NULL,
    `create_time` int(11) DEFAULT NULL COMMENT '提现时间',
    `procedure` decimal(9,3) DEFAULT NULL COMMENT '手续费',
    `cord_id` int(11) DEFAULT NULL COMMENT '提现表id',
    `alipaynumber` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '支付宝账号',
    `alipayname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '支付宝姓名',
    `alipaystates` int(1) DEFAULT NULL COMMENT '支付类型 0 图片 1账号',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'finace_uprecord';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `uid` int(11) DEFAULT NULL COMMENT '会员id',
    `way` int(1) DEFAULT NULL COMMENT '充值方式 0后台充值 1用户充值',
    `before_balance` decimal(9,3) DEFAULT NULL COMMENT '变更前余额',
    `after_balance` decimal(9,3) DEFAULT NULL COMMENT '变更后余额',
    `remark` varchar(255) DEFAULT NULL COMMENT '备注',
    `money` decimal(9,3) DEFAULT NULL COMMENT '充值金额',
    `state` int(1) DEFAULT NULL COMMENT '充值状态 0充值失败 1充值成功',
    `create_time` int(11) DEFAULT NULL COMMENT '充值时间',
    `credit_type` int(11) DEFAULT NULL COMMENT '积分类型id',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='充值记录表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'finace_withdrawalrecord';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `uid` int(11) DEFAULT NULL COMMENT '用户id',
    `number` varchar(40) DEFAULT NULL COMMENT '提现编号',
    `money` decimal(9,2) DEFAULT NULL COMMENT '金额',
    `numstatus` int(1) DEFAULT NULL COMMENT '提现方式 0微信 1支付宝 2余额 3手动',
    `status` int(1) DEFAULT NULL COMMENT '提现状态 0待审核 1待打款 2打款中 3已打款 4已驳回 5无效提现 ',
    `create_time` int(11) DEFAULT NULL,
    `remark` varchar(255) DEFAULT NULL COMMENT '备注',
    `before_balance` decimal(9,2) DEFAULT NULL,
    `after_balance` decimal(9,2) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户提现记录';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'finace_withdrawset';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `recharge` int(1) DEFAULT NULL COMMENT '开启余额提现 1开启 0关闭',
  `wechat` int(1) DEFAULT NULL COMMENT '提现微信 1开启 0关闭',
  `wechatmin` varchar(9) DEFAULT NULL COMMENT '微信最小金额',
  `wechatmax` varchar(9) DEFAULT NULL COMMENT '微信最大金额',
  `wechatnum` varchar(11) DEFAULT NULL COMMENT '微信每日次数',
  `alipay` int(1) DEFAULT NULL COMMENT '开启支付宝 1开启 2关闭',
  `alipaymin` varchar(9) DEFAULT NULL COMMENT '支付宝最小金额',
  `alipaymax` varchar(9) DEFAULT NULL COMMENT '支付宝最大金额',
  `alipaynum` varchar(11) DEFAULT NULL COMMENT '支付宝次数',
  `manual` int(1) DEFAULT NULL COMMENT '是否开启手动提现 1开启 0关闭',
  `manual_wechat` int(1) DEFAULT NULL COMMENT '微信提现 0关闭 1开启',
  `manual_alipay` int(1) DEFAULT NULL COMMENT '支付宝提现 0关闭 1开启',
  `service` int(1) DEFAULT NULL COMMENT '提现手续费 1固定金额 0手续费比例',
  `services` decimal(9,2) DEFAULT NULL COMMENT '手续费额度',
  `servicesminus` decimal(9,2) DEFAULT NULL COMMENT '提现达到减免手续费',
  `minservices` decimal(9,2) DEFAULT NULL COMMENT '提现最小金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='提现设置';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'goods';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引',
    `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为实体，2为虚拟',
    `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0下架 1上架',
    `title` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '商品标题',
    `thumb` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '商品首图',
    `thumb_url` text CHARACTER SET utf8 COMMENT '多图片json',
    `sku` varchar(5) CHARACTER SET utf8 DEFAULT '' COMMENT '单位',
    `description` text CHARACTER SET utf8 COMMENT '描述表单',
    `content` longtext CHARACTER SET utf8 COMMENT '商品内容',
    `market_price` decimal(14,2) DEFAULT '0.00' COMMENT '市场价',
    `price` decimal(14,2) NOT NULL DEFAULT '0.00' COMMENT '现价',
    `cost_price` decimal(14,2) DEFAULT '0.00' COMMENT '成本价',
    `stock` int(10) NOT NULL DEFAULT '0' COMMENT '商品库存',
    `reduce_stock_method` int(11) DEFAULT '0' COMMENT '减库存方式 0 拍下减库存 1 付款减库存 2 永久不减 totalcnf',
    `show_sales` int(11) DEFAULT '0' COMMENT '已出售数量',
    `real_sales` int(11) DEFAULT '0' COMMENT '实际出售数量',
    `weight` int(11) DEFAULT '0' COMMENT '重量',
    `dispatch` int(11) DEFAULT NULL COMMENT '运费逻辑ID',
    `has_option` int(11) DEFAULT '0' COMMENT '启用商品规格 0 不启用 1 启用',
    `is_new` tinyint(1) DEFAULT '0' COMMENT '新商品',
    `is_hot` tinyint(1) DEFAULT '0' COMMENT '热商品',
    `is_discount` tinyint(1) DEFAULT '0' COMMENT '折扣商品',
    `is_comment` tinyint(1) DEFAULT '0' COMMENT '是否允许评论',
    `comment_num` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
    `virtual_sales` int(11) DEFAULT '0' COMMENT '虚拟销售',
    `no_refund` tinyint(4) NOT NULL DEFAULT '0' COMMENT '不允许退款',
    `need_address` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否需要填写收货地址 0:是1:否',
    `create_time` int(11) DEFAULT NULL,
    `update_time` int(11) DEFAULT NULL,
    `delete_time` int(11) DEFAULT NULL,
    `deduction` int(11) DEFAULT '0' COMMENT '积分抵扣类型 id 数据在credit_type表中',
    `deduction_rate` decimal(11,2) DEFAULT '100.00' COMMENT '创业金抵扣比率 %',
    `deduction_amount` decimal(11,2) DEFAULT '0.00' COMMENT '抵扣金额',
    `deduction_status` tinyint(1) DEFAULT '0' COMMENT '是否开启积分抵扣',
    PRIMARY KEY (`id`),
    KEY `idx_isnew` (`is_new`),
    KEY `idx_ishot` (`is_hot`),
    KEY `idx_isdiscount` (`is_discount`),
    KEY `is_comment` (`is_comment`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'goods_category';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `goods_id` int(11) DEFAULT NULL,
    `category_id` int(11) DEFAULT NULL,
    `category_ids` varchar(255) DEFAULT NULL,
    `update_time` int(11) DEFAULT NULL,
    `create_time` int(11) DEFAULT NULL,
    `delete_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'goods_favor';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
    `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
    `create_time` int(11) unsigned DEFAULT NULL COMMENT '添加时间',
    `update_time` int(11) unsigned DEFAULT NULL COMMENT '更新时间',
    `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间时间',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='用户商品收藏';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'member';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `parent_ids` text COMMENT '父ID组 使用 /uid/ 进行分割',
  `parent_ids_s` int(11) NOT NULL DEFAULT '0' COMMENT '0未初始化  1初始化',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `level_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级ID',
  `head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `credit1` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '积分',
  `credit2` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '余额',
  `credit3` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '感恩奖',
  `credit4` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '创业金',
  `credit5` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '拼团券',
  `credit6` decimal(10,3) NOT NULL DEFAULT '0.000',
  `credit7` decimal(10,3) NOT NULL DEFAULT '0.000',
  `credit8` decimal(10,3) NOT NULL DEFAULT '0.000',
  `credit9` decimal(10,3) NOT NULL DEFAULT '0.000',
  `credit10` decimal(10,3) NOT NULL DEFAULT '0.000',
  `fname` varchar(11) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `fid` varchar(30) NOT NULL DEFAULT '' COMMENT '身份证号',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0-正常;1-黑名单',
  `content` text COMMENT '备注',
  `member_form` text COMMENT '自定义表单',
  `password` varchar(100) DEFAULT NULL COMMENT '密码MD5',
  `salt` varchar(8) DEFAULT NULL COMMENT '盐值',
  `invite_code` varchar(8) DEFAULT NULL COMMENT '邀请码',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户数据表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'member_address';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '收货姓名',
  `connect_mobile` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '收货电话',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认地址 0 否 1 是',
  `province_id` int(11) DEFAULT '0' COMMENT '省id',
  `city_id` int(11) DEFAULT '0' COMMENT '市id',
  `district_id` int(11) DEFAULT '0' COMMENT '区id',
  `street_id` int(11) DEFAULT NULL COMMENT '街道id',
  `area` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '详细地址',
  `note` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'member_cioauth';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `unioid` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  UNIQUE KEY `openid` (`openid`),
  UNIQUE KEY `unioid` (`unioid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户Ci互联授权表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'member_qqoauth';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `openid` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `unioid` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `source` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  UNIQUE KEY `openid` (`openid`),
  UNIQUE KEY `unioid` (`unioid`),
  UNIQUE KEY `token` (`token`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='QQ授权绑定';

ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'member_uploadfile';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `upload_type` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT 'local' COMMENT '存储位置',
  `original_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '文件原名',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '物理路径',
  `file` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '真实物理路径',
  `image_width` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '宽度',
  `image_height` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '高度',
  `image_type` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '图片类型',
  `image_frames` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片帧数',
  `mime_type` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'mime类型',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `file_ext` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sha1` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `create_time` int(10) DEFAULT NULL COMMENT '创建日期',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `upload_time` int(10) DEFAULT NULL COMMENT '上传时间',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '上传者',
  `state` int(10) NOT NULL DEFAULT '0' COMMENT '0为临时 1为正式',
  PRIMARY KEY (`id`),
  KEY `upload_type` (`upload_type`),
  KEY `original_name` (`original_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户上传文件表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'member_wxoauth';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `wid` int(11) NOT NULL DEFAULT '0' COMMENT '微信服务ID',
  `access_token` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '临时KEY',
  `openid` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户唯一ID',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '绑定时间',
  `nickname` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户昵称',
  `sex` int(11) NOT NULL DEFAULT '0' COMMENT '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
  `province` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户个人资料填写的省份',
  `city` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '普通用户个人资料填写的城市',
  `country` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '国家，如中国为CN',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT '状态 1为关注 0为取消关注',
  UNIQUE KEY `openid` (`openid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='微信oauth绑定';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'order';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` tinyint(1) DEFAULT '0' COMMENT '订单类型0普通订单1拼团订单',
  `order_sn` varchar(23) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '订单号',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品金额',
  `goods_total` int(11) NOT NULL DEFAULT '1' COMMENT '商品数量',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0待付款，1为已付款，2为已发货，3为已完成-3已退款',
  `finish_time` int(11) NOT NULL DEFAULT '0' COMMENT '交易完成时间',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `cancel_time` int(11) NOT NULL DEFAULT '0' COMMENT '取消时间',
  `cancel_pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '取消支付时间',
  `cancel_send_time` int(11) NOT NULL DEFAULT '0' COMMENT '取消发货时间',
  `dispatch_type_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0无需配送,1快递,2门店自提,3门店配送',
  `dispatch_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `discount_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `pay_type_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式id',
  `online_pay_id` int(11) DEFAULT '0' COMMENT '线上支付id',
  `order_goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单商品总金额',
  `deduction_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '抵扣总金额',
  `refund_id` int(11) NOT NULL DEFAULT '0' COMMENT '退款记录id',
  `change_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单改价金额',
  `change_dispatch_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费改价金额',
  `comment_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未评论,1以评论',
  `order_pay_id` varchar(23) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '订单支付记录id',
  `is_virtual` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否虚拟订单',
  `cost_amount` decimal(14,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `auto_receipt` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否自动收货 0:是1:否',
  `express_company_name` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '快递公司名',
  `express_sn` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '快递单号',
  `express_code` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '快递公司码',
  `merchant_remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '商家备注',
  `is_deduction` tinyint(1) DEFAULT '0' COMMENT '是否使用积分抵扣',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `is_refund` tinyint(1) DEFAULT '1' COMMENT '是否能够退款0否1是',
  PRIMARY KEY (`id`),
  KEY `yz_order_uid_index` (`uid`),
  KEY `yz_order_order_sn_index` (`order_sn`),
  KEY `yz_order_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单主表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'order_address';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `address` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '收货地址',
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '联系人电话',
  `realname` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `province_id` int(11) NOT NULL DEFAULT '0' COMMENT '省id',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '市id',
  `district_id` int(11) NOT NULL DEFAULT '0' COMMENT '区id',
  `street_id` int(11) DEFAULT '0' COMMENT '街道id',
  `note` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `yz_order_address_order_id_index` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单收货地址';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'order_goods';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引',
  `order_id` int(11) DEFAULT '0' COMMENT '订单ID',
  `type` tinyint(1) DEFAULT '0' COMMENT '商品类型0普通商品1拼团商品',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `pay_sn` varchar(23) CHARACTER SET utf8 DEFAULT '' COMMENT '支付订单',
  `total` int(11) NOT NULL DEFAULT '1' COMMENT '订单商品件数',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '真实价格',
  `goods_sn` varchar(50) CHARACTER SET utf8 DEFAULT '' COMMENT '商品编码',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `thumb` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '商品图片 URL',
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品快照价格',
  `goods_option` text COMMENT '商品规格json数据',
  `goods_option_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品规格id',
  `goods_option_title` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '商品规格标题',
  `product_sn` varchar(23) CHARACTER SET utf8 DEFAULT '' COMMENT '产品编号',
  `discount_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额总计',
  `comment_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '评论状态',
  `change_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '改价金额',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '评论标题',
  `goods_market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品市场价总计',
  `goods_cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价总计',
  `vip_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品会员价总计',
  `coupon_price` decimal(10,2) DEFAULT '0.00' COMMENT '优惠券优惠金额',
  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品实际支付金额总计',
  `is_deduction` tinyint(1) DEFAULT '0' COMMENT '是否使用积分抵扣0否1是',
  `deduction` int(10) DEFAULT '0' COMMENT '抵扣类型',
  `deduction_rate` decimal(10,2) DEFAULT '100.00' COMMENT '积分抵扣余额比例',
  `credit_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消耗积分数量',
  `deduction_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品抵扣优惠金额(积分抵扣金额)',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `deduction_most_amount` decimal(10,2) DEFAULT '0.00' COMMENT '抵扣支持最大金额',
  `total_price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '总计抵扣后价格',
  PRIMARY KEY (`id`),
  KEY `yz_order_goods_order_id_index` (`order_id`),
  KEY `yz_order_goods_goods_id_index` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单商品表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'order_pay';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT '0',
  `order_sn` varchar(32) NOT NULL DEFAULT '',
  `status` tinyint(4) DEFAULT '1' COMMENT '0已经退款1已支付',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `pay_type_id` tinyint(4) NOT NULL DEFAULT '0',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付状态(暂时无用)',
  `amount` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `second_type` varchar(255) DEFAULT NULL COMMENT '第二类型(暂时无用)',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uid`),
  KEY `idx_member_id` (`order_id`),
  KEY `idx_order_no` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'order_refund';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
    `uid` int(11) DEFAULT NULL COMMENT '申请用户',
    `order_id` int(11) DEFAULT NULL COMMENT '所属订单',
    `order_sn` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '订单号',
    `price` decimal(10,2) DEFAULT NULL COMMENT '退款金额',
    `status` tinyint(4) DEFAULT '0' COMMENT '退款状态 0申请1成功2失败',
    `reason` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '原因',
    `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
    `create_time` int(11) DEFAULT NULL,
    `update_time` int(11) DEFAULT NULL,
    `delete_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'page_carousel';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `weight` int(11) DEFAULT NULL COMMENT '权重',
    `link` varchar(255) DEFAULT NULL COMMENT '链接',
    `state` int(1) DEFAULT NULL COMMENT '状态 0为关闭1为开启',
    `picture` varchar(255) DEFAULT NULL COMMENT '轮播图',
    `create_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='轮播图表';  
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'page_notice';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `title` varchar(255) DEFAULT NULL COMMENT '标题',
    `notice` longtext COMMENT '公告',
    `state` int(1) DEFAULT NULL COMMENT '状态 0关闭 1 开启',
    `create_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公告表';  
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'pay_type';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引',
    `name` varchar(255) DEFAULT NULL COMMENT '名称',
    `icon` varchar(255) DEFAULT NULL COMMENT '图标',
    `status` tinyint(1) DEFAULT '0' COMMENT '状态0关闭1开启',
    `create_time` int(11) DEFAULT NULL,
    `update_time` int(11) DEFAULT NULL,
    `delete_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单支付类型表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'plugins_data';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引',
  `dir` varchar(100) NOT NULL DEFAULT '' COMMENT '目录',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `version` varchar(100) NOT NULL DEFAULT '' COMMENT '版本',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `author` varchar(100) NOT NULL DEFAULT '' COMMENT '作者',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者官网',
  `namespace` varchar(100) NOT NULL DEFAULT '' COMMENT '类名',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态 0未启用 1启用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dir` (`dir`),
  KEY `state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='插件安装表';
ETO;
$this->detectTable($tableName,$Sql);

//=================================================
$tableName = 'system_admin';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `auth_ids` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '角色权限ID',
  `head_img` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '头像',
  `username` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户登录名',
  `password` char(40) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户登录密码',
  `phone` varchar(16) CHARACTER SET utf8 DEFAULT NULL COMMENT '联系手机号',
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '备注说明',
  `credit1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  `credit2` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `credit3` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '备用',
  `credit4` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '备用',
  `login_num` bigint(20) unsigned DEFAULT '0' COMMENT '登录次数',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用,)',
  `openid` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '互联授权Openid',
  `unionid` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '互联授权Unionid',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='系统用户表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_auth';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '权限名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(1:禁用,2:启用)',
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注说明',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='系统权限表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_auth_node';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `auth_id` bigint(20) unsigned DEFAULT NULL COMMENT '角色ID',
    `node_id` bigint(20) DEFAULT NULL COMMENT '节点ID',
    PRIMARY KEY (`id`),
    KEY `index_system_auth_auth` (`auth_id`) USING BTREE,
    KEY `index_system_auth_node` (`node_id`) USING BTREE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色与节点关系表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_config';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '变量名',
    `group` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分组',
    `value` text CHARACTER SET utf8 COMMENT '变量值',
    `remark` varchar(100) CHARACTER SET utf8 DEFAULT '' COMMENT '备注信息',
    `sort` int(10) DEFAULT '0',
    `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
    `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`),
    KEY `group` (`group`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='系统配置表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_log';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_name` varchar(150) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '管理员ID',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `method` varchar(50) NOT NULL DEFAULT '' COMMENT '请求方法',
  `title` varchar(100) DEFAULT '' COMMENT '日志标题',
  `content` text NOT NULL COMMENT '内容',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) DEFAULT '' COMMENT 'User-Agent',
  `create_time` int(10) DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台操作日志表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_menu';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
    `title` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
    `icon` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单图标',
    `href` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '链接',
    `params` varchar(500) CHARACTER SET utf8 DEFAULT '' COMMENT '链接参数',
    `target` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
    `sort` int(11) DEFAULT '0' COMMENT '菜单排序',
    `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
    `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
    `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
    `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`),
    KEY `title` (`title`),
    KEY `href` (`href`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='后台系统菜单表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_node';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `node` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '节点代码',
    `title` varchar(500) CHARACTER SET utf8 DEFAULT NULL COMMENT '节点标题',
    `type` tinyint(1) DEFAULT '3' COMMENT '节点类型（1：控制器，2：节点）',
    `is_auth` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启动RBAC权限控制',
    `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
    `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`),
    KEY `node` (`node`) USING BTREE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='后台系统节点表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_quick';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '快捷入口名称',
  `icon` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '图标',
  `href` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '快捷链接',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(1:禁用,2:启用)',
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注说明',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='系统快捷入口表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'system_uploadfile';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `upload_type` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT 'local' COMMENT '存储位置',
  `original_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '文件原名',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '物理路径',
  `file` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '真实物理路径',
  `image_width` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '宽度',
  `image_height` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '高度',
  `image_type` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '图片类型',
  `image_frames` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片帧数',
  `mime_type` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'mime类型',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `file_ext` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sha1` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `create_time` int(10) DEFAULT NULL COMMENT '创建日期',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `upload_time` int(10) DEFAULT NULL COMMENT '上传时间',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '上传者',
  `state` int(10) NOT NULL DEFAULT '0' COMMENT '0为临时 1为正式',
  PRIMARY KEY (`id`),
  KEY `upload_type` (`upload_type`),
  KEY `original_name` (`original_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='上传文件表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'transfer_credit';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '转让用户',
  `type` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '装张类型0积分转余额1积分转账',
  `target_mobile` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '转让目标手机号',
  `target_uid` int(11) DEFAULT NULL COMMENT '转让用户的目标用户',
  `credit_type` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '(争议可以改成credit_type的id)积分类型(例如credit2参考用户表积分)',
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '积分金额',
  `status` tinyint(4) DEFAULT '0' COMMENT '停用(申请状态0新申请1申请通过2申请驳回3已取消)',
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  `reason` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '原因',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='转让积分申请表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'wechat';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `account` varchar(30) NOT NULL DEFAULT '',
  `original` varchar(50) NOT NULL DEFAULT '',
  `appid` varchar(30) NOT NULL DEFAULT '' COMMENT '公众号',
  `appsecret` varchar(50) NOT NULL DEFAULT '' COMMENT '公众号',
  `mchid` varchar(30) NOT NULL DEFAULT '' COMMENT '支付',
  `key` varchar(50) NOT NULL DEFAULT '' COMMENT '支付',
  `token` varchar(32) NOT NULL DEFAULT '',
  `encodingaeskey` varchar(255) NOT NULL DEFAULT '',
  `login` int(11) NOT NULL DEFAULT '0',
  `pay` int(11) NOT NULL DEFAULT '0',
  `state` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `appid` (`appid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='微信公众号表';
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'wechat_pay';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    `app_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    `app_secret` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    `is_login` tinyint(1) DEFAULT '0' COMMENT '0 1可以登录',
    `merchant_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '商户id',
    `merchant_secret` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '商户支付秘钥',
    `cert_file` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    `key_file` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    `is_union` tinyint(1) DEFAULT '0' COMMENT '是否唯一支付',
    `open_status` tinyint(1) DEFAULT '0' COMMENT '0关闭1打开(只能有一个打开)',
    `create_time` int(11) DEFAULT NULL,
    `update_time` int(11) DEFAULT NULL,
    `delete_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ETO;
$this->detectTable($tableName,$Sql);
//=================================================
$tableName = 'pay_log';
$Sql = <<<ETO
CREATE TABLE `{$tableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `pay_id` int(11) DEFAULT NULL COMMENT '支付订单号',
  `pay_account` int(11) DEFAULT '0' COMMENT '支付的微信号微信表里的id',
  `status` tinyint(255) DEFAULT '0' COMMENT '状态0未完成支付1已完成支付',
  `order_sn` varchar(255) DEFAULT NULL COMMENT '订单号order的id',
  `pay_type` tinyint(1) DEFAULT NULL COMMENT '支付类型pay_type的id',
  `result_notice` text COMMENT '支付结果通知',
  `log_type` tinyint(1) DEFAULT '0' COMMENT '支付类型(0订单，1充值)',
  `amount` decimal(10,2) DEFAULT '0.00' COMMENT '付款金额',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='支付日志表';
ETO;
$this->detectTable($tableName,$Sql);

//=================================================
//===============【添加SQL数据】===================
//=================================================


$tableName = 'credit_type';
$Sql = <<<ETO
INSERT INTO `{$tableName}` (`id`, `title`, `value`, `is_pay`, `is_withdraw`, `is_transfer`, `is_convert`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '余额', 'credit2',  1,  1,  1,  0,  NULL, 1614240049, NULL),
(2, '感恩奖',  'credit3',  0,  0,  0,  1,  NULL, NULL, 1),
(3, '创业金',  'credit4',  1,  0,  1,  0,  NULL, 1613615831, NULL),
(4, '积分', 'credit1',  0,  0,  0,  0,  NULL, NULL, 1),
(5, '拼团券',  'credit5',  0,  0,  0,  0,  NULL, NULL, NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `title` = VALUES(`title`), `value` = VALUES(`value`), `is_pay` = VALUES(`is_pay`), `is_withdraw` = VALUES(`is_withdraw`), `is_transfer` = VALUES(`is_transfer`), `is_convert` = VALUES(`is_convert`), `create_time` = VALUES(`create_time`), `update_time` = VALUES(`update_time`), `delete_time` = VALUES(`delete_time`);
ETO;
$this->insertTable($tableName,$Sql);
//=================================================


$tableName = 'finace_balanceset';
$Sql = <<<ETO
INSERT INTO `{$tableName}` (`id`, `recharge`, `proportion_status`, `sole`, `transfer`, `manual_wechat`, `manual_alipay`, `manual_offline`) VALUES
(2, 1,  0,  '[]', 1,  1,  1,  1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `recharge` = VALUES(`recharge`), `proportion_status` = VALUES(`proportion_status`), `sole` = VALUES(`sole`), `transfer` = VALUES(`transfer`), `manual_wechat` = VALUES(`manual_wechat`), `manual_alipay` = VALUES(`manual_alipay`), `manual_offline` = VALUES(`manual_offline`);
ETO;
$this->insertTable($tableName,$Sql);
//=================================================


$tableName = 'finace_withdrawset';
$Sql = <<<ETO
INSERT INTO `{$tableName}` (`id`, `recharge`, `wechat`, `wechatmin`, `wechatmax`, `wechatnum`, `alipay`, `alipaymin`, `alipaymax`, `alipaynum`, `manual`, `manual_wechat`, `manual_alipay`, `service`, `services`, `servicesminus`, `minservices`) VALUES
(3, 1,  0,  '', '', '', 0,  '', '', '', 1,  1,  1,  0,  6.00, 0.00, 0.00)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `recharge` = VALUES(`recharge`), `wechat` = VALUES(`wechat`), `wechatmin` = VALUES(`wechatmin`), `wechatmax` = VALUES(`wechatmax`), `wechatnum` = VALUES(`wechatnum`), `alipay` = VALUES(`alipay`), `alipaymin` = VALUES(`alipaymin`), `alipaymax` = VALUES(`alipaymax`), `alipaynum` = VALUES(`alipaynum`), `manual` = VALUES(`manual`), `manual_wechat` = VALUES(`manual_wechat`), `manual_alipay` = VALUES(`manual_alipay`), `service` = VALUES(`service`), `services` = VALUES(`services`), `servicesminus` = VALUES(`servicesminus`), `minservices` = VALUES(`minservices`);
ETO;
$this->insertTable($tableName,$Sql);
//=================================================


$tableName = 'system_auth';
$Sql = <<<ETO
INSERT INTO `{$tableName}` (`id`, `title`, `sort`, `status`, `remark`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '管理员',  1,  1,  '测试管理员',  1588921753, 1589614331, NULL),
(7, '主管', 0,  1,  '主管', 1596096562, 1603276352, NULL),
(8, '维护', 0,  1,  '维护', 1596096573, 1603276321, NULL),
(10,  '物流', 0,  1,  '物流', 1596096666, 1603276295, NULL),
(11,  '客服', 0,  1,  '客服', 1596197344, 1603276335, NULL),
(12,  '财务', 0,  1,  '财务', 1596937441, 1603276281, NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `title` = VALUES(`title`), `sort` = VALUES(`sort`), `status` = VALUES(`status`), `remark` = VALUES(`remark`), `create_time` = VALUES(`create_time`), `update_time` = VALUES(`update_time`), `delete_time` = VALUES(`delete_time`);
ETO;
$this->insertTable($tableName,$Sql);
//=================================================

$tableName = 'pay_type';
$Sql = <<<ETO
INSERT INTO `{$tableName}`  (`id`, `name`, `icon`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '微信支付', '/static/common/images/wechat.png', 1,  1,  1615169018, NULL),
(2, '支付宝支付',  '/static/common/images/ali.png',  1,  1,  1615169018, NULL),
(3, '线下支付', '/static/common/images/xianxia.png',  1,  1,  1615169111, NULL),
(4, '余额支付', '/static/common/images/balance.png',  1,  1,  1614830330, NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `icon` = VALUES(`icon`), `status` = VALUES(`status`), `create_time` = VALUES(`create_time`), `update_time` = VALUES(`update_time`), `delete_time` = VALUES(`delete_time`);
ETO;

$this->insertTable($tableName,$Sql);
//=================================================

$tableName = 'system_config';
$Sql = <<<ETO
INSERT INTO `{$tableName}` (`id`, `name`, `group`, `value`, `remark`, `sort`, `create_time`, `update_time`) VALUES
(41,  'alisms_access_key_id', 'sms',  '填你的',  '阿里大于公钥', 0,  NULL, NULL),
(42,  'alisms_access_key_secret', 'sms',  '填你的',  '阿里大鱼私钥', 0,  NULL, NULL),
(55,  'upload_type',  'upload', 'local',  '当前上传方式 （local,alioss,qnoss,txoss）',  0,  NULL, NULL),
(56,  'upload_allow_ext', 'upload', 'doc,gif,ico,icon,jpg,mp3,mp4,p12,pem,png,rar,jpeg',  '允许上传的文件类型',  0,  NULL, NULL),
(57,  'upload_allow_size',  'upload', '1048576',  '允许上传的大小',  0,  NULL, NULL),
(58,  'upload_allow_mime',  'upload', 'image/gif,image/jpeg,video/x-msvideo,text/plain,image/png',  '允许上传的文件mime',  0,  NULL, NULL),
(59,  'upload_allow_type',  'upload', 'local,alioss,qnoss,txcos', '可用的上传文件方式',  0,  NULL, NULL),
(60,  'alioss_access_key_id', 'upload', '填你的',  '阿里云oss公钥', 0,  NULL, NULL),
(61,  'alioss_access_key_secret', 'upload', '填你的',  '阿里云oss私钥', 0,  NULL, NULL),
(62,  'alioss_endpoint',  'upload', '填你的',  '阿里云oss数据中心', 0,  NULL, NULL),
(63,  'alioss_bucket',  'upload', '填你的',  '阿里云oss空间名称', 0,  NULL, NULL),
(64,  'alioss_domain',  'upload', '填你的',  '阿里云oss访问域名', 0,  NULL, NULL),
(65,  'logo_title', 'site', 'HaSog',  'LOGO标题', 0,  NULL, NULL),
(66,  'logo_image', 'site', '',  'logo图片', 0,  NULL, NULL),
(68,  'site_name',  'site', 'HaSog幻神商城', '站点名称', 0,  NULL, NULL),
(69,  'site_ico', 'site', '',  '浏览器图标',  0,  NULL, NULL),
(70,  'site_copyright', 'site', 'HaSog ©版权所有',  '版权信息', 0,  NULL, NULL),
(71,  'site_beian', 'site', ' XICP备XXXXXXX号',  '备案信息', 0,  NULL, NULL),
(72,  'site_version', 'site', '1.0.0',  '版本信息', 0,  NULL, NULL),
(75,  'sms_type', 'sms',  'alisms', '短信类型', 0,  NULL, NULL),
(76,  'miniapp_appid',  'wechat', '填你的',  '小程序公钥',  0,  NULL, NULL),
(77,  'miniapp_appsecret',  'wechat', '填你的',  '小程序私钥',  0,  NULL, NULL),
(78,  'web_appid',  'wechat', '填你的',  '公众号公钥',  0,  NULL, NULL),
(79,  'web_appsecret',  'wechat', '填你的',  '公众号私钥',  0,  NULL, NULL),
(80,  'txcos_secret_id',  'upload', '填你的',  '腾讯云cos密钥', 0,  NULL, NULL),
(81,  'txcos_secret_key', 'upload', '填你的',  '腾讯云cos私钥', 0,  NULL, NULL),
(82,  'txcos_region', 'upload', '填你的',  '存储桶地域',  0,  NULL, NULL),
(83,  'tecos_bucket', 'upload', '填你的',  '存储桶名称',  0,  NULL, NULL),
(84,  'qnoss_access_key', 'upload', '填你的',  '访问密钥', 0,  NULL, NULL),
(85,  'qnoss_secret_key', 'upload', '填你的',  '安全密钥', 0,  NULL, NULL),
(86,  'qnoss_bucket', 'upload', '填你的',  '存储空间', 0,  NULL, NULL),
(87,  'qnoss_domain', 'upload', '填你的',  '访问域名', 0,  NULL, NULL),
(88,  'site_kefu',  'site', '暂无', '填写客服信息', 0,  NULL, NULL),
(89,  'shop_useryh',  'shop', '0', '优惠用户组ID',  0,  NULL, NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `group` = VALUES(`group`), `value` = VALUES(`value`), `remark` = VALUES(`remark`), `sort` = VALUES(`sort`), `create_time` = VALUES(`create_time`), `update_time` = VALUES(`update_time`);
ETO;
$this->insertTable($tableName,$Sql);
//=================================================


$tableName = 'system_menu';
$Sql = <<<ETO
INSERT INTO `{$tableName}` (`id`, `pid`, `title`, `icon`, `href`, `params`, `target`, `sort`, `status`, `remark`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 0,  '插件系统', 'fa fa-cloud-download', 'plus.share/index', '', '_self',  1,  1,  '', 1596164188, 1608882377, NULL),
(2, 99999999, '后台首页', 'fa fa-home', 'index/home', '', '_self',  0,  1,  NULL, NULL, 1602812869, NULL),
(3, 0,  '会员管理', 'fa fa-users',  '', '', '_self',  80, 1,  '', 1596164775, 1603348898, NULL),
(4, 0,  '订单管理', 'fa fa-reorder',  '', '', '_self',  70, 1,  '', 1603095574, 1614935627, NULL),
(5, 0,  '财务管理', 'fa fa-address-card-o', '', '', '_self',  60, 1,  '', 1603095637, 1614934956, NULL),
(6, 0,  '系统管理', 'fa fa-cog',  '', '', '_self',  0,  1,  '', NULL, 1603095426, NULL),
(7, 0,  '商品管理', 'fa fa-shopping-cart',  '', '', '_self',  90, 1,  '', 1596093192, 1614935238, NULL),
(8, 6,  '菜单管理', 'fa fa-tree', 'system.menu/index',  '', '_self',  10, 1,  NULL, NULL, NULL, NULL),
(9, 6,  '后台用户管理', 'fa fa-user', 'system.admin/index', '', '_self',  12, 1,  NULL, NULL, NULL, NULL),
(10,  6,  '角色管理', 'fa fa-bitbucket-square', 'system.auth/index',  '', '_self',  11, 1,  NULL, NULL, NULL, NULL),
(11,  6,  '节点管理', 'fa fa-list', 'system.node/index',  '', '_self',  9,  1,  NULL, NULL, NULL, NULL),
(12,  6,  '配置管理', 'fa fa-asterisk', 'system.config/index',  '', '_self',  8,  1,  NULL, NULL, NULL, NULL),
(13,  6,  '上传管理', 'fa fa-arrow-up', 'system.uploadfile/index',  '', '_self',  0,  1,  NULL, NULL, NULL, NULL),
(14,  6,  '快捷入口', 'fa fa-list', 'system.quick/index', '', '_self',  0,  1,  NULL, NULL, NULL, NULL),
(15,  1,  '我的插件', 'fa fa-cogs', 'plugin.index/index', '', '_self',  100,  1,  NULL, NULL, NULL, NULL),
(16,  1,  '插件市场', 'fa fa-puzzle-piece', 'plugin.cloud/index', '', '_self',  100,  1,  '', NULL, 1606039969, NULL),
(17,  6,  '日志管理', 'fa fa-clock-o',  'system.log/index', '', '_self',  0,  1,  NULL, NULL, NULL, NULL),
(20,  3,  '会员列表', 'fa fa-address-book', 'member.user/index',  '', '_self',  90, 1,  '', 1603349494, 1614935382, NULL),
(21,  7,  '商品管理', 'fa fa-shopping-cart',  'goods.home/index', '', '_self',  100,  1,  '', 1603433706, 1603433706, NULL),
(23,  7,  '配送管理', 'fa fa-paper-plane',  'goods.dispatch/index', '', '_self',  80, 1,  '', 1603704730, 1603704730, NULL),
(24,  4,  '订单列表', 'fa fa-align-justify',  'order.home/index', '', '_self',  100,  1,  '', 1604024310, 1614939632, NULL),
(26,  5,  '余额设置', 'fa fa-dollar', 'finace.balanceset/edit', '', '_self',  100,  1,  '', 1608881230, 1614934899, NULL),
(27,  5,  '提现设置', 'fa fa-gear', 'finace.withdrawset/edit',  '', '_self',  99, 1,  '', 1608881306, 1614935010, NULL),
(28,  261,  '用户提现记录', 'fa fa-list', 'finace.withdrawalrecord/index',  '', '_self',  0,  1,  '', 1608881357, 1614934423, NULL),
(29,  260,  '线下收款记录', 'fa fa-file-text-o',  'finace.offlinepayment/index',  '', '_self',  0,  1,  '', 1608881423, 1614935075, NULL),
(30,  259,  '充值余额', 'fa fa-dollar', 'finace.upbalance/index', '', '_self',  0,  1,  '', 1608881467, 1614935122, NULL),
(31,  261,  '充值记录', 'fa fa-list', 'finace.uprecord/index',  '', '_self',  0,  1,  '', 1608881539, 1614934432, NULL),
(32,  259,  '余额明细', 'fa fa-list', 'finace.balancesub/index',  '', '_self',  0,  1,  '', 1608881588, 1614934211, NULL),
(33,  261,  '收入明细', 'fa fa-list', 'finace.income/index',  '', '_self',  0,  1,  '', 1608881627, 1614934443, NULL),
(34,  261,  '提现统计', 'fa fa-list', 'finace.withdrawsts/index', '', '_self',  0,  1,  '', 1608881678, 1614934480, NULL),
(35,  0,  '界面管理', 'fa fa-android',  '', '', '_self',  10, 1,  '', 1608881742, 1614939517, NULL),
(36,  35, '轮播图管理',  'fa fa-picture-o',  'page.carousel/index',  '', '_self',  0,  1,  '', 1608881815, 1608881815, NULL),
(37,  35, '公告管理', 'fa fa-calendar-o', 'page.notice/index',  '', '_self',  0,  1,  '', 1608881857, 1614937384, NULL),
(38,  0,  '付款通道', 'fa fa-cny',  '', '', '_self',  59, 1,  '', 1608881893, 1614940217, NULL),
(39,  264,  '用户反馈', 'fa fa-book', 'admins.feedback/index',  '', '_self',  0,  1,  '', 1608881944, 1614936760, NULL),
(40,  38, '线下付款配置', 'fa fa-gear', 'admins.payment/index', '', '_self',  0,  1,  '', 1608881995, 1614940034, NULL),
(41,  38, '支付宝支付资源',  'fa fa-github-alt', 'pay.ali_pay/index',  '', '_self',  0,  1,  '', 1608882534, 1614940140, NULL),
(42,  38, '微信支付资源', 'fa fa-wechat', 'pay.wechat_pay/index', '', '_self',  0,  1,  '', 1608882611, 1614940083, NULL),
(44,  7,  '商品分类', 'fa fa-list-ol',  'goods.category/index', '', '_self',  0,  1,  '', 1608951659, 1614935370, NULL),
(45,  262,  '已付款',  'fa fa-list', 'order.home/index?action=paid', '', '_self',  0,  1,  '', 1609039821, 1614936529, NULL),
(46,  262,  '已发货',  'fa fa-list', 'order.home/index?action=send_goods', '', '_self',  0,  1,  '', 1609039851, 1614936539, NULL),
(47,  4,  '退款审核', 'fa fa-list', 'order.order_refund/index', '', '_self',  0,  1,  '', 1609039912, 1614939645, NULL),
(139, 263,  '积分配置', 'fa fa-cog',  'member.transfer_credit/index', '', '_self',  0,  1,  '', 1613548008, 1614936735, NULL),
(140, 263,  '积分转账', 'fa fa-credit-card',  'member.transfer_credit/list',  '', '_self',  0,  1,  '', 1613554910, 1614936744, NULL),
(205, 260,  '线下提现记录', 'fa fa-file-text-o',  'finace.offlinewithdrawals/index',  '', '_self',  0,  1,  '', 1613812021, 1614935082, NULL),
(245, 264,  '反馈黑名单',  'fa fa-address-book-o', 'admins.feedbackset/index', '', '_self',  0,  1,  '', 1614236710, 1614936774, NULL),
(258, 38, '支付开关', 'fa fa-adjust', 'pay.pay_type/index', '', '_self',  0,  1,  '', 1614829846, 1614940050, NULL),
(259, 5,  '余额相关', 'fa fa-dollar', '', '', '_self',  70, 1,  '', 1614934172, 1614935112, NULL),
(260, 5,  '财务审核', 'fa fa-file-text-o',  '', '', '_self',  80, 1,  '', 1614934343, 1614935037, NULL),
(261, 5,  '财务统计', 'fa fa-list', '', '', '_self',  0,  1,  '', 1614934411, 1614934411, NULL),
(262, 4,  '订单状态', 'fa fa-list', '', '', '_self',  0,  1,  '', 1614936495, 1614939660, NULL),
(263, 3,  '积分管理', 'fa fa-credit-card',  '', '', '_self',  0,  1,  '', 1614936670, 1614936670, NULL),
(264, 3,  '反馈管理', 'fa fa-address-book', '', '', '_self',  0,  1,  '', 1614936713, 1614936713, NULL),
(301, 35, '导航管理', 'fa fa-arrow-circle-right', 'page.navigation/index',  '', '_self',  0,  1,  '', 1615362737, 1615362737, NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `pid` = VALUES(`pid`), `title` = VALUES(`title`), `icon` = VALUES(`icon`), `href` = VALUES(`href`), `params` = VALUES(`params`), `target` = VALUES(`target`), `sort` = VALUES(`sort`), `status` = VALUES(`status`), `remark` = VALUES(`remark`), `create_time` = VALUES(`create_time`), `update_time` = VALUES(`update_time`), `delete_time` = VALUES(`delete_time`);
ETO;
$this->insertTable($tableName,$Sql);
//=================================================


$tableName = 'system_node';
$Sql = <<<ETO
INSERT INTO `{$tableName}` (`id`, `node`, `title`, `type`, `is_auth`, `create_time`, `update_time`) VALUES
(1, 'system.admin', '管理员管理',  1,  1,  1603275459, 1603275459),
(2, 'system.admin/index', '列表', 2,  1,  1603275459, 1603275459),
(3, 'system.admin/add', '添加', 2,  1,  1603275459, 1603275459),
(4, 'system.admin/edit',  '编辑', 2,  1,  1603275459, 1603275459),
(5, 'system.admin/password',  '编辑', 2,  1,  1603275459, 1603275459),
(6, 'system.admin/delete',  '删除', 2,  1,  1603275459, 1603275459),
(7, 'system.admin/modify',  '属性修改', 2,  1,  1603275459, 1603275459),
(8, 'system.admin/export',  '导出', 2,  1,  1603275459, 1603275459),
(9, 'system.auth',  '角色权限管理', 1,  1,  1603275459, 1603275459),
(10,  'system.auth/authorize',  '授权', 2,  1,  1603275459, 1603275459),
(11,  'system.auth/saveAuthorize',  '授权保存', 2,  1,  1603275459, 1603275459),
(12,  'system.auth/index',  '列表', 2,  1,  1603275459, 1603275459),
(13,  'system.auth/add',  '添加', 2,  1,  1603275459, 1603275459),
(14,  'system.auth/edit', '编辑', 2,  1,  1603275459, 1603275459),
(15,  'system.auth/delete', '删除', 2,  1,  1603275459, 1603275459),
(16,  'system.auth/export', '导出', 2,  1,  1603275459, 1603275459),
(17,  'system.auth/modify', '属性修改', 2,  1,  1603275459, 1603275459),
(18,  'system.config',  '系统配置管理', 1,  1,  1603275459, 1603275459),
(19,  'system.config/index',  '列表', 2,  1,  1603275459, 1603275459),
(20,  'system.config/save', '保存', 2,  1,  1603275459, 1603275459),
(21,  'system.menu',  '菜单管理', 1,  1,  1603275459, 1603275459),
(22,  'system.menu/index',  '列表', 2,  1,  1603275459, 1603275459),
(23,  'system.menu/add',  '添加', 2,  1,  1603275459, 1603275459),
(24,  'system.menu/edit', '编辑', 2,  1,  1603275459, 1603275459),
(25,  'system.menu/delete', '删除', 2,  1,  1603275459, 1603275459),
(26,  'system.menu/modify', '属性修改', 2,  1,  1603275459, 1603275459),
(27,  'system.menu/getMenuTips',  '添加菜单提示', 2,  1,  1603275459, 1603275459),
(28,  'system.menu/export', '导出', 2,  1,  1603275459, 1603275459),
(29,  'system.node',  '系统节点管理', 1,  1,  1603275459, 1603275459),
(30,  'system.node/index',  '列表', 2,  1,  1603275459, 1603275459),
(31,  'system.node/refreshNode',  '系统节点更新', 2,  1,  1603275459, 1603275459),
(32,  'system.node/clearNode',  '清除失效节点', 2,  1,  1603275459, 1603275459),
(33,  'system.node/add',  '添加', 2,  1,  1603275459, 1603275459),
(34,  'system.node/edit', '编辑', 2,  1,  1603275459, 1603275459),
(35,  'system.node/delete', '删除', 2,  1,  1603275459, 1603275459),
(36,  'system.node/export', '导出', 2,  1,  1603275459, 1603275459),
(37,  'system.node/modify', '属性修改', 2,  1,  1603275459, 1603275459),
(38,  'system.quick', '快捷入口管理', 1,  1,  1603275459, 1603275459),
(39,  'system.quick/index', '列表', 2,  1,  1603275459, 1603275459),
(40,  'system.quick/add', '添加', 2,  1,  1603275459, 1603275459),
(41,  'system.quick/edit',  '编辑', 2,  1,  1603275459, 1603275459),
(42,  'system.quick/delete',  '删除', 2,  1,  1603275459, 1603275459),
(43,  'system.quick/export',  '导出', 2,  1,  1603275459, 1603275459),
(44,  'system.quick/modify',  '属性修改', 2,  1,  1603275459, 1603275459),
(45,  'plugin.index', '插件系统管理', 1,  1,  1603275459, 1603275459),
(46,  'plugin.index/index', '我的插件', 2,  1,  1603275459, 1603275459),
(47,  'plugin.index/install', '安装插件', 2,  1,  1603275459, 1603275459),
(48,  'plugin.index/on',  '开启插件', 2,  1,  1603275459, 1603275459),
(49,  'plugin.index/off', '关闭插件', 2,  1,  1603275459, 1603275459),
(50,  'plugin.index/del', '卸载插件', 2,  1,  1603275459, 1603275459),
(55,  'member.user',  '会员管理', 1,  1,  1603349465, 1603349465),
(56,  'member.user/index',  '列表', 2,  1,  1603349465, 1603349465),
(57,  'member.user/add',  '添加账号', 2,  1,  1603349465, 1603349465),
(58,  'member.user/edit', '编辑账号', 2,  1,  1603349465, 1603349465),
(59,  'member.user/delete', '删除', 2,  1,  1603349465, 1603349465),
(60,  'member.user/export', '导出', 2,  1,  1603349465, 1603349465),
(61,  'member.user/modify', '属性修改', 2,  1,  1603349465, 1603349465),
(62,  'member.user/parent', '修改推荐人',  2,  1,  1603352004, 1603352004),
(63,  'member.user/password', '修改密码', 2,  1,  1603352004, 1603352004),
(64,  'goods.home', '商品管理', 1,  1,  1603433511, 1603433511),
(65,  'goods.home/index', '列表', 2,  1,  1603433511, 1603433511),
(66,  'goods.home/add', '添加', 2,  1,  1603433511, 1603433511),
(70,  'goods.home/modify',  '属性修改', 2,  1,  1603433511, 1603433511),
(71,  'goods.home/edit',  '修改', 2,  1,  1603433511, 1603433511),
(72,  'goods.home/export',  '导出', 2,  1,  1603433511, 1603433511),
(75,  'system.uploadfile',  '上传文件管理', 1,  1,  1603704466, 1603704466),
(76,  'system.uploadfile/delete', '删除', 2,  1,  1603704466, 1603704466),
(77,  'system.uploadfile/index',  '列表', 2,  1,  1603704466, 1603704466),
(78,  'system.uploadfile/add',  '添加', 2,  1,  1603704466, 1603704466),
(79,  'system.uploadfile/edit', '编辑', 2,  1,  1603704466, 1603704466),
(80,  'system.uploadfile/export', '导出', 2,  1,  1603704466, 1603704466),
(81,  'system.uploadfile/modify', '属性修改', 2,  1,  1603704466, 1603704466),
(82,  'goods.dispatch', '配送管理', 1,  1,  1603704466, 1603704466),
(83,  'goods.dispatch/index', '列表', 2,  1,  1603704466, 1603704466),
(84,  'goods.dispatch/add', '添加', 2,  1,  1603704466, 1603704466),
(85,  'goods.dispatch/edit',  '编辑', 2,  1,  1603704466, 1603704466),
(86,  'goods.dispatch/delete',  '删除', 2,  1,  1603704466, 1603704466),
(87,  'goods.dispatch/export',  '导出', 2,  1,  1603704466, 1603704466),
(88,  'goods.dispatch/modify',  '属性修改', 2,  1,  1603704466, 1603704466),
(89,  'order.home', '订单管理', 1,  1,  1604024203, 1604024203),
(90,  'order.home/index', '订单列表', 2,  1,  1604024203, 1604024203),
(96,  'goods.dispatch/data',  '配送逻辑', 2,  1,  1604024203, 1604024203),
(97,  'goods.dispatch/dataedit',  '编辑配送逻辑', 2,  1,  1604024203, 1604024203),
(98,  'goods.dispatch/dataadd', '添加配送逻辑', 2,  1,  1604024203, 1604024203),
(99,  'goods.dispatch/datadelete',  '删除配送逻辑', 2,  1,  1604024203, 1604024203),
(100, 'goods.dispatch/datamodify',  '属性修改配送逻辑', 2,  1,  1604024203, 1604024203),
(103, 'plugin.cloud', '插件云平台',  1,  1,  1606039948, 1606039948),
(104, 'plugin.cloud/index', '云平台',  2,  1,  1606039948, 1606039948),
(106, 'pay.ali_pay',  '商品管理', 1,  1,  1607652399, 1607652399),
(107, 'pay.ali_pay/index',  '列表', 2,  1,  1607652399, 1607652399),
(108, 'pay.ali_pay/add',  '添加', 2,  1,  1607652399, 1607652399),
(109, 'pay.ali_pay/edit', '编辑', 2,  1,  1607652399, 1607652399),
(110, 'pay.ali_pay/delete', '删除', 2,  1,  1607652399, 1607652399),
(111, 'pay.ali_pay/modify', '属性修改', 2,  1,  1607652399, 1607652399),
(112, 'pay.ali_pay/getMenuTips',  '添加菜单提示', 2,  1,  1607652399, 1607652399),
(113, 'pay.ali_pay/export', '导出', 2,  1,  1607652399, 1607652399),
(114, 'pay.wechat_pay', '商品管理', 1,  1,  1607652399, 1607652399),
(115, 'pay.wechat_pay/index', '列表', 2,  1,  1607652399, 1607652399),
(116, 'pay.wechat_pay/add', '添加', 2,  1,  1607652399, 1607652399),
(117, 'pay.wechat_pay/edit',  '编辑', 2,  1,  1607652399, 1607652399),
(118, 'pay.wechat_pay/delete',  '删除', 2,  1,  1607652399, 1607652399),
(119, 'pay.wechat_pay/modify',  '属性修改', 2,  1,  1607652399, 1607652399),
(120, 'pay.wechat_pay/getMenuTips', '添加菜单提示', 2,  1,  1607652399, 1607652399),
(121, 'pay.wechat_pay/export',  '导出', 2,  1,  1607652399, 1607652399),
(122, 'order.order_goods',  NULL, 1,  0,  1607652399, 1610437710),
(123, 'order.order_goods/index',  '订单列表', 2,  1,  1607652399, 1607652399),
(124, 'goods.category', '商品管理', 1,  1,  1607652399, 1607652399),
(125, 'goods.category/index', '列表', 2,  1,  1607652399, 1607652399),
(126, 'goods.category/add', '添加', 2,  1,  1607652399, 1607652399),
(127, 'goods.category/edit',  '编辑', 2,  1,  1607652399, 1607652399),
(128, 'goods.category/delete',  '删除', 2,  1,  1607652399, 1607652399),
(129, 'goods.category/modify',  '属性修改', 2,  1,  1607652399, 1607652399),
(130, 'goods.category/getMenuTips', '添加菜单提示', 2,  1,  1607652399, 1607652399),
(131, 'goods.category/export',  '导出', 2,  1,  1607652399, 1607652399),
(139, 'page.carousel',  '轮播图管理',  1,  1,  1607652994, 1607652994),
(140, 'page.carousel/index',  '列表', 2,  1,  1607652994, 1607652994),
(141, 'page.carousel/add',  '添加', 2,  1,  1607652994, 1607652994),
(142, 'page.carousel/edit', '修改', 2,  1,  1607652994, 1607652994),
(143, 'page.carousel/delete', '删除', 2,  1,  1607652994, 1607652994),
(144, 'page.carousel/export', '导出', 2,  1,  1607652994, 1607652994),
(145, 'page.carousel/modify', '属性修改', 2,  1,  1607652994, 1607652994),
(146, 'page.notice',  '公告管理', 1,  1,  1607652994, 1607652994),
(147, 'page.notice/index',  '列表', 2,  1,  1607652994, 1607652994),
(148, 'page.notice/add',  '添加', 2,  1,  1607652994, 1607652994),
(149, 'page.notice/edit', '修改', 2,  1,  1607652994, 1607652994),
(150, 'page.notice/delete', '删除', 2,  1,  1607652994, 1607652994),
(151, 'page.notice/export', '导出', 2,  1,  1607652994, 1607652994),
(152, 'page.notice/modify', '属性修改', 2,  1,  1607652994, 1607652994),
(153, 'finace.balanceset',  '余额设置', 1,  1,  1608880951, 1608880951),
(154, 'finace.balanceset/edit', '修改', 2,  1,  1608880951, 1608880951),
(155, 'finace.balanceset/index',  '列表', 2,  1,  1608880951, 1608880951),
(156, 'finace.balanceset/add',  '添加', 2,  1,  1608880951, 1608880951),
(157, 'finace.balanceset/delete', '删除', 2,  1,  1608880951, 1608880951),
(158, 'finace.balanceset/export', '导出', 2,  1,  1608880951, 1608880951),
(159, 'finace.balanceset/modify', '属性修改', 2,  1,  1608880951, 1608880951),
(160, 'finace.balancesub',  '余额明细', 1,  1,  1608880951, 1608880951),
(161, 'finace.balancesub/index',  '列表', 2,  1,  1608880951, 1608880951),
(162, 'finace.balancesub/add',  '添加', 2,  1,  1608880951, 1608880951),
(163, 'finace.balancesub/edit', '编辑', 2,  1,  1608880951, 1608880951),
(164, 'finace.balancesub/delete', '删除', 2,  1,  1608880951, 1608880951),
(165, 'finace.balancesub/export', '导出', 2,  1,  1608880951, 1608880951),
(166, 'finace.balancesub/modify', '属性修改', 2,  1,  1608880951, 1608880951),
(167, 'finace.income',  '收入明细', 1,  1,  1608880951, 1608880951),
(168, 'finace.income/index',  '列表', 2,  1,  1608880951, 1608880951),
(169, 'finace.income/add',  '添加', 2,  1,  1608880951, 1608880951),
(170, 'finace.income/edit', '编辑', 2,  1,  1608880951, 1608880951),
(171, 'finace.income/delete', '删除', 2,  1,  1608880951, 1608880951),
(172, 'finace.income/export', '导出', 2,  1,  1608880951, 1608880951),
(173, 'finace.income/modify', '属性修改', 2,  1,  1608880951, 1608880951),
(174, 'finace.upbalance', '充值余额', 1,  1,  1608880951, 1608880951),
(175, 'finace.upbalance/index', '列表', 2,  1,  1608880951, 1608880951),
(176, 'finace.upbalance/edit',  '修改', 2,  1,  1608880951, 1608880951),
(177, 'finace.upbalance/add', '添加', 2,  1,  1608880951, 1608880951),
(178, 'finace.upbalance/delete',  '删除', 2,  1,  1608880951, 1608880951),
(179, 'finace.upbalance/export',  '导出', 2,  1,  1608880951, 1608880951),
(180, 'finace.upbalance/modify',  '属性修改', 2,  1,  1608880951, 1608880951),
(181, 'finace.uprecord',  '充值记录', 1,  1,  1608880951, 1608880951),
(182, 'finace.uprecord/index',  '列表', 2,  1,  1608880951, 1608880951),
(183, 'finace.uprecord/add',  '添加', 2,  1,  1608880951, 1608880951),
(184, 'finace.uprecord/edit', '编辑', 2,  1,  1608880951, 1608880951),
(185, 'finace.uprecord/delete', '删除', 2,  1,  1608880951, 1608880951),
(186, 'finace.uprecord/export', '导出', 2,  1,  1608880951, 1608880951),
(187, 'finace.uprecord/modify', '属性修改', 2,  1,  1608880951, 1608880951),
(188, 'finace.withdrawalrecord',  '用户提现记录', 1,  1,  1608880951, 1608880951),
(189, 'finace.withdrawalrecord/index',  '列表', 2,  1,  1608880951, 1608880951),
(190, 'finace.withdrawalrecord/edit', '修改', 2,  1,  1608880951, 1608880951),
(191, 'finace.withdrawalrecord/add',  '添加', 2,  1,  1608880951, 1608880951),
(192, 'finace.withdrawalrecord/delete', '删除', 2,  1,  1608880951, 1608880951),
(193, 'finace.withdrawalrecord/export', '导出', 2,  1,  1608880951, 1608880951),
(194, 'finace.withdrawalrecord/modify', '属性修改', 2,  1,  1608880951, 1608880951),
(195, 'finace.withdrawset', '提现设置', 1,  1,  1608880951, 1608880951),
(196, 'finace.withdrawset/edit',  '修改', 2,  1,  1608880951, 1608880951),
(197, 'finace.withdrawset/index', '列表', 2,  1,  1608880951, 1608880951),
(198, 'finace.withdrawset/add', '添加', 2,  1,  1608880951, 1608880951),
(199, 'finace.withdrawset/delete',  '删除', 2,  1,  1608880951, 1608880951),
(200, 'finace.withdrawset/export',  '导出', 2,  1,  1608880951, 1608880951),
(201, 'finace.withdrawset/modify',  '属性修改', 2,  1,  1608880951, 1608880951),
(202, 'finace.withdrawsts', '提现统计', 1,  1,  1608880951, 1608880951),
(203, 'finace.withdrawsts/index', '列表', 2,  1,  1608880951, 1608880951),
(204, 'finace.withdrawsts/add', '添加', 2,  1,  1608880951, 1608880951),
(205, 'finace.withdrawsts/edit',  '编辑', 2,  1,  1608880951, 1608880951),
(206, 'finace.withdrawsts/delete',  '删除', 2,  1,  1608880951, 1608880951),
(207, 'finace.withdrawsts/export',  '导出', 2,  1,  1608880951, 1608880951),
(208, 'finace.withdrawsts/modify',  '属性修改', 2,  1,  1608880951, 1608880951),
(209, 'admins.feedback',  '用户回馈', 1,  1,  1608880951, 1608880951),
(210, 'admins.feedback/index',  '列表', 2,  1,  1608880951, 1608880951),
(211, 'admins.feedback/edit', '查看', 2,  1,  1608880951, 1608880951),
(212, 'admins.feedback/add',  '添加', 2,  1,  1608880951, 1608880951),
(213, 'admins.feedback/delete', '删除', 2,  1,  1608880951, 1608880951),
(214, 'admins.feedback/export', '导出', 2,  1,  1608880951, 1608880951),
(215, 'admins.feedback/modify', '属性修改', 2,  1,  1608880951, 1608880951),
(216, 'admins.payment', '线下付款配置', 1,  1,  1608880951, 1608880951),
(217, 'admins.payment/index', '列表', 2,  1,  1608880951, 1608880951),
(218, 'admins.payment/add', '添加', 2,  1,  1608880951, 1608880951),
(219, 'admins.payment/edit',  '修改', 2,  1,  1608880951, 1608880951),
(220, 'admins.payment/delete',  '删除', 2,  1,  1608880951, 1608880951),
(221, 'admins.payment/export',  '导出', 2,  1,  1608880951, 1608880951),
(222, 'admins.payment/modify',  '属性修改', 2,  1,  1608880951, 1608880951),
(227, 'order.order_refund', '订单退款', 1,  1,  1609039921, 1609039921),
(228, 'order.order_refund/index', '退款列表', 2,  1,  1609039921, 1609039921),
(229, 'order.order_refund/edit',  '审核退款', 2,  1,  1610437691, 1610437691),
(230, 'goods.home/delete',  '删除', 2,  1,  1610437691, 1610437691),
(385, 'member.transfer_credit', '积分管理', 1,  1,  1613898342, 1613898342),
(386, 'member.transfer_credit/index', '列表', 2,  1,  1613898342, 1613898342),
(387, 'member.transfer_credit/credit_set',  '提现配置', 2,  1,  1613898342, 1613898342),
(388, 'member.transfer_credit/modify',  '属性修改', 2,  1,  1613898342, 1613898342),
(389, 'member.transfer_credit/list',  '数据列表', 2,  1,  1613898342, 1613898342),
(390, 'member.transfer_credit/add', '添加', 2,  1,  1613898342, 1613898342),
(391, 'member.transfer_credit/edit',  '编辑', 2,  1,  1613898342, 1613898342),
(392, 'member.transfer_credit/delete',  '删除', 2,  1,  1613898342, 1613898342),
(393, 'member.transfer_credit/export',  '导出', 2,  1,  1613898342, 1613898342),
(394, 'member.user/recharge_balance', '修改', 2,  1,  1613898342, 1613898342),
(395, 'finace.offlinepayment',  '线下收款记录', 1,  1,  1613898342, 1613898342),
(396, 'finace.offlinepayment/index',  '列表', 2,  1,  1613898342, 1613898342),
(397, 'finace.offlinepayment/edit', '查看', 2,  1,  1613898342, 1613898342),
(398, 'finace.offlinepayment/add',  '添加', 2,  1,  1613898342, 1613898342),
(399, 'finace.offlinepayment/delete', '删除', 2,  1,  1613898342, 1613898342),
(400, 'finace.offlinepayment/export', '导出', 2,  1,  1613898342, 1613898342),
(401, 'finace.offlinepayment/modify', '属性修改', 2,  1,  1613898342, 1613898342),
(402, 'finace.offlinewithdrawals',  '线下提现记录', 1,  1,  1613898342, 1613898342),
(403, 'finace.offlinewithdrawals/index',  '列表', 2,  1,  1613898342, 1613898342),
(404, 'finace.offlinewithdrawals/edit', '修改', 2,  1,  1613898342, 1613898342),
(405, 'finace.offlinewithdrawals/add',  '添加', 2,  1,  1613898342, 1613898342),
(406, 'finace.offlinewithdrawals/delete', '删除', 2,  1,  1613898342, 1613898342),
(407, 'finace.offlinewithdrawals/export', '导出', 2,  1,  1613898342, 1613898342),
(408, 'finace.offlinewithdrawals/modify', '属性修改', 2,  1,  1613898342, 1613898342),
(455, 'order.home/edit',  '订单编辑', 2,  1,  1614067155, 1614067155),
(456, 'order.home/batch_delivery',  '获取批量发货模版', 2,  1,  1614067155, 1614067155),
(457, 'order.home/receive_money', '确认收款', 2,  1,  1614067155, 1614067155),
(458, 'order.home/send_goods',  '发货', 2,  1,  1614067155, 1614067155),
(459, 'order.home/receive_goods', '确认收货', 2,  1,  1614067155, 1614067155),
(460, 'order.home/refund_order',  '退款订单', 2,  1,  1614067155, 1614067155),
(461, 'order.home/apply_cancel',  '申请退款', 2,  1,  1614067155, 1614067155),
(462, 'order.home/batch_delivery_data', '批量发货', 2,  1,  1614067155, 1614067155),
(493, 'order.home/export',  '导出', 2,  1,  1614236650, 1614236650),
(494, 'admins.feedbackset', '反馈黑名单',  1,  1,  1614236650, 1614236650),
(495, 'admins.feedbackset/index', '反馈黑名单列表',  2,  1,  1614236650, 1614236650),
(496, 'admins.feedbackset/add', '反馈黑名单添加',  2,  1,  1614236650, 1614236650),
(497, 'admins.feedbackset/edit',  '编辑', 2,  1,  1614236650, 1614236650),
(498, 'admins.feedbackset/delete',  '删除', 2,  1,  1614236650, 1614236650),
(499, 'admins.feedbackset/export',  '导出', 2,  1,  1614236650, 1614236650),
(500, 'admins.feedbackset/modify',  '属性修改', 2,  1,  1614236650, 1614236650),
(501, 'plugin', '插件开启权限', 1,  1,  1614236650, 1614236650),
(502, 'plugin/default', '插件详情', 2,  1,  1614236650, 1614236650),
(503, 'plugin/call',  '插件HOOK', 2,  1,  1614236650, 1614236650),
(530, 'system.log', '操作日志管理', 1,  1,  1614995754, 1614995754),
(531, 'system.log/index', '列表', 2,  1,  1614995754, 1614995754),
(532, 'plugin.index/update_dir',  '更新本地插件', 2,  1,  1614995754, 1614995754),
(606, 'pay.pay_type', '支付开关', 1,  1,  1615291082, 1615291082),
(607, 'pay.pay_type/index', '支付开关列表', 2,  1,  1615291082, 1615291082),
(608, 'pay.pay_type/edit',  '编辑', 2,  1,  1615291082, 1615291082),
(609, 'pay.pay_type/delete',  '删除', 2,  1,  1615291082, 1615291082),
(610, 'pay.pay_type/modify',  '属性修改', 2,  1,  1615291082, 1615291082),
(611, 'pay.pay_type/getMenuTips', '添加菜单提示', 2,  1,  1615291082, 1615291082),
(612, 'pay.pay_type/add', '添加', 2,  1,  1615291082, 1615291082),
(613, 'pay.pay_type/export',  '导出', 2,  1,  1615291082, 1615291082),
(614, 'order.home/cancel_order',  '取消订单', 2,  1,  1615291082, 1615291082),
(615, 'plugins.hasog_app-index-index',  'APP下载配置',  1,  1,  1615354500, 1615354500),
(616, 'plugins.hasog_app-index-index/index',  'APP下载',  2,  1,  1615354500, 1615354500),
(617, 'page.navigation',  '导航管理', 1,  1,  1615362649, 1615362649),
(618, 'page.navigation/index',  '导航管理列表', 2,  1,  1615362649, 1615362649),
(619, 'page.navigation/add',  '导航管理添加', 2,  1,  1615362649, 1615362649),
(620, 'page.navigation/edit', '导航管理修改', 2,  1,  1615362649, 1615362649),
(621, 'page.navigation/delete', '删除', 2,  1,  1615362649, 1615362649),
(622, 'page.navigation/export', '导出', 2,  1,  1615362649, 1615362649),
(623, 'page.navigation/modify', '属性修改', 2,  1,  1615362649, 1615362649)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `node` = VALUES(`node`), `title` = VALUES(`title`), `type` = VALUES(`type`), `is_auth` = VALUES(`is_auth`), `create_time` = VALUES(`create_time`), `update_time` = VALUES(`update_time`);
ETO;
$this->insertTable($tableName,$Sql);


  } catch (\Throwable $e) {
      return false;
  }
  return true;

    }

}