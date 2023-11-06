<?php

declare(strict_types=1);

namespace App\DTO\Calculator;

use App\Shared\DTO\IResponseDTO;

final readonly class ResponseDTO implements IResponseDTO
{
    public function __construct(
        public float $result,
    ) {
    }
}
