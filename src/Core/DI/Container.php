<?php

declare(strict_types=1);

namespace Falcon\Core\DI;

final class Container
{
    /** @var array<callable> $services */
    private array $services = [];

    public function add(string $id, callable $serviceCallback): void
    {
        $this->services[$id] = $serviceCallback;
    }

    public function get(string $id): object
    {
        if (!isset($this->services[$id])) {
            throw new \RuntimeException(sprintf('Service "%s" is not registered in the container.', $id));
        }

        return $this->services[$id]($this);
    }
}
