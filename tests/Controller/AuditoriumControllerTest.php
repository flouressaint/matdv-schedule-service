<?php

namespace App\Tests\Controller;

use App\Entity\Auditorium;
use App\Tests\AbstractControllerTest;

class AuditoriumControllerTest extends AbstractControllerTest
{
    public function testIndex(): void
    {
        $this->em->persist((new Auditorium())->setName('Math'));
        $this->em->persist((new Auditorium())->setName('Python'));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/auditorium');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'name'],
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'id' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testShow(): void
    {
        $auditorium = (new Auditorium())->setName('Python');
        $this->em->persist($auditorium);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/auditorium/'.$auditorium->getId());
        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['id', 'name'],
            'properties' => [
                'name' => ['type' => 'string'],
                'id' => ['type' => 'integer'],
            ],
        ]);
    }

    public function testDelete(): void
    {
        $auditorium = (new Auditorium())->setName('Python');
        $this->em->persist($auditorium);
        $this->em->flush();

        $this->client->request('DELETE', '/api/v1/auditorium/'.$auditorium->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/api/v1/auditorium', [
            'name' => 'Math2',
        ]);

        $this->assertJsonDocumentMatchesSchema(json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR), [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ]);
        $this->assertResponseIsSuccessful();
    }

    public function testUpdate(): void
    {
        $auditorium = (new Auditorium())->setName('Python');
        $this->em->persist($auditorium);
        $this->em->flush();

        $this->client->request('PUT', '/api/v1/auditorium/'.$auditorium->getId(), [
            'name' => 'Math2',
        ]);

        $this->assertResponseIsSuccessful();
    }
}