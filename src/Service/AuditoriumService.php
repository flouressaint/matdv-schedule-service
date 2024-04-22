<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Auditorium;
use App\Model\AuditoriumListItem;
use App\Model\AuditoriumListResponse;
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
}
