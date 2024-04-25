<?php

use App\Entity\Discipline;
use App\Exception\DisciplineNotFoundException;
use App\Model\CreateDisciplineRequest;
use App\Model\DisciplineListItem;
use App\Model\DisciplineListResponse;
use App\Model\IdResponse;
use App\Model\UpdateDisciplineRequest;
use App\Repository\DisciplineRepository;
use App\Service\DisciplineService;
use App\Tests\AbstractTestCase;

class DisciplineServiceTest extends AbstractTestCase
{
    public function testGetDisciplines(): void
    {
        $discipline = (new Discipline())->setName('Test');
        $this->setEntityId($discipline, 7);

        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
            ->method('findAllSortedByName')
            ->willReturn([$discipline]);

        $service = new DisciplineService($repository);
        $expected = new DisciplineListResponse([new DisciplineListItem(7, 'Test')]);

        $this->assertEquals($expected, $service->getDisciplines());
    }

    public function testDisciplineNotFound(): void
    {
        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
            ->method('getDisciplineById')
            ->willThrowException(new DisciplineNotFoundException());

        $this->expectException(DisciplineNotFoundException::class);

        (new DisciplineService($repository))->getDiscipline(152);
    }

    public function testGetDisciplineById(): void
    {
        $discipline = (new Discipline())->setName('Test');
        $this->setEntityId($discipline, '152');

        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
        ->method('getDisciplineById')
        ->with(152)
        ->willReturn($discipline);

        $service = new DisciplineService($repository);
        $expected = new DisciplineListItem(152, 'Test');

        $this->assertEquals($expected, $service->getDiscipline(152));
    }

    public function testCreateDiscipline(): void
    {
        $payload = new CreateDisciplineRequest();
        $payload->setName('New Discipline');

        $expectedDiscipline = (new Discipline())->setName('New Discipline');

        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
        ->method('saveAndCommit')
        ->with($expectedDiscipline)
        ->will($this->returnCallback(function (Discipline $discipline) {
            $this->setEntityId($discipline, 111);
        }));

        $service = new DisciplineService($repository);
        $this->assertEquals(new IdResponse(111), $service->createDiscipline($payload));
    }

    public function testUpdateDiscipline(): void
    {
        $discipline = new Discipline();

        $repository = $this->createMock(DisciplineRepository::class);
        $repository->expects($this->once())
        ->method('getDisciplineById')
        ->with(1)
        ->willReturn($discipline);

        $payload = (new UpdateDisciplineRequest())->setName('Old');

        $service = new DisciplineService($repository);
        $service->updateDiscipline(1, $payload);
    }
}
