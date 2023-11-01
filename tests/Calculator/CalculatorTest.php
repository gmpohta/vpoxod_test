<?php

declare(strict_types=1);

namespace App\Tests\Calculator;


use App\Tests\Cart\MockUtils;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

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
