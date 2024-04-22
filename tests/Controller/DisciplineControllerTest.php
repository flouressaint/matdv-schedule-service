<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DisciplineControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/discipline');
        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/responses/DisciplineControllerTest_testIndex.json',
            $responseContent
        );
    }
    public function testShow(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/discipline/1');
        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/responses/DisciplineControllerTest_testShow.json',
            $responseContent
        );
    }
}