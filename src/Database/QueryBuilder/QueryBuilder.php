<?php

declare(strict_types=1);

namespace Falcon\Database\QueryBuilder;

final class QueryBuilder implements \Stringable
{
    private int $bindingCounter = 0;
    /** @var array<string, string>  */
    private array $bindings = [];
    /** @var array<string> */
    private array $selectColumns = [];
    /** @var array<Where> */
    private array $whereClauses = [];
    /** @var array<OrderBy> */
    private array $orderClauses = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private string $table;

    /**
     * @param array<string> $columns
     * @return $this
     */
    public function select(array $columns): self
    {
        $this->selectColumns = $columns;

        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function where(string $lExpr, mixed $rExpr): self
    {
        $this->whereClauses[] = new Where(
            $lExpr,
            $rExpr,
            Where::AND
        );
        $this->bindings[$this->createPlaceholder()] = $rExpr;

        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderClauses[] = new OrderBy($column, $direction);

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    private function buildWherePart(): string
    {
        $conditions = [];
        $firstCondition = true;

        foreach ($this->whereClauses as $whereClause) {
            $concatBoolOp = $firstCondition ? '' : " {$whereClause->compareBoolean} ";

            // TODO: dodelat where podminky pro operatory jako < > <=, >= ! LIKE

            $conditions[] = match ($whereClause->type) {
                WhereType::Default => $concatBoolOp . "{$this->filterOperators($whereClause->column)} {$this->resolveLExprOperator($whereClause->column)} {$whereClause->value}",
                WhereType::In => throw new \Exception('To be implemented'),
                WhereType::Between => throw new \Exception('To be implemented')
            };

            $firstCondition = false;
        }

        return implode('', $conditions);
    }

    private function resolveLExprOperator(string $lexpr): string
    {
        $characterArray = mb_str_split($lexpr);
        foreach ($characterArray as $idx => $char) {
            if (in_array($char, ['<', '>'])) {
                if (isset($characterArray[$idx + 1]) && $characterArray[$idx + 1] === '=') {
                    return $char . '=';
                }

                return $char;
            }
        }

        return '=';
    }

    private function filterOperators(string $lexpr): string
    {
        return implode('', array_filter(mb_str_split($lexpr), fn ($a) => !in_array($a, ['<', '=', '>'])));
    }

    private function build(): string
    {
        $sql = 'SELECT ' . implode(',', $this->selectColumns) . ' FROM ' . $this->table;

        if (count($this->whereClauses) > 0) {
            $sql .= ' WHERE ' . $this->buildWherePart();
        }

        if (count($this->orderClauses) > 0) {
            $orderParts = [];
            foreach ($this->orderClauses as $orderClause) {
                $orderParts[] = "{$orderClause->column} {$orderClause->direction}";
            }
            $sql .= ' ORDER BY ' . implode(',', $orderParts);
        }

        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . $this->limit;
            if ($this->offset !== null) {
                $sql .= ' OFFSET ' . $this->offset;
            }
        }

        return $sql;
    }

    public function getQuery(): string
    {
        return $this->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }

    private function createPlaceholder(): string
    {
        return ':placeholder_' . (++$this->bindingCounter);
    }
}
