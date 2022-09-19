<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Kernel;

use Pimple\Container;

class ServiceContainer extends Container
{
    protected $providers = [];

    public $config = [];

    public function __construct(array $config = [], array $prepends = [])
    {
        parent::__construct($prepends);

        $this->config = $config;
        $this->registerProviders($this->getProviders());
    }

    private function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    private function getProviders(): array
    {
        return $this->providers;
    }

    public function __get($id)
    {
        return $this->offsetGet($id);
    }
}
