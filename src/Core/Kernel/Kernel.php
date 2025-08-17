<?php

declare(strict_types=1);

namespace Falcon\Core\Kernel;

use Falcon\Core\Config\Config;
use Falcon\Core\DI\Container;

final class Kernel
{
    public function __construct(
        private KernelConfig $config
    ) {
    }

    public function boot(): void
    {
        try {
            Config::loadFromFile($this->config->configFilePath);

            $container = new Container();
            // Create container here

            // Resolve request -> route

        } catch (\Throwable $t) {
            // profiler
        }
    }
}
