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

use Pimple\{Container, ServiceProviderInterface};
use Vinhson\EsignSdk\Kernel\{Config, ServiceContainer};

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['config'] = function (ServiceContainer $app) {
            return new Config($app->getConfig());
        };
    }
}
