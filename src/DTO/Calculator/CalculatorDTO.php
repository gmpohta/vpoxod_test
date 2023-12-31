<?php

declare(strict_types=1);

namespace App\DTO\Calculator;

use App\Enum\Operators;

final readonly class CalculatorDTO
{
    public float $operand1;
    public float $operand2;
    public Operators $operator;

    public function __construct(
        ?float $operand1,
        string $operator,
        ?float $operand2,
    ) {
        $this->operand1 = $operand1 ?? 0;
        $this->operand2 = $operand2 ?? 0;
        $this->operator = Operators::fromCode($operator);
    }
}
