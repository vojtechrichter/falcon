<?php

declare(strict_types=1);

namespace Falcon\Model\QueryBuilder;

enum WhereType: int
{
    case Default = 1;
    case In = 2;
    case Between = 3;
}
