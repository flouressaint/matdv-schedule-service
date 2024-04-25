<?php

namespace App\Tests\Controller;

use App\Entity\Discipline;
use App\Tests\AbstractControllerTest;

class DisciplineControllerTest extends AbstractControllerTest
{
    public function testIndex(): void
    {
        $this->em->persist((new Discipline())->setName('Math'));
        $this->em->persist((new Discipline())->setName('Python'));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/discipline');
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
        $discipline = (new Discipline())->setName('Python');
        $this->em->persist($discipline);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/discipline/'.$discipline->getId());
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
        $discipline = (new Discipline())->setName('Python');
        $this->em->persist($discipline);
        $this->em->flush();

        $this->client->request('DELETE', '/api/v1/discipline/'.$discipline->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/api/v1/discipline', [
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
        $discipline = (new Discipline())->setName('Python');
        $this->em->persist($discipline);
        $this->em->flush();

        $this->client->request('PUT', '/api/v1/discipline/'.$discipline->getId(), [
            'name' => 'Math2',
        ]);

        $this->assertResponseIsSuccessful();
    }
}
