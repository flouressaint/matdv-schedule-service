<?php

namespace App\Tests\Repository;

use App\Entity\Auditorium;
use App\Repository\AuditoriumRepository;
use App\Tests\AbstractRepositoryTest;

class AuditoriumRepositoryTest extends AbstractRepositoryTest
{
    private AuditoriumRepository $auditoriumRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auditoriumRepository = $this->getRepositoryForEntity(Auditorium::class);
    }

    public function testFindAllSortedByName()
    {
        for ($i = 0; $i < 5; ++$i) {
            $auditorium = $this->createAuditorium('cabinet-'.$i);
            $this->em->persist($auditorium);
        }

        $this->em->flush();

        $this->assertCount(5, $this->auditoriumRepository->findAllSortedByName());
    }

    private function createAuditorium(string $name): Auditorium
    {
        return (new Auditorium())->setName($name);
    }
}
