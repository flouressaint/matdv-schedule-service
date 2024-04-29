<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\StudyGroup;
use App\Entity\User;
use App\Model\CreateStudyGroupRequest;
use App\Model\IdResponse;
use App\Model\StudyGroupListItem;
use App\Model\StudyGroupListResponse;
use App\Model\UpdateStudyGroupRequest;
use App\Model\UserResponse;
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
        $studyGroups = $this->studyGroupRepository->findAllSortedByName();
        $studyGroups = array_map(
            fn (StudyGroup $studyGroup) => new StudyGroupListItem(
                $studyGroup->getId(),
                $studyGroup->getName(),
                new UserResponse($studyGroup->getTeacher()->getId(), $studyGroup->getTeacher()->getFullName()),
                array_map(
                    fn (User $student) => new UserResponse($student->getId(), $student->getFullName()),
                    $studyGroup->getStudents()->toArray()
                )
            ),
            $studyGroups
        );

        return new StudyGroupListResponse($studyGroups);
    }

    public function getStudyGroup(int $id): StudyGroupListItem
    {
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($id);
        $teacher = $studyGroup->getTeacher();
        $students = $studyGroup->getStudents()->toArray();
        $students = array_map(
            fn (User $student) => new UserResponse(
                $student->getId(),
                $student->getFullName(),
            ),
            $students
        );

        return new StudyGroupListItem(
            $studyGroup->getId(),
            $studyGroup->getName(),
            new UserResponse($teacher->getId(), $teacher->getFullName()),
            $students
        );
    }

    public function createStudyGroup(CreateStudyGroupRequest $request): IdResponse
    {
        $studyGroup = (new StudyGroup())
            ->setName($request->getName())
            ->setTeacher($this->userRepository->getTeacherById($request->getTeacherId()));
        $this->studyGroupRepository->saveAndCommit($studyGroup);

        return new IdResponse($studyGroup->getId());
    }

    public function updateStudyGroup(int $id, UpdateStudyGroupRequest $request): void
    {
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($id);
        if (null !== $request->getName()) {
            $studyGroup->setName($request->getName());
        }
        if (null !== $request->getTeacherId()) {
            $studyGroup->setTeacher($this->userRepository->getTeacherById($request->getTeacherId()));
        }
        $this->studyGroupRepository->commit();
    }

    public function deleteStudyGroup(int $id): void
    {
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($id);
        $this->studyGroupRepository->removeAndCommit($studyGroup);
    }

    public function enrollStudent(int $id, int $studentId): void
    {
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($id);
        $student = $this->userRepository->getUserById($studentId);
        if (!$studyGroup->getStudents()->contains($student)) {
            $studyGroup->addStudent($student);
        }
        $this->studyGroupRepository->commit();
    }
}