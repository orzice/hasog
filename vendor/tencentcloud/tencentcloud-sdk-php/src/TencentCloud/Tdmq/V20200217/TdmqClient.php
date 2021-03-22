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

namespace TencentCloud\Tdmq\V20200217;

use TencentCloud\Common\AbstractClient;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Credential;
use TencentCloud\Tdmq\V20200217\Models as Models;

/**
 * @method Models\CreateClusterResponse CreateCluster(Models\CreateClusterRequest $req) 创建用户的集群
 * @method Models\CreateEnvironmentResponse CreateEnvironment(Models\CreateEnvironmentRequest $req) 用于在用户账户下创建消息队列 Tdmq 命名空间
 * @method Models\CreateSubscriptionResponse CreateSubscription(Models\CreateSubscriptionRequest $req) 创建一个主题的订阅关系
 * @method Models\CreateTopicResponse CreateTopic(Models\CreateTopicRequest $req) 新增指定分区、类型的消息主题
 * @method Models\DeleteClusterResponse DeleteCluster(Models\DeleteClusterRequest $req) 删除集群
 * @method Models\DeleteEnvironmentsResponse DeleteEnvironments(Models\DeleteEnvironmentsRequest $req) 批量删除租户下的命名空间
 * @method Models\DeleteSubscriptionsResponse DeleteSubscriptions(Models\DeleteSubscriptionsRequest $req) 删除订阅关系
 * @method Models\DeleteTopicsResponse DeleteTopics(Models\DeleteTopicsRequest $req) 批量删除topics
 * @method Models\DescribeBindClustersResponse DescribeBindClusters(Models\DescribeBindClustersRequest $req) 获取用户绑定的专享集群列表
 * @method Models\DescribeBindVpcsResponse DescribeBindVpcs(Models\DescribeBindVpcsRequest $req) 获取租户VPC绑定关系
 * @method Models\DescribeClusterDetailResponse DescribeClusterDetail(Models\DescribeClusterDetailRequest $req) 获取集群的详细信息
 * @method Models\DescribeClustersResponse DescribeClusters(Models\DescribeClustersRequest $req) 获取集群列表
 * @method Models\DescribeEnvironmentAttributesResponse DescribeEnvironmentAttributes(Models\DescribeEnvironmentAttributesRequest $req) 获取指定命名空间的属性
 * @method Models\DescribeEnvironmentRolesResponse DescribeEnvironmentRoles(Models\DescribeEnvironmentRolesRequest $req) 获取命名空间角色列表
 * @method Models\DescribeEnvironmentsResponse DescribeEnvironments(Models\DescribeEnvironmentsRequest $req) 获取租户下命名空间列表
 * @method Models\DescribeProducersResponse DescribeProducers(Models\DescribeProducersRequest $req) 获取生产者列表，仅显示在线的生产者
 * @method Models\DescribeSubscriptionsResponse DescribeSubscriptions(Models\DescribeSubscriptionsRequest $req) 查询指定环境和主题下的订阅者列表
 * @method Models\DescribeTopicsResponse DescribeTopics(Models\DescribeTopicsRequest $req) 获取环境下主题列表
 * @method Models\ModifyClusterResponse ModifyCluster(Models\ModifyClusterRequest $req) 更新集群信息
 * @method Models\ModifyEnvironmentAttributesResponse ModifyEnvironmentAttributes(Models\ModifyEnvironmentAttributesRequest $req) 修改指定命名空间的属性值
 * @method Models\ModifyTopicResponse ModifyTopic(Models\ModifyTopicRequest $req) 修改主题备注和分区数
 * @method Models\ResetMsgSubOffsetByTimestampResponse ResetMsgSubOffsetByTimestamp(Models\ResetMsgSubOffsetByTimestampRequest $req) 根据时间戳进行消息回溯，精确到毫秒
 * @method Models\SendBatchMessagesResponse SendBatchMessages(Models\SendBatchMessagesRequest $req) 批量发送消息
 * @method Models\SendMessagesResponse SendMessages(Models\SendMessagesRequest $req) 发送单条消息
 */

class TdmqClient extends AbstractClient
{
    /**
     * @var string
     */
    protected $endpoint = "tdmq.tencentcloudapi.com";

    /**
     * @var string
     */
    protected $service = "tdmq";

    /**
     * @var string
     */
    protected $version = "2020-02-17";

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
        $respClass = "TencentCloud"."\\".ucfirst("tdmq")."\\"."V20200217\\Models"."\\".ucfirst($action)."Response";
        $obj = new $respClass();
        $obj->deserialize($response);
        return $obj;
    }
}
