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

class Config
{
    public const URI = [
        'dev' => 'https://smlopenapi.esign.cn',
        'prod' => 'https://openapi.esign.cn',
    ];

    public const DEFAULT_CONFIG = [
        'app_id' => '',
        'app_key' => '',
        'mode' => 'dev',
        'client' => [
            'verify' => false,
            'timeout' => 10,
        ],
        'middlewares' => [
            'log' => \Vinhson\EsignSdk\Kernel\Middlewares\LogMiddleware::class,
        ],
        /**
         * 日志配置信息
         */
        'log_enable' => true,
        'log_path' => __DIR__ . '/../../access.log',
        'log_max' => 7 // 日志保留天数
    ];

    /**
     * @var array
     */
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = array_replace_recursive(self::DEFAULT_CONFIG, $config);
    }

    public function getAppId()
    {
        return $this->config['app_id'];
    }

    public function getAppKey()
    {
        return $this->config['app_key'];
    }

    public function getClientBaseUri(): string
    {
        return self::URI[$this->config['mode'] ?? 'dev'];
    }

    public function getClientVerify()
    {
        return $this->config['client']['verify'];
    }

    public function getClientTimeout()
    {
        return $this->config['client']['timeout'];
    }

    public function getMiddlewares()
    {
        return $this->config['middlewares'];
    }

    public function getLogEnable()
    {
        return $this->config['log_enable'];
    }

    public function getLogPath()
    {
        return $this->config['log_path'];
    }

    public function getLogMax()
    {
        return $this->config['log_max'];
    }

    public function toArray(): array
    {
        return $this->config;
    }
}
