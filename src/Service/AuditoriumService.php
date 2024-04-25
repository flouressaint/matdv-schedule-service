<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Auditorium;
use App\Model\AuditoriumListItem;
use App\Model\AuditoriumListResponse;
use App\Model\CreateAuditoriumRequest;
use App\Model\IdResponse;
use App\Model\UpdateAuditoriumRequest;
use App\Repository\AuditoriumRepository;

class AuditoriumService
{
    public function __construct(
        private readonly AuditoriumRepository $auditoriumRepository
    ) {
    }

    public function getAuditoriums(): AuditoriumListResponse
    {
        $auditoriums = $this->auditoriumRepository->findAllSortedByName();
        $items = array_map(
            fn (Auditorium $auditorium) => new AuditoriumListItem(
                $auditorium->getId(),
                $auditorium->getName(),
            ),
            $auditoriums
        );

        return new AuditoriumListResponse($items);
    }

    public function getAuditorium(int $id): AuditoriumListItem
    {
        $auditorium = $this->auditoriumRepository->getAuditoriumById($id);

        return new AuditoriumListItem($auditorium->getId(), $auditorium->getName());
    }

    public function createAuditorium(CreateAuditoriumRequest $request): IdResponse
    {
        $auditorium = (new Auditorium())->setName($request->getName());
        $this->auditoriumRepository->saveAndCommit($auditorium);

        return new IdResponse($auditorium->getId());
    }

    public function updateAuditorium(int $id, UpdateAuditoriumRequest $request): void
    {
        $auditorium = $this->auditoriumRepository->getAuditoriumById($id);
        $auditorium->setName($request->getName());
        $this->auditoriumRepository->commit();
    }

    public function deleteAuditorium(int $id): void
    {
        $auditorium = $this->auditoriumRepository->getAuditoriumById($id);
        $this->auditoriumRepository->removeAndCommit($auditorium);
    }
}
