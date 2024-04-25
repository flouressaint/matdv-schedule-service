<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Hometask;
use App\Model\CreateHometaskRequest;
use App\Model\HometaskResponse;
use App\Model\IdResponse;
use App\Model\UpdateHometaskRequest;
use App\Repository\HometaskRepository;

class HometaskService
{
    public function __construct(
        private readonly HometaskRepository $hometaskRepository
    ) {
    }

    public function getHometask(int $id): HometaskResponse
    {
        $hometask = $this->hometaskRepository->getHometaskById($id);

        return new HometaskResponse($hometask->getId(), $hometask->getDescription(), $hometask->getAttachment());
    }

    public function createHometask(CreateHometaskRequest $request): IdResponse
    {
        $hometask = (new Hometask())
            ->setDescription($request->getDescription())
            ->setAttachment($request->getAttachment());
        $this->hometaskRepository->saveAndCommit($hometask);

        return new IdResponse($hometask->getId());
    }

    public function updateHometask(int $id, UpdateHometaskRequest $request): void
    {
        $hometask = $this->hometaskRepository->getHometaskById($id);
        $hometask->setDescription($request->getDescription())
                 ->setAttachment($request->getAttachment());
        $this->hometaskRepository->commit();
    }

    public function deleteHometask(int $id): void
    {
        $hometask = $this->hometaskRepository->getHometaskById($id);
        $this->hometaskRepository->removeAndCommit($hometask);
    }
}