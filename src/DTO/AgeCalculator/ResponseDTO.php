<?php

declare(strict_types=1);

namespace App\DTO\AgeCalculator;

final readonly class ResponseDTO
{
    public string $age;

    public function __construct(
        \DateInterval $age,
    ) {
        $this->age = $age->format('%y years %m mounth %d days');
    }
}
