<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Kernel;

use Vinhson\EsignSdk\Application;
use Vinhson\EsignSdk\Kernel\Traits\SignatureTrait;
use Vinhson\EsignSdk\Kernel\Contracts\HttpInterface;
use Vinhson\EsignSdk\Kernel\Middlewares\MiddlewareInterface;
use GuzzleHttp\{Client, Exception\GuzzleException, HandlerStack};
use Vinhson\EsignSdk\Kernel\Exceptions\InvalidMiddlewareException;

class Http implements HttpInterface
{
    use SignatureTrait;

    /**
     * @var Application
     */
    public $app;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var HandlerStack
     */
    private $handlerStack = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = $app['config'];

        $this->options['verify'] = $this->config->getClientVerify();
        $this->options['timeout'] = $this->config->getClientTimeout();
        $this->options['base_uri'] = $this->config->getClientBaseUri();
    }

    /**
     * @param null $handler
     * @return Client
     */
    public function getClient($handler = null): Client
    {
        $option = $handler ? ['handler' => $handler] : [];

        return $this->client ?? $this->client = new Client(array_merge(
            $this->options,
            $option
        ));
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

        $url = '/' . ltrim($url, '/');

        $response = $this->getClient($this->getHandler())->request($method, $url, $options);

        return json_decode($response->getBody()->getContents(), JSON_UNESCAPED_UNICODE) ?? [];
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
            'X-Tsign-Open-App-Id' => $this->config->getAppId(),
            'Content-Type' => 'application/json;charset=UTF-8',
            'X-Tsign-Open-Ca-Timestamp' => self::getMillisecond(),
            'Accept' => '*/*',
            'X-Tsign-Open-Ca-Signature' => self::sign($url, $method, $contentMd5, $this->config->getAppKey()),
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
        $options['headers'] = $this->getHeaders($url, $method, $options);

        return $options;
    }

    /**
     * @return array
     * @throws InvalidMiddlewareException
     */
    public function getMiddlewares(): array
    {
        $middlewares = $this->config->getMiddlewares();

        foreach ($middlewares as $name => $middleware) {
            if (! (new $middleware() instanceof MiddlewareInterface)) {
                throw new InvalidMiddlewareException("Class {$middleware} must implements \\Vinhson\\EsignSdk\\Kernel\\Middlewares\\MiddlewareInterface::class");
            }

            if (! $this->config->getLogEnable()) {
                unset($middlewares['log']);
            }
        }

        return $middlewares;
    }

    /**
     * @return HandlerStack
     * @throws InvalidMiddlewareException
     */
    private function getHandler(): HandlerStack
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }

        $this->handlerStack = HandlerStack::create();

        if ($middlewares = $this->getMiddlewares()) {
            foreach ($middlewares as $name => $middleware) {
                /** @var $middleware MiddlewareInterface */
                $this->handlerStack->push($middleware::handle($this->app), $name);
            }
        }

        return $this->handlerStack;
    }
}
