<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk;

use Vinhson\EsignSdk\Kernel\ServiceContainer;

/**
 * Class Application
 * @package Vinhson\EsignSdk
 *
 * @property OCR\Client $ocr
 * @property Enterprise\Client $enterprise
 * @property Info\Client $info
 */
class Application extends ServiceContainer
{
    protected $providers = [
        OCR\ServiceProvider::class,
        Enterprise\ServiceProvider::class,
        Info\ServiceProvider::class
    ];
}
