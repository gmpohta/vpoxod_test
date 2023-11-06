<?php

namespace App\Service\Calculator;

final class Multiply extends Operation
{
    public function execute(float $operand1, float $operand2): float
    {
        return $operand1 * $operand2;
    }
}
