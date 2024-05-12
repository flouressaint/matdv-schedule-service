<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Service\StudyGroupCategoryService;
use App\Service\StudyGroupService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'StudyGroups')]
class StudyGroupCategoryController extends AbstractController
{
    public function __construct(
        private readonly StudyGroupCategoryService $studyGroupCategoryService,
        private readonly StudyGroupService $studyGroupService
    ) {
    }

    #[Route(path: '/api/v1/studyGroupCategory', methods: ['GET'])]
    public function getStudyGroupCategories(): JsonResponse
    {
        return $this->json($this->studyGroupCategoryService->getStudyGroupCategories());
    }

    #[Route(path: 'api/v1/studyGroupCategory/{id}/studyGroups', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Returns study groups by category id')]
    #[OA\Response(response: 404, description: 'Study group category or study group not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'id', name: 'id', description: 'Study group category id', in: 'path', required: true)]
    public function studyGroupsByCategory(int $id): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroupsByCategory($id));
    }
}
