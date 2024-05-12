<?php

use App\Entity\Hometask;
use App\Exception\HometaskNotFoundException;
use App\Model\CreateHometaskRequest;
use App\Model\HometaskResponse;
use App\Model\IdResponse;
use App\Repository\HometaskRepository;
use App\Service\HometaskService;
use App\Tests\AbstractTestCase;

class HometaskServiceTest extends AbstractTestCase
{
    public function testHometaskNotFound(): void
    {
        $repository = $this->createMock(HometaskRepository::class);
        $repository->expects($this->once())
            ->method('getHometaskById')
            ->willThrowException(new HometaskNotFoundException());

        $this->expectException(HometaskNotFoundException::class);

        (new HometaskService($repository))->getHometask(152);
    }

    public function testGetHometaskById(): void
    {
        $hometask = (new Hometask())->setDescription('Test')->setAttachment('test');
        $this->setEntityId($hometask, '152');

        $repository = $this->createMock(HometaskRepository::class);
        $repository->expects($this->once())
        ->method('getHometaskById')
        ->with(152)
        ->willReturn($hometask);

        $service = new HometaskService($repository);
        $expected = new HometaskResponse(152, 'Test', 'test');

        $this->assertEquals($expected, $service->getHometask(152));
    }

    public function testCreateHometask(): void
    {
        $payload = new CreateHometaskRequest();
        $payload->setDescription('New Hometask')->setAttachment('test');

        $expectedHometask = (new Hometask())->setDescription('New Hometask')->setAttachment('test');

        $repository = $this->createMock(HometaskRepository::class);
        $repository->expects($this->once())
        ->method('saveAndCommit')
        ->with($expectedHometask)
        ->will($this->returnCallback(function (Hometask $hometask) {
            $this->setEntityId($hometask, 111);
        }));

        $service = new HometaskService($repository);
        $this->assertEquals(new IdResponse(111), $service->createHometask($payload));
    }

    public function testUpdateHometask(): void
    {
        $hometask = new Hometask();

        $repository = $this->createMock(HometaskRepository::class);
        $repository->expects($this->once())
        ->method('getHometaskById')
        ->with(1)
        ->willReturn($hometask);

        $payload = (new CreateHometaskRequest())->setDescription('Old')->setAttachment('Old');

        $service = new HometaskService($repository);
        $service->updateHometask(1, $payload);
    }
}
