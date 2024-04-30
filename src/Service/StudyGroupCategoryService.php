<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\StudyGroupCategory;
use App\Entity\User;
use App\Model\CreateStudyGroupCategoryRequest;
use App\Model\IdResponse;
use App\Model\StudyGroupCategoryListItem;
use App\Model\StudyGroupCategoryListResponse;
use App\Model\UpdateStudyGroupCategoryRequest;
use App\Model\UserResponse;
use App\Repository\StudyGroupCategoryRepository;

class StudyGroupCategoryService
{
    public function __construct(
        private readonly StudyGroupCategoryRepository $studyGroupCategoryRepository,
    ) {
    }

    // public function getStudyGroupCategorys(): StudyGroupCategoryListResponse
    // {
    //     $studyGroupCategorys = $this->studyGroupCategoryRepository->findAllSortedByName();
    //     $studyGroupCategorys = array_map(
    //         fn (StudyGroupCategory $studyGroupCategory) => new StudyGroupCategoryListItem(
    //             $studyGroupCategory->getId(),
    //             $studyGroupCategory->getName(),
    //             new UserResponse($studyGroupCategory->getTeacher()->getId(), $studyGroupCategory->getTeacher()->getFullName()),
    //             array_map(
    //                 fn (User $student) => new UserResponse($student->getId(), $student->getFullName()),
    //                 $studyGroupCategory->getStudents()->toArray()
    //             )
    //         ),
    //         $studyGroupCategorys
    //     );

    //     return new StudyGroupCategoryListResponse($studyGroupCategorys);
    // }

    // public function getStudyGroupCategory(int $id): StudyGroupCategoryListItem
    // {
    //     $studyGroupCategory = $this->studyGroupCategoryRepository->getStudyGroupCategoryById($id);
    //     $teacher = $studyGroupCategory->getTeacher();
    //     $students = $studyGroupCategory->getStudents()->toArray();
    //     $students = array_map(
    //         fn (User $student) => new UserResponse(
    //             $student->getId(),
    //             $student->getFullName(),
    //         ),
    //         $students
    //     );

    //     return new StudyGroupCategoryListItem(
    //         $studyGroupCategory->getId(),
    //         $studyGroupCategory->getName(),
    //         new UserResponse($teacher->getId(), $teacher->getFullName()),
    //         $students
    //     );
    // }

    public function createStudyGroupCategory(CreateStudyGroupCategoryRequest $request): IdResponse
    {
        $studyGroupCategory = (new StudyGroupCategory())
            ->setName($request->getName());
        $this->studyGroupCategoryRepository->saveAndCommit($studyGroupCategory);

        return new IdResponse($studyGroupCategory->getId());
    }

    // public function updateStudyGroupCategory(int $id, UpdateStudyGroupCategoryRequest $request): void
    // {
    //     $studyGroupCategory = $this->studyGroupCategoryRepository->getStudyGroupCategoryById($id);
    //     if (null !== $request->getName()) {
    //         $studyGroupCategory->setName($request->getName());
    //     }
    //     if (null !== $request->getTeacherId()) {
    //         $studyGroupCategory->setTeacher($this->userRepository->getTeacherById($request->getTeacherId()));
    //     }
    //     $this->studyGroupCategoryRepository->commit();
    // }

    // public function deleteStudyGroupCategory(int $id): void
    // {
    //     $studyGroupCategory = $this->studyGroupCategoryRepository->getStudyGroupCategoryById($id);
    //     $this->studyGroupCategoryRepository->removeAndCommit($studyGroupCategory);
    // }
}