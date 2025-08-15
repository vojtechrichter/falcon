<?php

declare(strict_types=1);

namespace Falcon\Database\QueryBuilder;

final readonly class Where
{
    public const string AND = 'AND';

    public function __construct(
        public string $column,
        public string $value,
        public string $compareBoolean,
        public WhereType $type = WhereType::Default
    ) {
    }
}
