<?php

namespace App\Service\Calculator;

abstract class Operation
{
    abstract public function execute(float $operand1, float $operand2): float;
}
