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

use Vinhson\EsignSdk\Application;
use GuzzleHttp\Exception\GuzzleException;

class BaseClient
{
    /**
     * @var Application
     */
    public $app;

    /**
     * @var Http
     */
    public $http;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->_initHttp($this->app->config['client'] ?? []);
    }

    /**
     * @param array $options
     * @return void
     */
    private function _initHttp(array $options = []): void
    {
        if (! $this->http) {
            $this->http = new Http($this->app->config['app_id'] ?? '', $this->app->config['app_key'] ?? '', $options);
        }
    }

    /**
     * @param $url
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function get($url, array $query = []): array
    {
        return $this->http->request($url, 'GET', ['query' => $query]);
    }

    /**
     * @param $url
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function post($url, array $params = []): array
    {
        return $this->http->request($url, 'POST', ['json' => $params]);
    }

    /**
     * @param $url
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function put($url, array $params = []): array
    {
        return $this->http->request($url, 'PUT', ['json' => $params]);
    }
}
