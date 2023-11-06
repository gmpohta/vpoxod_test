<?php

declare(strict_types=1);

namespace App\Tests\AgeCalculator;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AgeCalculatorTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testExecuteWithValidData(): void
    {
        $client = static::createClient();
        $data = [
            'birthday' => '01.01.2000',
            'dateFrom' => '02.05.2020',
        ];
        $client->request('POST', '/api/age-calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $expectedJson = '{"success":true,"data":{"age":"20 years 4 mounth 1 days"},"message":null,"code":200}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }

    public function testExecuteWithInvalidData(): void
    {
        $client = static::createClient();
        $data = [
            'birthday' => '01.01.2000',
            'dateFrom' => '02.05.1020',
        ];
        $client->request('POST', '/api/age-calculate', [], [], [], json_encode($data, JSON_THROW_ON_ERROR));
        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $expectedJson = '{"success":false,"data":["Birthday must be higter than dateFrom"],"message":"error validation"}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent() ? $response->getContent() : '');
    }
}
