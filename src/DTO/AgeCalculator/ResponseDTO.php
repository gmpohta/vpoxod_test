<?php

declare(strict_types=1);

namespace App\DTO\AgeCalculator;

use App\Shared\DTO\IResponseDTO;

final readonly class ResponseDTO implements IResponseDTO
{
    public string $age;

    public function __construct(
        \DateInterval $age,
    ) {
        $this->age = $age->format('%y years %m mounth %d days');
    }
}
