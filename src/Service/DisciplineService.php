<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Discipline;
use App\Model\CreateDisciplineRequest;
use App\Model\DisciplineListItem;
use App\Model\DisciplineListResponse;
use App\Model\UpdateDisciplineRequest;
use App\Repository\DisciplineRepository;

class DisciplineService
{
    public function __construct(
        private readonly DisciplineRepository $disciplineRepository
    ) {
    }

    public function getDisciplines(): DisciplineListResponse
    {
        $disciplines = $this->disciplineRepository->findAllSortedByName();
        $items = array_map(
            fn (Discipline $discipline) => new DisciplineListItem(
                $discipline->getId(),
                $discipline->getName(),
            ),
            $disciplines
        );

        return new DisciplineListResponse($items);
    }

    public function getDiscipline(int $id): DisciplineListItem
    {
        $discipline = $this->disciplineRepository->getDisciplineById($id);

        return new DisciplineListItem($discipline->getId(), $discipline->getName());
    }

    public function updateDiscipline(int $id, UpdateDisciplineRequest $request): void
    {
        $discipline = $this->disciplineRepository->getDisciplineById($id);
        $discipline->setName($request->getName());
        $this->disciplineRepository->commit();
    }

    public function createDiscipline(CreateDisciplineRequest $request): int
    {
        $discipline = (new Discipline())->setName($request->getName());
        $this->disciplineRepository->saveAndCommit($discipline);

        return $discipline->getId();
    }

    public function deleteDiscipline(int $id): void
    {
        $discipline = $this->disciplineRepository->getDisciplineById($id);
        $this->disciplineRepository->removeAndCommit($discipline);
    }
}
