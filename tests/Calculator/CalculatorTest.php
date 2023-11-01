<?php

declare(strict_types=1);

namespace App\Tests\Calculator;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CalculatorTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testExecuteWithValidData(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 13,
            'operand2' => 38,
            'operation' => 'DIVIDE',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $expectedJson = '{"result":0.34210526315789475}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }

    public function testExecuteWithInvalidData(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 'gffg',
            'operand2' => 38,
            'operation' => 'x',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(500, $response->getStatusCode());
        $expectedJson = '{"error": "The type of the \"operand1\" attribute for class \"App\\DTO\\Calculator\\CalculatorDTO\" must be one of \"float\" (\"string\" given)."}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }
}
