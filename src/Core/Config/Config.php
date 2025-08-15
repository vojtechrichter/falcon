<?php

declare(strict_types=1);

namespace Falcon\Core\Config;

final class Config
{
    private static array $configData = [];
    private static bool $loaded = false;

    public static function loadFromFile(string $path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf('Config file %s does not exist.', $path));
        }

        self::$configData = \yaml_parse_file($path);
        self::$loaded = true;
    }

    public static function get(): array
    {
        if (!self::$loaded) {
            throw new \RuntimeException('Config is not loaded.');
        }

        return self::$configData;
    }
}
