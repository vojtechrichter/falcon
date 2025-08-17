<?php

declare(strict_types=1);

namespace Falcon\Core\Kernel;

use Falcon\Core\Config\Config;
use Falcon\Routing\RouteRegistrar;

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

            // Create container here

            // Resolve request -> route

        } catch (\Throwable $t) {
            // profiler
        }
    }

    public function registerRoutes(RouteRegistrar $registrar): void
    {
        $registrar->register();

        foreach ($registrar->routes as $route) {
            // TODO: pass request, response, add some middleware options

            if ($route->closureHandler !== null) {
                ($route->closureHandler)();
            } else if (
                $route->className !== null &&
                $route->classMethodName !== null
            ) {
                $handlerClass = new $route->className();
                call_user_func_array([$handlerClass, $route->classMethodName], []);
            }
            echo '<br>';
        }
    }
}
