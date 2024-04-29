<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CreateStudyGroupRequest;
use App\Model\ErrorResponse;
use App\Model\UpdateStudyGroupRequest;
use App\Service\RoleService;
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
        private readonly StudyGroupService $studyGroupService
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

    // #[Route(path: 'api/v1/admin/studyGroup', methods: ['POST'])]
    // public function createStudyGroup(#[MapRequestPayload] CreateStudyGroupRequest $request): JsonResponse
    // {
    //     return $this->json($this->studyGroupService->createStudyGroup($request));
    // }

    // #[Route('api/v1/admin/studyGroup/{id}', name: 'studyGroup_update', methods: ['PATCH'])]
    // public function edit(int $id, #[MapRequestPayload] UpdateStudyGroupRequest $request): JsonResponse
    // {
    //     $this->studyGroupService->updateStudyGroup($id, $request);

    //     return $this->json(null);
    // }

    // #[Route('api/v1/admin/studyGroup/{id}', name: 'studyGroup_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    // public function delete(int $id): JsonResponse
    // {
    //     $this->studyGroupService->deleteStudyGroup($id);

    //     return $this->json(null);
    // }

    // #[Route('api/v1/admin/studyGroup/enroll/{id}', name: 'studyGroup_enroll_student', requirements: ['id' => '\d+'], methods: ['POST'])]
}