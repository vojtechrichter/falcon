<?php

declare(strict_types=1);

namespace Falcon\Routing;

use Falcon\Http\Method;

final readonly class Route
{
    /**
     * @param string $mask
     * @param Method|null $method
     * @param \Closure|null $closureHandler
     * @param string<class-string>|null $className
     * @param string<callable-string>|null $classMethodName
     */
    public function __construct(
        public string $mask,
        public ?Method $method,
        public ?\Closure $closureHandler,
        public ?string $className,
        public ?string $classMethodName
    ) {
    }
}
