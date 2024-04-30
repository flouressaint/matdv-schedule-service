<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\StudyGroupCategory;
use App\Model\CreateStudyGroupCategoryRequest;
use App\Model\IdResponse;
use App\Model\StudyGroupCategoryListItem;
use App\Model\StudyGroupCategoryListResponse;
use App\Model\UpdateStudyGroupCategoryRequest;
use App\Repository\StudyGroupCategoryRepository;

class StudyGroupCategoryService
{
    public function __construct(
        private readonly StudyGroupCategoryRepository $studyGroupCategoryRepository,
    ) {
    }

    public function getStudyGroupCategories(): StudyGroupCategoryListResponse
    {
        $studyGroupCategories = $this->studyGroupCategoryRepository->findAllSortedByName();
        $items = array_map(
            fn (StudyGroupCategory $studyGroupCategory) => new StudyGroupCategoryListItem(
                $studyGroupCategory->getId(),
                $studyGroupCategory->getName(),
            ),
            $studyGroupCategories
        );

        return new StudyGroupCategoryListResponse($items);
    }

    public function getStudyGroupCategory(int $id): StudyGroupCategoryListItem
    {
        $studyGroupCategory = $this->studyGroupCategoryRepository->getStudyGroupCategoryById($id);

        return new StudyGroupCategoryListItem(
            $studyGroupCategory->getId(),
            $studyGroupCategory->getName(),
        );
    }

    public function createStudyGroupCategory(CreateStudyGroupCategoryRequest $request): IdResponse
    {
        $studyGroupCategory = (new StudyGroupCategory())
            ->setName($request->getName());
        $this->studyGroupCategoryRepository->saveAndCommit($studyGroupCategory);

        return new IdResponse($studyGroupCategory->getId());
    }

    public function updateStudyGroupCategory(int $id, UpdateStudyGroupCategoryRequest $request): void
    {
        $studyGroupCategory = $this->studyGroupCategoryRepository->getStudyGroupCategoryById($id);
        $studyGroupCategory->setName($request->getName());
        $this->studyGroupCategoryRepository->commit();
    }

    public function deleteStudyGroupCategory(int $id): void
    {
        $studyGroupCategory = $this->studyGroupCategoryRepository->getStudyGroupCategoryById($id);
        $this->studyGroupCategoryRepository->removeAndCommit($studyGroupCategory);
    }
}