<?php

declare(strict_types=1);

namespace App\Enum;

use App\Exception\InvalidEnumNameException;

enum Operators: string
{
    case PLUS = 'plus';
    case MINUS = 'minus';
    case MULTIPLY = 'multiply';
    case DIVIDE = 'divide';

    /**
     * @throws InvalidEnumNameException
     */
    public static function fromCode(string $operator): self
    {
        return match ($operator) {
            'PLUS' => self::PLUS,
            'MINUS' => self::MINUS,
            'MULTIPLY' => self::MULTIPLY,
            'DIVIDE' => self::DIVIDE,

            default => throw new InvalidEnumNameException(self::class, $operator)
        };
    }
}
