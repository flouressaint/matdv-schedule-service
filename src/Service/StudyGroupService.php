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
use App\Repository\UserRepository;

class StudyGroupService
{
    public function __construct(
        private readonly StudyGroupRepository $studyGroupRepository,
        private readonly UserRepository $userRepository
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
        $studygroup = $this->studyGroupRepository->getStudyGroupById($id);

        return new StudyGroupListItem($studygroup->getId(), $studygroup->getName());
    }

    public function createStudyGroup(CreateStudyGroupRequest $request): IdResponse
    {
        $studygroup = (new StudyGroup())
            ->setName($request->getName())
            ->setTeacher($this->userRepository->getTeacherById($request->getTeacherId()));
        $this->studyGroupRepository->saveAndCommit($studygroup);

        return new IdResponse($studygroup->getId());
    }

    public function updateStudyGroup(int $id, UpdateStudyGroupRequest $request): void
    {
        $studygroup = $this->studyGroupRepository->getStudyGroupById($id);
        $studygroup->setName($request->getName());
        $this->studyGroupRepository->commit();
    }

    public function deleteStudyGroup(int $id): void
    {
        $studygroup = $this->studyGroupRepository->getStudyGroupById($id);
        $this->studyGroupRepository->removeAndCommit($studygroup);
    }
}