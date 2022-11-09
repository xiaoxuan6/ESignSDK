<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Tests;

use Mockery;
use Vinhson\EsignSdk\Application;
use Vinhson\EsignSdk\Response\Response;
use GuzzleHttp\Exception\GuzzleException;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Application
     */
    protected $app;

    protected $config;

    protected function setUp(): void
    {
        $this->config = [
            'app_id' => 'xxx',
            'app_key' => 'xxx',
            'client' => [
                // 测试 'https://smlopenapi.esign.cn',
                // 正式 'https://openapi.esign.cn',
                'base_uri' => 'https://smlopenapi.esign.cn',
                'verify' => false,
                'timeout' => 10,

                /**
                 * 日志配置信息
                 */
                'log' => true,
                'log_path' => __DIR__ . '/../access.log',
                'log_max' => 7 // 日志保留天数
            ]
        ];

        $this->app = Mockery::mock(Application::class, $this->config);
    }

    protected function checkData(array $data, Response $response)
    {
        foreach ($data as $k => $v) {
            if ($k == 'verifyId') {
                continue;
            }

            $method = sprintf("get%s", ucfirst($k));
            $this->assertSame($v, $response->{$method}());
        }
    }

    /**
     * @throws GuzzleException
     */
    public function testIdCard()
    {
        $this->assertTrue(true);

        $this->app = new Application($this->config);

        var_export($this->app->ocr->idCard('xxxx', ''));
    }
}
