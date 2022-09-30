<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Response;

abstract class Response
{
    public const SUCCESS_CODE = 0;

    protected $response;

    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    public function isSuccess(): bool
    {
        if (self::SUCCESS_CODE == $this->response['code']) {
            return true;
        }

        return false;
    }

    public function getData(): array
    {
        return $this->response['data'] ?? [];
    }

    public function getReason(): string
    {
        return $this->response['message'] ?? '未知错误';
    }
}
