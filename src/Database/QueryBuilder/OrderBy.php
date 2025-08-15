<?php

declare(strict_types=1);

namespace Falcon\Database\QueryBuilder;

final readonly class OrderBy
{
    public const string ASC = 'ASC';
    public const string DESC = 'DESC';

    public function __construct(
        public string $column,
        public string $direction = self::ASC
    ) {
    }
}
