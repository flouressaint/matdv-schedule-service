<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\StudyGroup;
use App\Model\CreateStudyGroupRequest;
use App\Model\IdResponse;
use App\Model\StudyGroupListItem;
use App\Model\StudyGroupListResponse;
use App\Model\UpdateStudyGroupRequest;
use App\Repository\StudyGroupRepository;

class StudyGroupService
{
    public function __construct(
        private readonly StudyGroupRepository $studygroupRepository
    ) {
    }

    public function getStudyGroups(): StudyGroupListResponse
    {
        $studygroups = $this->studygroupRepository->findAllSortedByName();
        $items = array_map(
            fn (StudyGroup $studygroup) => new StudyGroupListItem(
                $studygroup->getId(),
                $studygroup->getName(),
            ),
            $studygroups
        );

        return new StudyGroupListResponse($items);
    }

    public function getStudyGroup(int $id): StudyGroupListItem
    {
        $studygroup = $this->studygroupRepository->getStudyGroupById($id);

        return new StudyGroupListItem($studygroup->getId(), $studygroup->getName());
    }

    public function createStudyGroup(CreateStudyGroupRequest $request): IdResponse
    {
        $studygroup = (new StudyGroup())->setName($request->getName());
        $this->studygroupRepository->saveAndCommit($studygroup);

        return new IdResponse($studygroup->getId());
    }

    public function updateStudyGroup(int $id, UpdateStudyGroupRequest $request): void
    {
        $studygroup = $this->studygroupRepository->getStudyGroupById($id);
        $studygroup->setName($request->getName());
        $this->studygroupRepository->commit();
    }

    public function deleteStudyGroup(int $id): void
    {
        $studygroup = $this->studygroupRepository->getStudyGroupById($id);
        $this->studygroupRepository->removeAndCommit($studygroup);
    }
}