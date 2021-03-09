# 还在开发中！预计3月15日发布1.0.0 Bate版！



# HaSog（幻神商城系统）

HaSog（全名 幻神商城）是基于TP6  开发的一套高扩展的社交电商分销系统。

原有公司项目运营2年，遇到了无数的难题和痛点，此项目专为解决目前公司项目的痛点进行重新开发！并新加了很多特性！

公司原有项目已经运营4年，很多需求在市面上都无法得到满足，此项目的设计理念较为奇特。




> 立项于 2020-10-13日，预计登录平台为：H5 + APP + 小程序（微信 QQ 百度 等..）。
>
> 开源！开源！开源！开源！
>
> 原名叫 AcShop 更名为 HaSog系统
>
> [![HaSog](https://img.shields.io/badge/license-AGPL--3.0-blue)](https://www.hasog.com)
> [![HaSog](https://img.shields.io/badge/HaSog-开发中-brightgreen)](https://www.hasog.com)
> [![star](https://gitee.com/orzice/hasog/badge/star.svg?theme=dark)](https://gitee.com/orzice/hasog/stargazers)
> [![fork](https://gitee.com/orzice/hasog/badge/fork.svg?theme=dark)](https://gitee.com/orzice/hasog/members)
> 
> Gitee : https://gitee.com/orzice/hasog
> 
> Github : https://github.com/orzice/hasog
> 
> 幻神科技：https://www.hasog.com
> 
> 





## [添加微信群]

幻神商城系统体验官

![](wxq.png)

扫码添加 幻神商城系统体验官微信群！给我们提需求！我们会做得更好！




## [开发团队]

>  开发公司：幻神科技 https://www.hasog.com
>
>  负责人/主程：Orzice/小涛（吴英涛）
>
> 后端开发：梗集（王国骁） ，王火火（王琰豪）
>
> 前端开发：慵懒与猫（孙敬冉），M-A-O（张帆）
>
> UI设计：潮鳴り（姚羽）

## [开始安装]



### 1. 运行环境要求

> 后端技术栈：PHP7.2 + Redis + Mysql + Nginx 
>
> 前端技术栈： Vue.js + uni-app

后台管理页部分代码参考 easyadmin



[队列]

```
php think queue:work --sleep=3 --tries=3
```

[计划任务]

```
php think cron
```

[Nginx配置]

```
if (!-e $request_filename) {
	rewrite  ^(.*)$  /index.php?s=/$1  last;
}
```



### 2.一键安装






## [常见问题]



### 1. 不能注册，提示 没有默认值【需修改Mysql配置】

```
sql-mode=NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES

改为↓
sql-mode=NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
```








## [项目实例]

### 1. 商城系统
![](lz.jpg)


### 2. 拼团抽奖系统

![](lz_pt.jpg)



## [企划]（挖坑）

- 云端附件支持（本地，阿里云，七牛云.....）

- 更简易的计划任务系统。

- 更高效的队列系统。

- 核心代码只做核心功能，以便以二次开发。

- 更强大的插件功能 （核心代码只做核心功能！其他就交给插件来做！）

- 可支持打包 为 APP！

- 可支持打包 为 小程序（微信，QQ，头条，抖音，百度）！

- 部分代码使用Go语言重写（高并发以及中间件，后期才会做）

- 齐全的支付模块！微信支付，支付宝支付，（H5支付，APP支付，微信内支付，扫码支付）

- 多种支付方式！且可以随意切换！

- 精确到街道的发货逻辑！

- 更加安全的结构！

- 可以自定义界面！每个平台都可自定义！

- 订单发货可以多个快递号！

  

## [特性]

### 简洁高效

HaSog 是开源的、轻巧高效的，源码是透明的。
默认最小化程序安装，轻装上阵



### 安全稳定

安全稳定与优秀的用户体验是我们不断的追求，



### 高扩展性

扩展性一直是 HaSog 注重的功能之一，
HaSog  提供丰富灵活的模块扩展软件支持，用户按需下载安装软件，扩展功能。
同时 HaSog  用户也可以应需求自主开发功能支持。
后续 HaSog  官方会计划推出更多企业级应用扩展程序支持，敬请期待。







## [已知缺陷]

- 前端文件因为可以分平台自定义展现，导致性能较低。
- 所有URL资源请求都要过滤，虽然加强了安全，但是导致性能较低。
- 为了让插件更加自由，所以插件不会判断是否登录！请不要安装不明来源的插件！以免系统出现问题！
- 系统对于插件较为开放，不要随意修改插件代码！不要安装不明来源的插件！一旦有一个插件崩溃，整个系统都会崩溃！

