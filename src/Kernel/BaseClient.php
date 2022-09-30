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

use GuzzleHttp\Client;
use Vinhson\EsignSdk\Application;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Kernel\Support\Traits\SignatureTrait;

class BaseClient
{
    use SignatureTrait;

    public const URI = [
        'local' => 'https://smlopenapi.esign.cn',
        'prod' => 'https://openapi.esign.cn',
    ];

    /**
     * @var Application
     */
    public $app;

    /**
     * @var mixed|string
     */
    protected $mode;

    public $baseUri = '';

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->mode = $app->config['mode'] ?? 'local';
        $this->baseUri = self::URI[$this->mode] ?? '';
    }

    /**
     * @param $url
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function get($url, array $query = []): array
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * @param $url
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function post($url, array $params = []): array
    {
        return $this->request($url, 'POST', ['json' => $params]);
    }

    /**
     * @param $url
     * @param $method
     * @param array $options
     * @return array
     * @throws GuzzleException
     */
    public function request($url, $method, array $options = []): array
    {
        $options = $this->formatOptions($url, $method, $options);

        $url = sprintf('%s%s', $this->baseUri, '/' . ltrim($url, '/'));

        $verify = $this->app->config['verify'] ?? true;
        $response = (new Client(['verify' => $verify]))->request($method, $url, $options);

        return json_decode($response->getBody()->getContents(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $url
     * @param $method
     * @param array $options
     * @return array
     */
    private function getHeaders($url, $method, array $options = []): array
    {
        $options = $options['query'] ?? ($options['json'] ?? []);
        $contentMd5 = self::getContentMd5($options);

        return [
            'X-Tsign-Open-App-Id' => $this->app->config['app_id'] ?? '',
            'Content-Type' => 'application/json;charset=UTF-8',
            'X-Tsign-Open-Ca-Timestamp' => self::getMillisecond(),
            'Accept' => '*/*',
            'X-Tsign-Open-Ca-Signature' => self::sign($url, $method, $contentMd5, $this->app->config['app_key'] ?? ''),
            'X-Tsign-Open-Auth-Mode' => 'Signature',
            'Content-MD5' => $contentMd5,
        ];
    }

    /**
     * @param $url
     * @param $method
     * @param array $options
     * @return array
     */
    private function formatOptions($url, $method, array $options = []): array
    {
        if (! isset($options['headers']) || empty($options['headers'])) {
            $options['headers'] = $this->getHeaders($url, $method, $options);
        }

        return $options;
    }
}
