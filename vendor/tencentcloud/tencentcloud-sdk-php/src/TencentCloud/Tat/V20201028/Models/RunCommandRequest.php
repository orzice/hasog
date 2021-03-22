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
namespace TencentCloud\Tat\V20201028\Models;
use TencentCloud\Common\AbstractModel;

/**
 * RunCommand请求参数结构体
 *
 * @method string getContent() 获取Base64编码后的命令内容，长度不可超过64KB。
 * @method void setContent(string $Content) 设置Base64编码后的命令内容，长度不可超过64KB。
 * @method array getInstanceIds() 获取待执行命令的实例ID列表。 支持实例类型：
<li> CVM
<li> LIGHTHOUSE
 * @method void setInstanceIds(array $InstanceIds) 设置待执行命令的实例ID列表。 支持实例类型：
<li> CVM
<li> LIGHTHOUSE
 * @method string getCommandName() 获取命令名称。名称仅支持中文、英文、数字、下划线、分隔符"-"、小数点，最大长度不能超60个字节。
 * @method void setCommandName(string $CommandName) 设置命令名称。名称仅支持中文、英文、数字、下划线、分隔符"-"、小数点，最大长度不能超60个字节。
 * @method string getDescription() 获取命令描述。不超过120字符。
 * @method void setDescription(string $Description) 设置命令描述。不超过120字符。
 * @method string getCommandType() 获取命令类型，目前仅支持取值：SHELL。默认：SHELL。
 * @method void setCommandType(string $CommandType) 设置命令类型，目前仅支持取值：SHELL。默认：SHELL。
 * @method string getWorkingDirectory() 获取命令执行路径，默认：/root。
 * @method void setWorkingDirectory(string $WorkingDirectory) 设置命令执行路径，默认：/root。
 * @method integer getTimeout() 获取命令超时时间，默认60秒。取值范围[1, 86400]。
 * @method void setTimeout(integer $Timeout) 设置命令超时时间，默认60秒。取值范围[1, 86400]。
 * @method boolean getSaveCommand() 获取是否保存命令，取值范围：
<li> True：保存
<li> False：不保存
默认为 False。
 * @method void setSaveCommand(boolean $SaveCommand) 设置是否保存命令，取值范围：
<li> True：保存
<li> False：不保存
默认为 False。
 */
class RunCommandRequest extends AbstractModel
{
    /**
     * @var string Base64编码后的命令内容，长度不可超过64KB。
     */
    public $Content;

    /**
     * @var array 待执行命令的实例ID列表。 支持实例类型：
<li> CVM
<li> LIGHTHOUSE
     */
    public $InstanceIds;

    /**
     * @var string 命令名称。名称仅支持中文、英文、数字、下划线、分隔符"-"、小数点，最大长度不能超60个字节。
     */
    public $CommandName;

    /**
     * @var string 命令描述。不超过120字符。
     */
    public $Description;

    /**
     * @var string 命令类型，目前仅支持取值：SHELL。默认：SHELL。
     */
    public $CommandType;

    /**
     * @var string 命令执行路径，默认：/root。
     */
    public $WorkingDirectory;

    /**
     * @var integer 命令超时时间，默认60秒。取值范围[1, 86400]。
     */
    public $Timeout;

    /**
     * @var boolean 是否保存命令，取值范围：
<li> True：保存
<li> False：不保存
默认为 False。
     */
    public $SaveCommand;

    /**
     * @param string $Content Base64编码后的命令内容，长度不可超过64KB。
     * @param array $InstanceIds 待执行命令的实例ID列表。 支持实例类型：
<li> CVM
<li> LIGHTHOUSE
     * @param string $CommandName 命令名称。名称仅支持中文、英文、数字、下划线、分隔符"-"、小数点，最大长度不能超60个字节。
     * @param string $Description 命令描述。不超过120字符。
     * @param string $CommandType 命令类型，目前仅支持取值：SHELL。默认：SHELL。
     * @param string $WorkingDirectory 命令执行路径，默认：/root。
     * @param integer $Timeout 命令超时时间，默认60秒。取值范围[1, 86400]。
     * @param boolean $SaveCommand 是否保存命令，取值范围：
<li> True：保存
<li> False：不保存
默认为 False。
     */
    function __construct()
    {

    }

    /**
     * For internal only. DO NOT USE IT.
     */
    public function deserialize($param)
    {
        if ($param === null) {
            return;
        }
        if (array_key_exists("Content",$param) and $param["Content"] !== null) {
            $this->Content = $param["Content"];
        }

        if (array_key_exists("InstanceIds",$param) and $param["InstanceIds"] !== null) {
            $this->InstanceIds = $param["InstanceIds"];
        }

        if (array_key_exists("CommandName",$param) and $param["CommandName"] !== null) {
            $this->CommandName = $param["CommandName"];
        }

        if (array_key_exists("Description",$param) and $param["Description"] !== null) {
            $this->Description = $param["Description"];
        }

        if (array_key_exists("CommandType",$param) and $param["CommandType"] !== null) {
            $this->CommandType = $param["CommandType"];
        }

        if (array_key_exists("WorkingDirectory",$param) and $param["WorkingDirectory"] !== null) {
            $this->WorkingDirectory = $param["WorkingDirectory"];
        }

        if (array_key_exists("Timeout",$param) and $param["Timeout"] !== null) {
            $this->Timeout = $param["Timeout"];
        }

        if (array_key_exists("SaveCommand",$param) and $param["SaveCommand"] !== null) {
            $this->SaveCommand = $param["SaveCommand"];
        }
    }
}
