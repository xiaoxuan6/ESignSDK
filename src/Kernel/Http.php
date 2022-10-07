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

use Vinhson\EsignSdk\Kernel\Traits\SignatureTrait;
use GuzzleHttp\{Client, Exception\GuzzleException, HandlerStack, Middleware, Psr7\Request, Psr7\Response};

class Http
{
    use SignatureTrait;

    private $app_id;
    private $app_key;

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

    public function __construct(string $app_id, string $app_key, array $options = [])
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;

        $this->options['verify'] = $options['verify'] ?? true;
        $this->options['timeout'] = $options['timeout'] ?? 5;
        $this->options['base_uri'] = $options['base_uri'] ?? '';

        if ($options['log'] ?? false) {
            $this->tapMiddleware();
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
            'X-Tsign-Open-App-Id' => $this->app_id,
            'Content-Type' => 'application/json;charset=UTF-8',
            'X-Tsign-Open-Ca-Timestamp' => self::getMillisecond(),
            'Accept' => '*/*',
            'X-Tsign-Open-Ca-Signature' => self::sign($url, $method, $contentMd5, $this->app_key),
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

        if ($this->middlewares) {
            foreach ($this->middlewares as $name => $middleware) {
                $this->handlerStack->push($middleware, $name);
            }
        }

        return $this->handlerStack;
    }

    private function tapMiddleware()
    {
        $tap = Middleware::tap(function (Request $request, $options) {
            echo "[请求参数] url:{$request->getUri()} method:{$request->getMethod()} params:{$request->getBody()->getContents()}" . PHP_EOL;
        }, function (Request $request, $options, $response) {
            if (! $response instanceof Response) {
                $response = $response->wait(true);
            }
            $response = $response->getBody()->getContents();
            echo "[响应参数] response:{$response}";
        });

        $this->putMiddleware('tap', $tap);
    }
}
