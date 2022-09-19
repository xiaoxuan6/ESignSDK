<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\OCR;

use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * infoImg与emblemImg至少传一个值
     *
     * @param $infoImg string 身份证信息面图片BASE64字符串
     * @param $emblemImg string 身份证国徽面图片BASE64字符串
     * @return mixed
     * @throws GuzzleException
     */
    public function idCard(string $infoImg, string $emblemImg)
    {
        return $this->post('/v2/identity/auth/api/ocr/idcard', array_filter([
            'infoImg' => $infoImg,
            'emblemImg' => $emblemImg
        ]));
    }
}
