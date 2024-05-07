<?php

namespace App\Tests\Controller;

use App\Entity\Hometask;
use App\Tests\AbstractControllerTest;

class HometaskControllerTest extends AbstractControllerTest
{
    public function testShow(): void
    {
        $hometask = (new Hometask())->setDescription('hometask2')->setAttachment('attachment2');
        $this->em->persist($hometask);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/hometask/'.$hometask->getId());
        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['id', 'description', 'attachment'],
            'properties' => [
                'description' => ['type' => 'string'],
                'attachment' => ['type' => 'string'],
                'id' => ['type' => 'integer'],
            ],
        ]);
    }

    public function testDelete(): void
    {
        $hometask = (new Hometask())->setDescription('hometask2')->setAttachment('attachment2');
        $this->em->persist($hometask);
        $this->em->flush();

        $this->client->request('DELETE', '/api/v1/admin/hometask/'.$hometask->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/api/v1/admin/hometask', [
            'description' => 'hometask2',
            'attachment' => 'attachment2',
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
        $hometask = (new Hometask())->setDescription('hometask2')->setAttachment('attachment2');
        $this->em->persist($hometask);
        $this->em->flush();

        $this->client->request('PUT', '/api/v1/hometask/'.$hometask->getId(), [
            'description' => 'hometask3',
            'attachment' => 'attachment3',
        ]);

        $this->assertResponseIsSuccessful();
    }
}
