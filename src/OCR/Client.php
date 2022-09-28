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
     * 身份证OCR
     *
     * @param string $infoImg 身份证信息面图片BASE64字符串
     * @param string $emblemImg 身份证国徽面图片BASE64字符串
     *      infoImg与emblemImg至少传一个值
     *
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

    /**
     * 银行卡OCR
     *
     * @param string $img 银行卡正面照照片base64数据。
     *      注意不要带图片BASE64前缀“data:image/jpeg;base64,”
     *      图片类型支持：jpg，jpeg，png，bmp
     *      图片建议分辨率为1024*768，图片大小控制在3M以内
     * @return mixed
     * @throws GuzzleException
     */
    public function bankCard(string $img)
    {
        return $this->post('/v2/identity/auth/api/ocr/bankcard', [
            'img' => $img
        ]);
    }

    /**
     * 营业执照OCR
     *
     * @param string $img 营业执照图片BASE64字符串
     *      注意不要带图片BASE64前缀“data:image/jpeg;base64,”
     *      图片类型支持：jpg，jpeg，png，bmp。
     *      图片建议分辨率为1024*768，图片大小控制在3M以内
     * @return mixed
     * @throws GuzzleException
     */
    public function license(string $img)
    {
        return $this->post('/v2/identity/auth/api/ocr/license', [
            'img' => $img
        ]);
    }

    /**
     * 驾驶证OCR
     *
     * @param string $image 驾驶证图片BASE64字符串
     *      注意不要带图片BASE64前缀“data:image/jpeg;base64,”
     *      图片类型支持：jpg，jpeg，png，bmp。
     *      图片建议分辨率为1024*768，图片大小控制在3M以内
     * @param string $backImage 驾驶证副页图片BASE64字符串
     *      注意不要带图片BASE64前缀“data:image/jpeg;base64,”
     *      图片类型支持：jpg，jpeg，png，bmp。
     *      图片建议分辨率为1024*768，图片大小控制在3M以内
     * @param string $requestId 请求id，标识一次客户的请求，允许为空，一般使用客户的业务id
     * @return mixed
     * @throws GuzzleException
     */
    public function drivingLicence(string $image, string $backImage = '', string $requestId = '')
    {
        return $this->post('/v2/identity/auth/api/ocr/drivinglicence', [
            'image' => $image,
            'backImage' => $backImage,
            'requestId' => $requestId,
        ]);
    }

    /**
     * 行驶证OCR
     *
     * @param string $image 行驶证图片BASE64字符串
     *      注意不要带图片BASE64前缀“data:image/jpeg;base64,”
     *      图片类型支持：jpg，jpeg，png，bmp。
     *      图片建议分辨率为1024*768，图片大小控制在3M以内
     * @param string $backImage 行驶证副页图片BASE64字符串
     *      注意不要带图片BASE64前缀“data:image/jpeg;base64,”
     *      图片类型支持：jpg，jpeg，png，bmp。
     *      图片建议分辨率为1024*768，图片大小控制在3M以内
     * @param string $requestId 请求id，标识一次客户的请求，允许为空，一般使用客户的业务id
     * @return mixed
     * @throws GuzzleException
     */
    public function drivingPermit(string $image, string $backImage = '', string $requestId = '')
    {
        return $this->post('/v2/identity/auth/api/ocr/drivingPermit', [
            'image' => $image,
            'backImage' => $backImage,
            'requestId' => $requestId,
        ]);
    }
}
