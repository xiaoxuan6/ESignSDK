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
use GuzzleHttp\Psr7\{Request, Response};
use Psr\Http\Message\{RequestInterface};

class LogMiddleware implements MiddlewareInterface
{
    public static function handle(Application $app): callable
    {
        return static function (callable $handler) use ($app): callable {
            return static function (RequestInterface $request, array $options) use ($handler, $app) {
                $before = function (Request $request, $options) use ($app) {
                    $response = json_decode($request->getBody()->getContents(), JSON_UNESCAPED_UNICODE);
                    $app['log']->info("[请求参数] url:{$request->getUri()} method:{$request->getMethod()}", $response);
                };

                $before($request, $options);

                $response = $handler($request, $options);

                $after = function (Request $request, $options, $response) use ($app) {
                    if (! $response instanceof Response) {
                        $response = $response->wait(true);
                    }
                    $status = $response->getStatusCode();
                    $response = $response->getBody()->getContents();
                    $app['log']->info("[响应参数] code:{$status}", json_decode($response, JSON_UNESCAPED_UNICODE));
                };

                $after($request, $options, $response);

                return $response;
            };
        };
    }
}
