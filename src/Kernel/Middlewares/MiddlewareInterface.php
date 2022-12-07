<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Kernel\Middlewares;

use Vinhson\EsignSdk\Application;

interface MiddlewareInterface
{
    public static function handle(Application $app): callable;
}
