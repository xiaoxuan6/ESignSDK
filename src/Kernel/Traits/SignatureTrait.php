<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Kernel\Traits;

trait SignatureTrait
{
    public static function getContentMd5(array $options = []): string
    {
        $jsonStr = json_encode($options, JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT);

        return base64_encode(md5($jsonStr, true));
    }

    public static function sign($url, $method, $contentMd5, $app_key): string
    {
        $payload = [
            'HTTPMethod' => strtoupper($method),
            'Accept' => '*/*',
            'Content-MD5' => $contentMd5,
            'Content-Type' => 'application/json;charset=UTF-8',
            'date' => '',
        ];

        $signStr = '';
        foreach ($payload as $v) {
            $signStr .= $v . "\n";
        }
        $signStr .= '' . $url;

        $signature = hash_hmac("sha256", utf8_encode($signStr), utf8_encode($app_key), true);

        return base64_encode($signature);
    }

    public static function getMillisecond(): float
    {
        list($microsecond, $time) = explode(' ', microtime());

        return (float)sprintf('%.0f', (floatval($microsecond) + floatval($time)) * 1000);
    }
}
