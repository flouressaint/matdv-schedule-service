<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CreateStudyGroupCategoryRequest;
use App\Model\CreateStudyGroupRequest;
use App\Model\ErrorResponse;
use App\Model\UpdateStudyGroupCategoryRequest;
use App\Model\UpdateStudyGroupRequest;
use App\Service\RoleService;
use App\Service\StudyGroupCategoryService;
use App\Service\StudyGroupService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly RoleService $roleService,
        private readonly StudyGroupService $studyGroupService,
        private readonly StudyGroupCategoryService $studyGroupCategoryService
    ) {
    }

    #[Route(path: '/api/v1/admin/grantTeacher/{userId}', methods: ['POST'])]
    #[OA\Tag(name: 'Admin API')]
    #[OA\Response(response: 200, description: 'Grants ROLE_TEACHER to a user')]
    #[OA\Response(response: 404, description: 'User not found', attachables: [new Model(type: ErrorResponse::class)])]
    public function grantTeacher(int $userId): Response
    {
        $this->roleService->grantTeacher($userId);

        return $this->json(null);
    }

    #[Route(path: '/api/v1/admin/studyGroup', name: 'studyGroup_index', methods: ['GET'])]
    public function getStudyGroups(): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroups());
    }

    #[Route(path: '/api/v1/admin/studyGroup/{id}', name: 'studyGroup_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getStudyGroup(int $id): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroup($id));
    }

    #[Route(path: 'api/v1/admin/studyGroup', methods: ['POST'])]
    public function createStudyGroup(#[MapRequestPayload] CreateStudyGroupRequest $request): JsonResponse
    {
        return $this->json($this->studyGroupService->createStudyGroup($request));
    }

    #[Route('api/v1/admin/studyGroup/{id}', name: 'studyGroup_update', methods: ['PATCH'])]
    public function edit(int $id, #[MapRequestPayload] UpdateStudyGroupRequest $request): JsonResponse
    {
        $this->studyGroupService->updateStudyGroup($id, $request);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroup/{id}', name: 'studyGroup_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->studyGroupService->deleteStudyGroup($id);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroup/{studyGroupId}/enroll/{studentId}', name: 'studyGroup_enroll_student', requirements: ['studyGroupId' => '\d+', 'studentId' => '\d+'], methods: ['POST'])]
    public function enrollStudent(int $studyGroupId, int $studentId): JsonResponse
    {
        $this->studyGroupService->enrollStudent($studyGroupId, $studentId);

        return $this->json(null);
    }

    #[Route(path: '/api/v1/admin/studyGroupCategory', name: 'studyGroup_index', methods: ['GET'])]
    public function getStudyGroupCategories(): JsonResponse
    {
        return $this->json($this->studyGroupCategoryService->getStudyGroupCategories());
    }

    #[Route(path: 'api/v1/admin/studyGroupCategory/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getStudyGroupCategory(int $id): JsonResponse
    {
        return $this->json($this->studyGroupCategoryService->getStudyGroupCategory($id));
    }

    #[Route(path: 'api/v1/admin/studyGroupCategory', methods: ['POST'])]
    public function createStudyGroupCategory(#[MapRequestPayload] CreateStudyGroupCategoryRequest $request): JsonResponse
    {
        return $this->json($this->studyGroupCategoryService->createStudyGroupCategory($request));
    }

    #[Route('api/v1/admin/studyGroupCategory/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function editStudyGroupCategory(int $id, #[MapRequestPayload] UpdateStudyGroupCategoryRequest $request): JsonResponse
    {
        $this->studyGroupCategoryService->updateStudyGroupCategory($id, $request);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroupCategory/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteStudyGroupCategory(int $id): JsonResponse
    {
        $this->studyGroupCategoryService->deleteStudyGroupCategory($id);

        return $this->json(null);
    }

    #[Route(path: '/api/v1/studyGroupCategory/{id}/studygroups', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function studyGroupsByCategory(int $id): Response
    {
        return $this->json($this->studyGroupService->getStudyGroupsByCategory($id));
    }
}