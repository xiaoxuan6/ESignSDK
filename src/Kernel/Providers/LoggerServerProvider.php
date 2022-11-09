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

use Vinhson\EsignSdk\Kernel\Logger;
use Pimple\{Container, ServiceProviderInterface};

class LoggerServerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['log'] = function ($app) {
            return (new Logger($app))->setLogDriver();
        };
    }
}
