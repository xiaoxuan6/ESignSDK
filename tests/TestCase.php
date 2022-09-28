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

use Vinhson\EsignSdk\Application;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Application
     */
    protected $app;

    protected function setUp(): void
    {
        $this->app = new Application([
            'app_id' => 'xxxx',
            'app_key' => 'xxxx',
            'verify' => false,
            'mode' => 'local',
        ]);
    }
}
