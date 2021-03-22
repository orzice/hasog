<?php
/*
 * Copyright (c) 2017-2018 THL A29 Limited, a Tencent company. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace TencentCloud\Lighthouse\V20200324;

use TencentCloud\Common\AbstractClient;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Credential;
use TencentCloud\Lighthouse\V20200324\Models as Models;

/**
 * @method Models\CreateFirewallRulesResponse CreateFirewallRules(Models\CreateFirewallRulesRequest $req) 本接口（CreateFirewallRules）用于在实例上添加防火墙规则。


* FirewallVersion 为防火墙版本号，用户每次更新防火墙规则版本会自动加1，防止您更新的规则已过期，不填不考虑冲突。

在 FirewallRules 参数中：
* Protocol 字段支持输入 TCP，UDP，ICMP，ALL。
* Port 字段允许输入 ALL，或者一个单独的端口号，或者用逗号分隔的离散端口号，或者用减号分隔的两个端口号代表的端口范围。当 Port 为范围时，减号分隔的第一个端口号小于第二个端口号。当 Protocol 字段不是 TCP 或 UDP 时，Port 字段只能为空或 ALL。Port 字段长度不得超过 64。
* CidrBlock 字段允许输入符合 cidr 格式标准的任意字符串。租户之间网络隔离规则优先于防火墙中的内网规则。
* Action 字段只允许输入 ACCEPT 或 DROP。
* FirewallRuleDescription 字段长度不得超过 64。
 * @method Models\DeleteFirewallRulesResponse DeleteFirewallRules(Models\DeleteFirewallRulesRequest $req) 本接口（DeleteFirewallRules）用于删除实例的防火墙规则。

* FirewallVersion 用于指定要操作的防火墙的版本。传入 FirewallVersion 版本号若不等于当前防火墙的最新版本，将返回失败；若不传 FirewallVersion 则直接删除指定的规则。

在 FirewallRules 参数中：
* Protocol 字段支持输入 TCP，UDP，ICMP，ALL。
* Port 字段允许输入 ALL，或者一个单独的端口号，或者用逗号分隔的离散端口号，或者用减号分隔的两个端口号代表的端口范围。当 Port 为范围时，减号分隔的第一个端口号小于第二个端口号。当 Protocol 字段不是 TCP 或 UDP 时，Port 字段只能为空或 ALL。Port 字段长度不得超过 64。
* CidrBlock 字段允许输入符合 cidr 格式标准的任意字符串。租户之间网络隔离规则优先于防火墙中的内网规则。
* Action 字段只允许输入 ACCEPT 或 DROP。
* FirewallRuleDescription 字段长度不得超过 64。
 * @method Models\DescribeBlueprintsResponse DescribeBlueprints(Models\DescribeBlueprintsRequest $req) 本接口（DescribeBlueprints）用于查询镜像信息。
 * @method Models\DescribeBundlesResponse DescribeBundles(Models\DescribeBundlesRequest $req) 本接口（DescribeBundles）用于查询套餐信息。
 * @method Models\DescribeFirewallRulesResponse DescribeFirewallRules(Models\DescribeFirewallRulesRequest $req) 本接口（DescribeFirewallRules）用于查询实例的防火墙规则。
 * @method Models\DescribeInstancesResponse DescribeInstances(Models\DescribeInstancesRequest $req) 本接口（DescribeInstances）用于查询一个或多个实例的详细信息。

* 可以根据实例 ID、实例名称或者实例的内网 IP 查询实例的详细信息。
* 过滤信息详细请见过滤器 [Filters](https://cloud.tencent.com/document/product/1207/47576#Filter) 。
* 如果参数为空，返回当前用户一定数量（Limit 所指定的数量，默认为 20）的实例。
* 支持查询实例的最新操作（LatestOperation）以及最新操作状态（LatestOperationState）。
 * @method Models\DescribeInstancesTrafficPackagesResponse DescribeInstancesTrafficPackages(Models\DescribeInstancesTrafficPackagesRequest $req) 本接口（DescribeInstancesTrafficPackages）用于查询一个或多个实例的流量包详情。
 * @method Models\RebootInstancesResponse RebootInstances(Models\RebootInstancesRequest $req) 本接口（RebootInstances）用于重启实例。

* 只有状态为 RUNNING 的实例才可以进行此操作。
* 接口调用成功时，实例会进入 REBOOTING 状态；重启实例成功时，实例会进入 RUNNING 状态。
* 支持批量操作，每次请求批量实例的上限为 100。
* 本接口为异步接口，请求发送成功后会返回一个 RequestId，此时操作并未立即完成。实例操作结果可以通过调用 DescribeInstances 接口查询，如果实例的最新操作状态（LatestOperationState）为“SUCCESS”，则代表操作成功。
 * @method Models\ResetInstanceResponse ResetInstance(Models\ResetInstanceRequest $req) 本接口（ResetInstance）用于重装指定实例上的镜像。

* 如果指定了 BlueprintId 参数，则使用指定的镜像重装；否则按照当前实例使用的镜像进行重装。
* 系统盘将会被格式化，并重置；请确保系统盘中无重要文件。
* 目前不支持实例使用该接口实现 LINUX_UNIX 和 WINDOWS 操作系统切换。
* 本接口为异步接口，请求发送成功后会返回一个 RequestId，此时操作并未立即完成。实例操作结果可以通过调用 DescribeInstances 接口查询，如果实例的最新操作状态（LatestOperationState）为“SUCCESS”，则代表操作成功。
 * @method Models\StartInstancesResponse StartInstances(Models\StartInstancesRequest $req) 本接口（StartInstances）用于启动一个或多个实例。

* 只有状态为 STOPPED 的实例才可以进行此操作。
* 接口调用成功时，实例会进入 STARTING 状态；启动实例成功时，实例会进入 RUNNING 状态。
* 支持批量操作。每次请求批量实例的上限为 100。
* 本接口为异步接口，请求发送成功后会返回一个 RequestId，此时操作并未立即完成。实例操作结果可以通过调用 DescribeInstances 接口查询，如果实例的最新操作状态（LatestOperationState）为“SUCCESS”，则代表操作成功。
 * @method Models\StopInstancesResponse StopInstances(Models\StopInstancesRequest $req) 本接口（StopInstances）用于关闭一个或多个实例。
* 只有状态为 RUNNING 的实例才可以进行此操作。
* 接口调用成功时，实例会进入 STOPPING 状态；关闭实例成功时，实例会进入 STOPPED 状态。
* 支持批量操作。每次请求批量实例的上限为 100。
* 本接口为异步接口，请求发送成功后会返回一个 RequestId，此时操作并未立即完成。实例操作结果可以通过调用 DescribeInstances 接口查询，如果实例的最新操作状态（LatestOperationState）为“SUCCESS”，则代表操作成功。
 */

class LighthouseClient extends AbstractClient
{
    /**
     * @var string
     */
    protected $endpoint = "lighthouse.tencentcloudapi.com";

    /**
     * @var string
     */
    protected $service = "lighthouse";

    /**
     * @var string
     */
    protected $version = "2020-03-24";

    /**
     * @param Credential $credential
     * @param string $region
     * @param ClientProfile|null $profile
     * @throws TencentCloudSDKException
     */
    function __construct($credential, $region, $profile=null)
    {
        parent::__construct($this->endpoint, $this->version, $credential, $region, $profile);
    }

    public function returnResponse($action, $response)
    {
        $respClass = "TencentCloud"."\\".ucfirst("lighthouse")."\\"."V20200324\\Models"."\\".ucfirst($action)."Response";
        $obj = new $respClass();
        $obj->deserialize($response);
        return $obj;
    }
}
