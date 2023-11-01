<?php

declare(strict_types=1);

namespace App\Tests\Calculator;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CalculatorTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testExecuteWithValidData(): void
    {
    }

    public function testExecuteWithNoValidData(): void
    {
    }
}
