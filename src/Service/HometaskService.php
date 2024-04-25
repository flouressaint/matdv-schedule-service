<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Hometask;
use App\Model\CreateHometaskRequest;
use App\Model\HometaskListItem;
use App\Model\IdResponse;
use App\Model\UpdateHometaskRequest;
use App\Repository\HometaskRepository;

class HometaskService
{
    public function __construct(
        private readonly HometaskRepository $hometaskRepository
    ) {
    }

    public function getHometask(int $id): HometaskListItem
    {
        $hometask = $this->hometaskRepository->getHometaskById($id);

        return new HometaskListItem($hometask->getId(), $hometask->getName());
    }

    public function createHometask(CreateHometaskRequest $request): IdResponse
    {
        $hometask = (new Hometask())->setName($request->getName());
        $this->hometaskRepository->saveAndCommit($hometask);

        return new IdResponse($hometask->getId());
    }

    public function updateHometask(int $id, UpdateHometaskRequest $request): void
    {
        $hometask = $this->hometaskRepository->getHometaskById($id);
        $hometask->setName($request->getName());
        $this->hometaskRepository->commit();
    }

    public function deleteHometask(int $id): void
    {
        $hometask = $this->hometaskRepository->getHometaskById($id);
        $this->hometaskRepository->removeAndCommit($hometask);
    }
}