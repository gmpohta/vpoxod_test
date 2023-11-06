<?php

namespace App\Service\Calculator;

use App\DTO\Calculator\CalculatorDTO;
use App\DTO\Calculator\ResponseDTO;

final readonly class CalculatorService
{
    public function calculate(CalculatorDTO $dto): ResponseDTO
    {
        $operation = OperationFactory::create($dto->operator);

        return new ResponseDTO($operation->execute($dto->operand1, $dto->operand2));
    }
}
