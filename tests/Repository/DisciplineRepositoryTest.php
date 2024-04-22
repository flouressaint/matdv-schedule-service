<?php

namespace App\Tests\Repository;

use App\Entity\Discipline;
use App\Repository\DisciplineRepository;
use App\Tests\AbstractRepositoryTest;

class DisciplineRepositoryTest extends AbstractRepositoryTest
{
    private DisciplineRepository $disciplineRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->disciplineRepository = $this->getRepositoryForEntity(Discipline::class);
    }

    public function testFindAllSortedByName()
    {
        for ($i = 0; $i < 5; ++$i) {
            $discipline = $this->createDiscipline('Math-'.$i);
            $this->em->persist($discipline);
        }

        $this->em->flush();

        $this->assertCount(5, $this->disciplineRepository->findAllSortedByName());
    }

    private function createDiscipline(string $name): Discipline
    {
        return (new Discipline())->setName($name);
    }
}
