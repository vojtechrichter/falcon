<?php

declare(strict_types=1);

namespace Falcon\Database;

use Falcon\Core\Config\Config;
use Falcon\Core\Config\SectionKey;

final class PdoProvider
{
    public static function get(): \PDO
    {
        $config = Config::get();
        if (!isset($config[SectionKey::Database->value])) {
            throw new \RuntimeException('Database information is not set in the config file.');
        }

        $databaseConfig = Config::get()[SectionKey::Database->value];

        $dsn = '';
        if ($databaseConfig['driver'] === 'pgsql') {
            $dsn = "pgsql:host={$databaseConfig['host']};port={$databaseConfig['port']};dbname={$databaseConfig['db']};user={$databaseConfig['username']};password={$databaseConfig['password']}";
        } else if ($databaseConfig['driver'] === 'mysql') {
            $dsn = "mysql:host={$databaseConfig['host']};port={$databaseConfig['port']};dbname={$databaseConfig['db']}";
        }

        return new \PDO($dsn, $databaseConfig['username'], $databaseConfig['password'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_DRIVER_NAME => $databaseConfig['driver']
        ]);
    }
}
