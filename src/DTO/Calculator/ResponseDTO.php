<?php

declare(strict_types=1);

namespace App\DTO\Calculator;

final readonly class ResponseDTO
{
    public function __construct(
        public float $result,
    ) {
    }
}
