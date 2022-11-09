<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Kernel\Providers;

use Vinhson\EsignSdk\Kernel\Http;
use Pimple\{Container, ServiceProviderInterface};

class HttpServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['http'] = function ($app) {
            return new Http($app);
        };
    }
}
