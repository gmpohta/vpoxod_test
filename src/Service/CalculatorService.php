<?php

namespace App\Service;

use App\DTO\Calculator\CalculatorDTO;
use App\DTO\Calculator\ResponseDTO;
use App\Enum\Operators;

final readonly class CalculatorService
{
    public function calculate(CalculatorDTO $dto): ResponseDTO
    {
        $result = $dto->operand1;

        switch ($dto->operator) {
            case Operators::PLUS:
                $result = $result + $dto->operand2;
                break;
            case Operators::MINUS:
                $result = $result - $dto->operand2;
                break;
            case Operators::DIVIDE:
                $result = $result / $dto->operand2;
                break;
            case Operators::MULTIPLY:
                $result = $result * $dto->operand2;
                break;
            default:
                throw new \Exception('Operator not found.');
        }

        return new ResponseDTO($result);
    }
}
