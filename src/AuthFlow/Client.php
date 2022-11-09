<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\AuthFlow;

use Vinhson\EsignSdk\Kernel\BaseClient;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Response\AuthFlow\{AuthFlowDetailResponse, AuthFlowResponse};

class Client extends BaseClient
{
    /**
     * 查询认证主流程明细
     *
     * @param string $flowId 认证流程ID
     * @return AuthFlowResponse
     * @throws GuzzleException
     */
    public function authFlow(string $flowId): AuthFlowResponse
    {
        return new AuthFlowResponse($this->get(sprintf('/v2/identity/auth/api/common/%s/outline', $flowId)));
    }

    /**
     * 查询认证信息
     *
     * @param string $flowId 认证流程ID
     * @return AuthFlowDetailResponse
     * @throws GuzzleException
     */
    public function authFlowDetail(string $flowId): AuthFlowDetailResponse
    {
        return new AuthFlowDetailResponse($this->get(sprintf('/v2/identity/auth/api/common/%s/detail', $flowId)));
    }
}
