<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Discipline;
use App\Model\DisciplineListItem;
use App\Model\DisciplineListResponse;
use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\Criteria;

class DisciplineService
{
    public function __construct(
        private readonly DisciplineRepository $disciplineRepository
    ) {
    }

    public function getDisciplines(): DisciplineListResponse
    {
        $disciplines = $this->disciplineRepository->findBy([], ['name' => Criteria::ASC]);
        $items       = array_map(
            fn(Discipline $discipline) => new DisciplineListItem(
                $discipline->getId(),
                $discipline->getName(),
            ),
            $disciplines
        );
        return new DisciplineListResponse($items);
    }

    public function addDiscipline(Discipline $discipline): int
    {
        $this->disciplineRepository->add($discipline);
        return $discipline->getId();
    }
}