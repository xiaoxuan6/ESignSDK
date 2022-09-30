<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Enterprise;

use Vinhson\EsignSdk\Kernel\BaseClient;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Response\Enterprise\DetailResponse;

class Client extends BaseClient
{
    /**
     * 工商信息查询
     *
     * @param string $keyword 企业机构全称或企业机构证件号
     * @return DetailResponse
     * @throws GuzzleException
     */
    public function detail(string $keyword): DetailResponse
    {
        return new DetailResponse($this->post('：/v2/identity/auth/api/meta/enterprise/detail', [
            'keyword' => $keyword
        ]));
    }
}
