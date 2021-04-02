<h1 align="center">HaSog幻神商城</h1>

<p align="center">
<a href="https://www.hasog.com"><img src="https://img.shields.io/badge/license-Apache--2.0-blue" alt=" Apache-2.0"></a>
<a href='https://gitee.com/orzice/hasog/stargazers'><img src='https://gitee.com/orzice/hasog/badge/star.svg?theme=dark' alt='star'></img></a>
<a href="https://gitee.com/orzice/hasog/members"><img src="https://gitee.com/orzice/hasog/badge/fork.svg?theme=dark" alt="fork"></a>
</p>


原有项目运营2年，遇到了无数的难题和痛点，苦于市面上并没有相似需求的项目，此项目专为解决需求痛点进行重新开发！加了很多新特性！基于 Tp6 开发的一个商城系统，适合刚起步的创业型公司。
一个高扩展性且十分轻便的开源分销商城系统，以实际运营者的角度进行开发，已覆盖 PC、H5、APP、小程序（微信、QQ），内置云平台，随意定制功能，可在线升级版本、在线安装/更新插件，内置HTTP请求处理，随时更改前端页面！软件内置防火墙（开发中）防注入！更加安全！

**！！ 1.0.0正式版已发布，如发现错误请通过反馈群立即反馈！！**

欢迎 Star！


问题反馈请 [传送至这里](https://www.hasog.com)

**开源 免费**

码云  [https://gitee.com/orzice/hasog](https://gitee.com/orzice/hasog)

Github  [https://github.com/orzice/hasog](https://github.com/orzice/hasog)



用户手册：https://www.kancloud.cn/hasog_cloud/hasog



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

## 一键安装

部署后访问自己的域名即可 如：

```shell
www.a.com/Install
```
**请牢记加密配置！每次均为随机生成！安装后请务必保存！**
![](https://images.gitee.com/uploads/images/2021/0310/140035_ca96d7cf_813605.png)

## 云平台
我们将通过云平台对软件进行：在线升级系统、修复BUG、发送公告、在线安装/升级 插件、在线安装/升级 前端界面、提供商业授权服务。


### 注册云平台

访问 插件 -》 幻神云平台 ，点进去即可，系统会自动进行注册和登录。

**注意：本地环境无效！**


![enter image description here](https://images.gitee.com/uploads/images/2021/0402/101053_ff9612cb_813605.png "QQ截图20210402100941.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/101102_48671c7c_813605.png "QQ截图20210402101004.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/101119_71a6f159_813605.png "QQ截图20210402101036.png")

### 在线升级最新版本

使用管理员用户登录（UID：1）访问首页，点击立即更新，即可。

**注意：不要关闭升级网页！如果白屏或者卡着不动了！刷新页面然后重新进行升级！（不影响）**

**注意：升级中不会影响到当前项目的运行！仅在升级完成后会自动替换版本！**

**注意：该功能只能是已注册云平台的用户才可以使用！注册方式 -》插件 -》幻神云平台 点进去即可（本地无法使用哟）**



![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113147_e9c5afaa_813605.png "1.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113156_a068aa36_813605.png "2.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113207_23ba6879_813605.png "3.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113213_a82b8f62_813605.png "4.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0322/113220_b20bda6e_813605.png "5.png")


### 在线安装 插件/前端

首次安装版本时，不带前端文件！需要通过云平台进行下载安装定制！

**注意：不要关闭升级网页！如果白屏或者卡着不动了！刷新页面然后重新进行升级！（不影响）**

**注意：升级中不会影响到当前项目的运行！仅在升级完成后会自动替换版本！**

**注意：该功能只能是已注册云平台的用户才可以使用！注册方式 -》插件 -》幻神云平台 点进去即可（本地无法使用哟）**

![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095824_6b932e4c_813605.png "1.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095850_1e8a3e34_813605.png "2.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095857_ff269608_813605.png "3.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095905_9df03916_813605.png "4.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095913_8d3deb52_813605.png "5.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095938_a0592c90_813605.png "6.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095945_510a3674_813605.png "7.png")
![enter image description here](https://images.gitee.com/uploads/images/2021/0402/095951_63f8ebf7_813605.png "8.png")



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

