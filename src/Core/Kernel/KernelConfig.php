<?php

declare(strict_types=1);

namespace Falcon\Core\Kernel;

final readonly class KernelConfig
{
    public function __construct(
        private(set) string $configFilePath
    ) {
    }
}
