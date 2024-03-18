<?php

use App\Entity\Discipline;
use App\Model\DisciplineListItem;
use App\Model\DisciplineListResponse;
use App\Repository\DisciplineRepository;
use App\Service\DisciplineService;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;

class DisciplineServiceTest extends TestCase
{
    public function testGetDisciplines(): void
    {
        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['name' => Criteria::ASC])
            ->willReturn([(new Discipline())->setId(7)->setName('Test')]);

        $service  = new DisciplineService($repository);
        $expected = new DisciplineListResponse([new DisciplineListItem(7, 'Test')]);

        $this->assertEquals($expected, $service->getDisciplines());
    }
}