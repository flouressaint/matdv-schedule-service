<?php

namespace App\Tests\Repository;

use App\Entity\Hometask;
use App\Repository\HometaskRepository;
use App\Tests\AbstractRepositoryTest;

class HometaskRepositoryTest extends AbstractRepositoryTest
{
    private HometaskRepository $hometaskRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hometaskRepository = $this->getRepositoryForEntity(Hometask::class);
    }

    public function testGetHometaskById()
    {
        $hometask = $this->createHometask('Math', 'attachment');
        $this->em->persist($hometask);
        $this->em->flush();

        $this->assertSame($hometask, $this->hometaskRepository->getHometaskById($hometask->getId()));
    }

    private function createHometask(string $description, string $attachment): Hometask
    {
        return (new Hometask())->setDescription($description)->setAttachment($attachment);
    }
}