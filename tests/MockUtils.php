<?php

declare(strict_types=1);

namespace App\Tests;

final class MockUtils
{
    public static function RequestForCalculate(): string
    {
        return '{"operand1":1.3, "operator":"DIVIDE", "operand2":3.8}';
    }

    public static function InvalidRequestForCalculate(): string
    {
        return '{"operand1":"hhh", "operator":"uuu", "operand2":3.8}';
    }

    public static function RequestForAgeCalculate(): string
    {
        return '{"birthday":"01.01.2000", "calcDate":"02.05.2020"}';
    }

    public static function InvalidRequestForAgeCalculate(): string
    {
        return '{{"birthday":"01.01.2000", "calcDate":"02.05.1020"}';
    }
}
