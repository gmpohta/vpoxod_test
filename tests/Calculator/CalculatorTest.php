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

    public function testInvalidOperands(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 'xxx',
            'operand2' => 'DIVIDE',
            'operator' => 'yyy',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $expectedJson = '{"success":false,"data":[],"message":"The type of the \"operand1\" attribute for class \"App\\\\DTO\\\\Calculator\\\\CalculatorDTO\" must be one of \"float\" (\"string\" given)."}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }

    public function testWrongOperator(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 10,
            'operand2' => 11,
            'operator' => 'WRONGOPERATOR',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $expectedJson = '{"success":false,"data":[],"message":"Unknown App\\\\Enum\\\\Operators with type: WRONGOPERATOR"}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }

    public function testAddOperator(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 10,
            'operand2' => 11,
            'operator' => 'PLUS',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $expectedJson = '{"success":true,"data":{"result":21.0},"message":null}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }

    public function testSubtractOperator(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 10,
            'operand2' => 11,
            'operator' => 'MINUS',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $expectedJson = '{"success":true,"data":{"result":-1.0},"message":null}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }

    public function testMultiplyOperator(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 10,
            'operand2' => 11,
            'operator' => 'MULTIPLY',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $expectedJson = '{"success":true,"data":{"result":110.0},"message":null}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }

    public function testDivideOperator(): void
    {
        $client = static::createClient();
        $data = [
            'operand1' => 13,
            'operand2' => 38,
            'operator' => 'DIVIDE',
        ];
        $client->request('POST', '/api/calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $expectedJson = '{"success":true,"data":{"result":0.34210526315789475},"message":null}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }
}
