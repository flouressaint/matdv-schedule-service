<?php

use App\Entity\Auditorium;
use App\Exception\AuditoriumNotFoundException;
use App\Model\AuditoriumListItem;
use App\Model\AuditoriumListResponse;
use App\Model\CreateAuditoriumRequest;
use App\Model\IdResponse;
use App\Model\UpdateAuditoriumRequest;
use App\Repository\AuditoriumRepository;
use App\Service\AuditoriumService;
use App\Tests\AbstractTestCase;

class AuditoriumServiceTest extends AbstractTestCase
{
    public function testGetAuditoriums(): void
    {
        $auditorium = (new Auditorium())->setName('Test');
        $this->setEntityId($auditorium, 7);

        $repository = $this->createMock(AuditoriumRepository::class);
        $repository->expects($this->once())
            ->method('findAllSortedByName')
            ->willReturn([$auditorium]);

        $service = new AuditoriumService($repository);
        $expected = new AuditoriumListResponse([new AuditoriumListItem(7, 'Test')]);

        $this->assertEquals($expected, $service->getAuditoriums());
    }

    public function testAuditoriumNotFound(): void
    {
        $repository = $this->createMock(AuditoriumRepository::class);
        $repository->expects($this->once())
            ->method('getAuditoriumById')
            ->willThrowException(new AuditoriumNotFoundException());

        $this->expectException(AuditoriumNotFoundException::class);

        (new AuditoriumService($repository))->getAuditorium(152);
    }

    public function testGetAuditoriumById(): void
    {
        $auditorium = (new Auditorium())->setName('Test');
        $this->setEntityId($auditorium, '152');

        $repository = $this->createMock(AuditoriumRepository::class);
        $repository->expects($this->once())
        ->method('getAuditoriumById')
        ->with(152)
        ->willReturn($auditorium);

        $service = new AuditoriumService($repository);
        $expected = new AuditoriumListItem(152, 'Test');

        $this->assertEquals($expected, $service->getAuditorium(152));
    }

    public function testCreateAuditorium(): void
    {
        $payload = new CreateAuditoriumRequest();
        $payload->setName('New Auditorium');

        $expectedAuditorium = (new Auditorium())->setName('New Auditorium');

        $repository = $this->createMock(AuditoriumRepository::class);
        $repository->expects($this->once())
        ->method('saveAndCommit')
        ->with($expectedAuditorium)
        ->will($this->returnCallback(function (Auditorium $auditorium) {
            $this->setEntityId($auditorium, 111);
        }));

        $service = new AuditoriumService($repository);
        $this->assertEquals(new IdResponse(111), $service->createAuditorium($payload));
    }

    public function testUpdateAuditorium(): void
    {
        $auditorium = new Auditorium();

        $repository = $this->createMock(AuditoriumRepository::class);
        $repository->expects($this->once())
        ->method('getAuditoriumById')
        ->with(1)
        ->willReturn($auditorium);

        $payload = (new UpdateAuditoriumRequest())->setName('Old');

        $service = new AuditoriumService($repository);
        $service->updateAuditorium(1, $payload);
    }
}