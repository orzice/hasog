<h1 align="center">HaSog幻神商城</h1>

<p align="center">
<a href="https://www.hasog.com"><img src="https://img.shields.io/badge/license-AGPL--3.0-blue" alt="AGPL"></a>
<a href="https://www.hasog.com"><img src="https://img.shields.io/badge/HaSog-开发中-brightgreen" alt="badge"></a>
<a href="https://gitee.com/orzice/hasog/members"><img src="https://gitee.com/orzice/hasog/badge/fork.svg?theme=dark" alt="fork"></a>
</p>


原有项目运营2年，遇到了无数的难题和痛点，苦于市面上并没有相似需求的项目，此项目专为解决需求痛点进行重新开发！加了很多新特性！基于 Tp6 开发的一个商城系统，适合刚起步的创业型公司。
一个高扩展性且十分轻便的开源分销商城系统，以实际运营者的角度进行开发，已覆盖 PC、H5、APP、小程序（微信、QQ），内置HTTP请求处理，随时更改前端页面！软件内置防火墙（开发中）防注入！更加安全！

**！！ 目前是 Bate版，如发现错误请通过反馈群立即反馈！！**

欢迎 Star！


问题反馈请 [传送至这里](https://www.hasog.com)

**开源**

码云  [https://gitee.com/orzice/hasog](https://gitee.com/orzice/hasog)

Github  [https://github.com/orzice/hasog](https://github.com/orzice/hasog)



**QQ交流群（点击加群）：**[372193289](https://jq.qq.com/?_wv=1027&k=MOx0H0EK)
![](https://images.gitee.com/uploads/images/2021/0310/175719_a49cdd9b_813605.jpeg)


**微信交流群**

![](https://images.gitee.com/uploads/images/2021/0310/135948_0e426530_813605.png)

## 开发团队
>  开发公司：幻神科技 https://www.hasog.com
>  
>  负责人/主程：Orzice/小涛（吴英涛）
>  
> 后端开发：梗集（王国骁） ，王火火（王琰豪）
> 
> 前端开发：慵懒与猫（孙敬冉），M-A-O（张帆）
> 
> UI设计：潮鳴り（姚羽）
> 

## 特点
- 核心代码只做核心功能，拒绝乱七八糟！
- 更强大的插件功能
- 可支持打包 为 APP
- 可支持打包 为 小程序（微信，QQ，头条，抖音，百度）
- 多种支付方式随意切换（微信支付，支付宝支付，APP支付，线下付款，收款码转账支付）
- 精确到街道且更加强大的发货逻辑（如：禁止某村发货，2个地区运费不同）
- 更加安全的结构，项目内置HTTP请求解析，软件内置防火墙
- 千人千面，每个人都可以定制自己的首页！


## 运行环境
- PHP 7.2+
- Mysql 5.6 + （必须支持InnoDB）
- Redis



计划任务

> php think cron

队列

> php think queue:work --sleep=3 --tries=3

伪静态
```
 if (!-e $request_filename) {
	rewrite  ^(.*)$  /index.php?s=/$1  last;
}
```

## 安装

部署后访问自己的域名即可 如：

```shell
www.a.com/Install
```
**请牢记加密配置！每次均为随机生成！安装后请务必保存！**
![](https://images.gitee.com/uploads/images/2021/0310/140035_ca96d7cf_813605.png)

## 在线升级

使用管理员用户登录（UID：1）访问首页，点击立即更新，即可。

**注意：不要关闭升级网页！如果白屏或者卡着不动了！刷新页面然后重新进行升级！（不影响）**

**注意：升级中不会影响到当前项目的运行！仅在升级完成后会自动替换版本！**

**注意：该功能只能是已注册云平台的用户才可以使用！注册方式 -》插件 -》幻神云平台 点进去即可（本地无法使用哟）**




![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113147_e9c5afaa_813605.png "1.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113156_a068aa36_813605.png "2.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113207_23ba6879_813605.png "3.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113213_a82b8f62_813605.png "4.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113220_b20bda6e_813605.png "5.png")

## 未完善功能

有些功能还未完善

- **支付宝支付**

项目时间太紧，所以支付宝支付暂且延后，延迟到1.0.1 BeTa  版本进行更新。

- **高并发相关问题**

时间原因，高并发问题暂时没有解决，也会在1.0.1 BeTa 版本进行更新。

- **前端DIY**

这个会在1.0.2 BeTa 版本进行上线。

- **云平台**

这个会在1.0.0 正式版，进行更新。



## 使用说明

更新中...



## 项目实例
在这里展示已经上线的例子

###  正常商城系统
![](https://images.gitee.com/uploads/images/2021/0310/140137_3e4de280_813605.jpeg)


### 拼团抽奖系统

![](https://images.gitee.com/uploads/images/2021/0310/140202_a35e2ce5_813605.jpeg)



## 常见异常



### 1. 不能注册，提示 没有默认值，Mysql相关。

```
Mysql配置，一般宝塔面板会出现这个问题。

sql-mode=NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES
改为↓
sql-mode=NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
```





### 2. 提示 服务器积极拒绝

```
请启动 Redis
```



### 3. 使用OSS无法上传提示SSL

```
RequestCoreException: cURL resource: Resource id #130; cURL error: SSL certificate problem: unable to get local issuer certificate (60)
```

**解决方案1**

在使用阿里云OSS上传文件的时候报上述错误。

下载证书：https://curl.haxx.se/ca/cacert.pem

**修改php.ini**

```
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo=/path/cacert.pem
```

**解决方案2**

```
vendor\aliyuncs\oss-sdk-php\src\OSS\Http\RequestCore.php

160行 改为 false
```

