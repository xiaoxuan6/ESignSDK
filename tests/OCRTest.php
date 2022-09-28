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

use GuzzleHttp\Exception\GuzzleException;

class OCRTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testIdCard()
    {
        $this->assertTrue(true);

        var_export($this->app->ocr->idCard('111', ''));
    }

    /**
     * @throws GuzzleException
     */
    public function testBankCard()
    {
        $this->assertTrue(true);

        var_export($this->app->ocr->bankCard('123'));
    }
}
