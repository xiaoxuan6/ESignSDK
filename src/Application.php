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
 * @property OCR\Client $ocr ocr识别能力
 * @property Enterprise\Client $enterprise 信息查询
 * @property Info\Client $info 信息对比能力
 * @property AuthFlow\Client $auth 认证流程查询
 */
class Application extends ServiceContainer
{
    protected $providers = [
        OCR\ServiceProvider::class,
        Enterprise\ServiceProvider::class,
        Info\ServiceProvider::class,
        AuthFlow\ServiceProvider::class
    ];
}
