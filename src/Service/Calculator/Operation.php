<?php

namespace App\Service\Calculator;

use App\DTO\Calculator\CalculatorDTO;
use App\DTO\Calculator\ResponseDTO;
use App\Enum\Operators;

abstract class Operation
{
    abstract public function execute(float $operand1, float $operand2): float;
}