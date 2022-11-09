<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Account;

use Vinhson\EsignSdk\Kernel\BaseClient;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Kernel\Support\IdType;
use Vinhson\EsignSdk\Response\Account\{PersonAccountCreateResponse, PersonAccountModifyResponse};

class Client extends BaseClient
{
    /**
     * 创建个人账号
     *
     * @param string $thirdPartyUserId 用户唯一标识，由开发者自定义
     * @param string $name 姓名
     * @param string $idType 证件类型、【注】如果调用“认证服务纯API版”接口时，该字段必传
     * @param string $idNumber 证件号，默认为空，发起签署前需确保补齐证件号。
     * @param string $mobile 手机号码，默认空，手机号为空时无法使用短信意愿认证
     * @param string $email 邮箱地址，默认空
     * @return PersonAccountCreateResponse
     * @throws GuzzleException
     */
    public function personAccountCreate(
        string $thirdPartyUserId,
        string $name,
        string $idType = IdType::ID_TYPE_IDCARD,
        string $idNumber = '',
        string $mobile = '',
        string $email = ''
    ): PersonAccountCreateResponse {
        return new PersonAccountCreateResponse($this->post('/v1/accounts/createByThirdPartyUserId', [
            'thirdPartyUserId' => $thirdPartyUserId,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
            'mobile' => $mobile,
            'email' => $email
        ]));
    }

    /**
     * 修改个人账号
     *      1. 更新账号的联系方式：手机号、邮箱
     *      2. 若需更新姓名，则该账号会变为未实名状态，需要用户重新实名；
     *      【注】接口不支持变更证件类型和证件号，建议开发者先调用【注销个人账号】接口，重新创建。
     *
     * @param string $accountId 账号id
     * @param string $name 姓名，默认不变
     * @param string $idType 证件类型、默认CRED_PSN_CH_IDCARD 该字段只有为空才允许修改
     * @param string $idNumber 证件号，该字段只有为空才允许修改
     * @param string $mobile 联系方式，手机号码，默认不变
     * @param string $email 联系方式，邮箱地址，默认不变
     * @return PersonAccountModifyResponse
     * @throws GuzzleException
     */
    public function personAccountModify(
        string $accountId,
        string $name = '',
        string $idType = IdType::ID_TYPE_IDCARD,
        string $idNumber = '',
        string $mobile = '',
        string $email = ''
    ): PersonAccountModifyResponse {
        return new PersonAccountModifyResponse($this->put(sprintf('/v1/accounts/%s', $accountId), [
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
            'mobile' => $mobile,
            'email' => $email
        ]));
    }
}
