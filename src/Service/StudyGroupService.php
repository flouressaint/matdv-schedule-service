<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\StudyGroup;
use App\Entity\User;
use App\Exception\StudentAlreadyEnrolledException;
use App\Exception\StudyGroupAlreadyExistsException;
use App\Model\CreateStudyGroupRequest;
use App\Model\IdResponse;
use App\Model\StudyGroupCategoryListItem;
use App\Model\StudyGroupListItem;
use App\Model\StudyGroupListResponse;
use App\Model\StudyGroupResponse;
use App\Model\UpdateStudyGroupRequest;
use App\Model\UserResponse;
use App\Repository\StudyGroupCategoryRepository;
use App\Repository\StudyGroupRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class StudyGroupService
{
    public function __construct(
        private readonly StudyGroupRepository $studyGroupRepository,
        private readonly StudyGroupCategoryRepository $studyGroupCategoryRepository,
        private readonly UserRepository $userRepository
    ) {
    }

    public function getStudyGroups(): StudyGroupListResponse
    {
        $studyGroups = $this->studyGroupRepository->findAllWithCategorySortedByCategory();
        $studyGroups = array_map(
            fn (StudyGroup $studyGroup) => new StudyGroupListItem(
                $studyGroup->getId(),
                $studyGroup->getName(),
                new StudyGroupCategoryListItem(
                    $studyGroup->getStudyGroupCategory()->getId(),
                    $studyGroup->getStudyGroupCategory()->getName()
                ),
                new UserResponse(
                    $studyGroup->getTeacher()->getId(),
                    $studyGroup->getTeacher()->getFullName()
                )
            ),
            $studyGroups
        );

        return new StudyGroupListResponse($studyGroups);
    }

    public function getStudyGroupsForTeacher(UserInterface $user): StudyGroupListResponse
    {
        $studyGroups = $this->studyGroupRepository->findAllSortedByName();
        $studyGroups = array_filter($studyGroups, fn (StudyGroup $studyGroup) => $studyGroup->getTeacher() === $user);
        $studyGroups = array_map(
            fn (StudyGroup $studyGroup) => new StudyGroupListItem(
                $studyGroup->getId(),
                $studyGroup->getName(),
                new StudyGroupCategoryListItem(
                    $studyGroup->getStudyGroupCategory()->getId(),
                    $studyGroup->getStudyGroupCategory()->getName()
                ),
                new UserResponse(
                    $studyGroup->getTeacher()->getId(),
                    $studyGroup->getTeacher()->getFullName()
                ),
            ),
            $studyGroups
        );

        return new StudyGroupListResponse($studyGroups);
    }

    public function getStudyGroupsForStudent(UserInterface $user): StudyGroupListResponse
    {
        $studyGroups = $this->studyGroupRepository->findAllSortedByName();
        $studyGroups = array_filter($studyGroups, fn (StudyGroup $studyGroup) => $studyGroup->getStudents()->contains($user));
        $studyGroups = array_map(
            fn (StudyGroup $studyGroup) => new StudyGroupListItem(
                $studyGroup->getId(),
                $studyGroup->getName(),
                new StudyGroupCategoryListItem(
                    $studyGroup->getStudyGroupCategory()->getId(),
                    $studyGroup->getStudyGroupCategory()->getName()
                ),
                new UserResponse(
                    $studyGroup->getTeacher()->getId(),
                    $studyGroup->getTeacher()->getFullName()
                ),
            ),
            $studyGroups
        );

        return new StudyGroupListResponse($studyGroups);
    }

    public function getStudyGroupsByCategory(int $categoryId): StudyGroupListResponse
    {
        $studyGroups = $this->studyGroupRepository->getStudyGroupsByCategoryId($categoryId);
        $studyGroups = array_map(
            fn (StudyGroup $studyGroup) => new StudyGroupListItem(
                $studyGroup->getId(),
                $studyGroup->getName(),
                category: null,
                teacher: new UserResponse($studyGroup->getTeacher()->getId(), $studyGroup->getTeacher()->getFullName()),
            ),
            $studyGroups
        );

        return new StudyGroupListResponse($studyGroups);
    }

    public function getStudyGroup(int $id): StudyGroupResponse
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

        return new StudyGroupResponse(
            $studyGroup->getId(),
            $studyGroup->getName(),
            new StudyGroupCategoryListItem(
                $studyGroup->getStudyGroupCategory()->getId(),
                $studyGroup->getStudyGroupCategory()->getName()
            ),
            new UserResponse($teacher->getId(), $teacher->getFullName()),
            $students
        );
    }

    public function createStudyGroup(CreateStudyGroupRequest $request): IdResponse
    {
        if ($this->studyGroupRepository->existsByName($request->getName())) {
            throw new StudyGroupAlreadyExistsException();
        }
        $studyGroup = (new StudyGroup())
            ->setName($request->getName())
            ->setTeacher($this->userRepository->getTeacherById($request->getTeacherId()))
            ->setStudyGroupCategory($this->studyGroupCategoryRepository->getStudyGroupCategoryById($request->getCategoryId()));
        $this->studyGroupRepository->saveAndCommit($studyGroup);

        return new IdResponse($studyGroup->getId());
    }

    public function updateStudyGroup(int $id, UpdateStudyGroupRequest $request): void
    {
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($id);
        if ($request->getName() !== $studyGroup->getName() && $this->studyGroupRepository->existsByName($request->getName())) {
            throw new StudyGroupAlreadyExistsException();
        }
        if (null !== $request->getName()) {
            $studyGroup->setName($request->getName());
        }
        if (null !== $request->getTeacherId()) {
            $studyGroup->setTeacher($this->userRepository->getTeacherById($request->getTeacherId()));
        }

        if (null !== $request->getCategoryId()) {
            $studyGroup->setStudyGroupCategory($this->studyGroupCategoryRepository->getStudyGroupCategoryById($request->getCategoryId()));
        }
        $this->studyGroupRepository->commit();
    }

    public function deleteStudyGroup(int $id): void
    {
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($id);
        $this->studyGroupRepository->removeAndCommit($studyGroup);
    }

    public function enrollStudent(int $id, string $studentUsername): void
    {
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($id);
        $student = $this->userRepository->getUserByUsername($studentUsername);
        if ($studyGroup->getStudents()->contains($student)) {
            throw new StudentAlreadyEnrolledException();
        }
        $studyGroup->addStudent($student);
        $this->studyGroupRepository->commit();
    }
}
