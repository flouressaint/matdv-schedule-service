<?php

namespace App\Controller;

use App\Service\StudyGroupCategoryService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'StudyGroupCategory')]
class StudyGroupCategoryController extends AbstractController
{
    public function __construct(
        private readonly StudyGroupCategoryService $studyGroupCategoryService
    ) {
    }

    #[Route(path: '/api/v1/studyGroupCategory', methods: ['GET'])]
    public function getStudyGroupCategories(): JsonResponse
    {
        return $this->json($this->studyGroupCategoryService->getStudyGroupCategories());
    }

    #[Route(path: 'api/v1/studyGroupCategory/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getStudyGroupCategory(int $id): JsonResponse
    {
        return $this->json($this->studyGroupCategoryService->getStudyGroupCategory($id));
    }
}