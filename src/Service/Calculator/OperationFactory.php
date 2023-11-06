<?php

namespace App\Service\Calculator;

use App\Enum\Operators;

final class OperationFactory
{
    public static function create($operator): Operation
    {
        switch ($operator) {
            case Operators::PLUS:
                return new Add();
            case Operators::MINUS:
                return new Subtract();
            case Operators::DIVIDE:
                return new Divide();
            case Operators::MULTIPLY:
                return new Multiply();
            default:
                throw new Exception("Unknown operation symbol");
        }
    }
}