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

    /**
     * @var Config
     */
    public Config $config;

    /**
     * @var \Monolog\Logger
     */
    public \Monolog\Logger $logger;

    public function __construct(Application $application)
    {
        $this->app = $application;
        $this->config = $this->app['config'];
    }

    public function setLogDriver(): \Monolog\Logger
    {
        $logPath = $this->config->getLogPath();

        $class = "Monolog\\Logger";

        if (! class_exists($class)) {
            throw new InvalidClassException("Class {$class} not exists!");
        }

        if (! $logPath) {
            throw new InvalidFileException("Log path is an invalid file");
        }


        return $this->logger ?? $this->logger = $this->createLogger($logPath, $this->config->getLogMax());
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
