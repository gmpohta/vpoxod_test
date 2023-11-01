<?php

declare(strict_types=1);

namespace App\Tests\AgeCalculator;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class AgeCalculatorTest extends KernelTestCase
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
