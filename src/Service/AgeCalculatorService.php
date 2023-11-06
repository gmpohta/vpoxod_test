<?php

namespace App\Service;

use App\DTO\AgeCalculator\AgeCalculatorDTO;
use App\DTO\AgeCalculator\ResponseDTO;

final readonly class AgeCalculatorService
{
    public function calculateAge(AgeCalculatorDTO $dto): ResponseDTO
    {
        $age = date_diff($dto->birthday, $dto->dateFrom);

        return new ResponseDTO($age);
    }
}
