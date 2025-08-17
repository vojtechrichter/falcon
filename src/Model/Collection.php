<?php

declare(strict_types=1);

namespace Falcon\Database\QueryBuilder;

use Kernel\Database\QueryBuilder\QueryBuilder;

class Collection
{
    private(set) \PDO $pdo;

    public function __construct(
    ) {
    }

    public static function fromQueryBuilder(QueryBuilder $queryBuilder): Collection
    {
        return new Collection();
    }
}
