<?php

declare(strict_types=1);

namespace Falcon\Routing;

use Falcon\Http\Method;

abstract class RouteRegistrar
{
    /** @var array<Route> */
    private(set) array $routes = [];

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function get(string $mask, callable|string $handler, ?string $classMethod = null): void
    {
        $this->routes[] = new Route(
            $mask,
            Method::Get,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null, // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function post(string $mask, callable|string $handler, ?string $classMethod = null): void
    {
        $this->routes[] = new Route(
            $mask,
            Method::Post,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null, // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function put(string $mask, callable|string $handler, ?string $classMethod = null): void
    {

        $this->routes[] = new Route(
            $mask,
            Method::Put,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null, // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function delete(string $mask, callable|string $handler, ?string $classMethod = null): void
    {
        $this->routes[] = new Route(
            $mask,
            Method::Delete,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null, // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function options(string $mask, callable|string $handler, ?string $classMethod = null): void
    {
        $this->routes[] = new Route(
            $mask,
            Method::Options,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null, // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function head(string $mask, callable|string $handler, ?string $classMethod = null): void
    {
        $this->routes[] = new Route(
            $mask,
            Method::Head,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null,  // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function patch(string $mask, callable|string $handler, ?string $classMethod = null): void
    {
        $this->routes[] = new Route(
            $mask,
            Method::Patch,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null,  // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    /**
     * @param string $mask
     * @param callable|class-string $handler
     * @param callable-string|null $classMethod
     * @return void
     */
    protected function any(string $mask, callable|string $handler, ?string $classMethod = null): void
    {
        $this->routes[] = new Route(
            $mask,
            Method::Get,
            is_callable($handler) ? $handler(...) : null,
            is_string($handler) ? $handler : null,  // @phpstan-ignore-line
            is_string($classMethod) ? $classMethod : null
        );
    }

    abstract public function register(): void;
}
