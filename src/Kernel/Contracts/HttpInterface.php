<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Kernel\Contracts;

use GuzzleHttp\Client;

interface HttpInterface
{
    public function getClient($handler = null): Client;

    public function request($url, $method, array $options = []): array;
}
