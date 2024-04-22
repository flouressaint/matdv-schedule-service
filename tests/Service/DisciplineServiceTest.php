<?php

use App\Entity\Discipline;
use App\Exception\DisciplineNotFoundException;
use App\Model\DisciplineListItem;
use App\Model\DisciplineListResponse;
use App\Repository\DisciplineRepository;
use App\Service\DisciplineService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\Criteria;

class DisciplineServiceTest extends AbstractTestCase
{
    public function testGetDisciplines(): void
    {
        $discipline = (new Discipline())->setName('Test');
        $this->setEntityId($discipline, 7);
        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['name' => Criteria::ASC])
            ->willReturn([$discipline]);

        $service  = new DisciplineService($repository);
        $expected = new DisciplineListResponse([new DisciplineListItem(7, 'Test')]);

        $this->assertEquals($expected, $service->getDisciplines());
    }

    public function testDisciplineNotFound(): void
    {
        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with(152)
            ->willThrowException(new DisciplineNotFoundException());

        $this->expectException(DisciplineNotFoundException::class);

        (new DisciplineService($repository))->getDisciplineById(152);
    }

    public function testGetDisciplineById(): void
    {
        $discipline = (new Discipline())->setName('Test');
        $this->setEntityId($discipline, '152');
        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with(152)
            ->willReturn($discipline);

        $service  = new DisciplineService($repository);
        $expected = new DisciplineListItem(152, 'Test');

        $this->assertEquals($expected, $service->getDisciplineById(152));
    }
}