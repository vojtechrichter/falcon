<?php

declare(strict_types=1);

namespace Falcon\Core\Kernel;

use Falcon\Core\Config\Config;

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
        } catch (\Throwable $t) {
            // profiler
        }
    }
}
