<?php

namespace App\Service;

use App\DTO\Calculator\CalculatorDTO;
use App\DTO\Calculator\ResponseDTO;
use App\Enums\Operators;

final readonly class CalculatorService
{
    public function calculate(CalculatorDTO $dto): ResponseDTO
    {
        $result = $dto->operand1;

        switch ($dto->operator) {
            case Operators::PLUS === $dto->operator:
                $result = $result + $dto->operand2;
                break;
            case Operators::MINUS === $dto->operator:
                $result = $result - $dto->operand2;
                break;
            case Operators::DIVIDE === $dto->operator:
                $result = $result * $dto->operand2;
                break;
            case Operators::MULTIPLY === $dto->operator:
                $result = $result / $dto->operand2;
                break;
        }

        return new ResponseDTO($result);
    }
}
