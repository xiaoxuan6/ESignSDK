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
use GuzzleHttp\{Client, Exception\GuzzleException, HandlerStack, Middleware, Psr7\Request, Psr7\Response};

class Http implements HttpInterface
{
    use SignatureTrait;

    /**
     * @var Application
     */
    public $app;

    /**
     * @var array
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
     * @var array
     */
    private $middlewares = [];

    /**
     * @var HandlerStack
     */
    private $handlerStack = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $options = $app->config;
        $this->config = $options;

        $client = $options['client'];
        $this->options['verify'] = $client['verify'] ?? true;
        $this->options['timeout'] = $client['timeout'] ?? 5;
        $this->options['base_uri'] = $client['base_uri'] ?? '';

        if ($client['log'] ?? false) {
            $this->logMiddleware();
        }
    }

    /**
     * @param Client $client
     * @return Http
     */
    public function setClient(Client $client): Http
    {
        $this->client = $client;

        return $this;
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
            'X-Tsign-Open-App-Id' => $this->config['app_id'],
            'Content-Type' => 'application/json;charset=UTF-8',
            'X-Tsign-Open-Ca-Timestamp' => self::getMillisecond(),
            'Accept' => '*/*',
            'X-Tsign-Open-Ca-Signature' => self::sign($url, $method, $contentMd5, $this->config['app_key']),
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
     * @param string $name
     * @param callable $middleware
     * @return $this
     */
    protected function putMiddleware(string $name, callable $middleware): Http
    {
        if (empty($name)) {
            array_push($this->middlewares, $middleware);
        } else {
            $this->middlewares[$name] = $middleware;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param HandlerStack $handlerStack
     * @return $this
     */
    public function setHandlerStack(HandlerStack $handlerStack): Http
    {
        $this->handlerStack = $handlerStack;

        return $this;
    }

    /**
     * @return HandlerStack
     */
    private function getHandler(): HandlerStack
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }

        $this->handlerStack = HandlerStack::create();

        if ($middlewares = $this->getMiddlewares()) {
            foreach ($middlewares as $name => $middleware) {
                $this->handlerStack->push($middleware, $name);
            }
        }

        return $this->handlerStack;
    }

    /**
     * log middleware
     */
    private function logMiddleware()
    {
        $tap = Middleware::tap(
            function (Request $request, $options) {
                $response = json_decode($request->getBody()->getContents(), JSON_UNESCAPED_UNICODE);
                $this->app['log']->info("[请求参数] url:{$request->getUri()} method:{$request->getMethod()}", $response);
            },
            function (Request $request, $options, $response) {
                if (! $response instanceof Response) {
                    $response = $response->wait(true);
                }
                $status = $response->getStatusCode();
                $response = $response->getBody()->getContents();
                $this->app['log']->info("[响应参数] code:{$status}", json_decode($response, JSON_UNESCAPED_UNICODE));
            }
        );

        $this->putMiddleware('log', $tap);
    }
}
