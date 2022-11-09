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
use Monolog\Handler\RotatingFileHandler;
use Vinhson\EsignSdk\Kernel\Exception\{InvalidClassException, InvalidFileException};

class Logger
{
    /**
     * @var Application
     */
    public Application $app;

    public array $config;

    /**
     * @var \Monolog\Logger
     */
    public $logger;

    public function __construct(Application $application)
    {
        $this->app = $application;
        $this->config = $this->app->config['client'] ?? [];
    }

    public function setLogDriver()
    {
        $logPath = $this->config['log_path'] ?? '';

        $class = "Monolog\\Logger";

        if (! class_exists($class)) {
            throw new InvalidClassException("Class {$class} not exists!");
        }

        if (! $logPath) {
            throw new InvalidFileException("Log path is an invalid file");
        }


        return $this->logger ?? $this->logger = $this->createLogger($logPath, $this->config['log_max'] ?? 7);
    }

    /**
     * @param string $logPath
     * @param $logMax
     * @return \Monolog\Logger
     */
    private function createLogger(string $logPath, $logMax): \Monolog\Logger
    {
        $log = new \Monolog\Logger('log');
        $log->pushHandler(new RotatingFileHandler($logPath, $logMax));

        return $log;
    }
}
