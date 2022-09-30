<?php

/*
 * This file is part of esign sdk.
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
            'verify' => false,
            'mode' => 'local',
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
}
