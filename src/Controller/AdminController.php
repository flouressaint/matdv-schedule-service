<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CreateAuditoriumRequest;
use App\Model\CreateLessonRequest;
use App\Model\CreateStudyGroupCategoryRequest;
use App\Model\CreateStudyGroupRequest;
use App\Model\ErrorResponse;
use App\Model\UpdateAuditoriumRequest;
use App\Model\UpdateStudyGroupCategoryRequest;
use App\Model\UpdateStudyGroupRequest;
use App\Service\AuditoriumService;
use App\Service\LessonService;
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

#[OA\Tag(name: 'Admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private readonly RoleService $roleService,
        private readonly AuditoriumService $auditoriumService,
        private readonly StudyGroupService $studyGroupService,
        private readonly StudyGroupCategoryService $studyGroupCategoryService,
        private readonly LessonService $lessonService
    ) {
    }

    #[Route(path: '/api/v1/admin/grantTeacher/{username}', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Grants ROLE_TEACHER to a user')]
    #[OA\Response(response: 404, description: 'User not found', attachables: [new Model(type: ErrorResponse::class)])]
    public function grantTeacher(string $username): Response
    {
        $this->roleService->grantTeacher($username);

        return $this->json(null);
    }

    #[Route('/api/v1/admin/auditoriums', methods: ['GET'])]
    public function auditoriums(): JsonResponse
    {
        return $this->json($this->auditoriumService->getAuditoriums());
    }

    #[Route('/api/v1/admin/auditorium', methods: ['POST'])]
    public function createAuditorium(#[MapRequestPayload] CreateAuditoriumRequest $request): JsonResponse
    {
        return $this->json($this->auditoriumService->createAuditorium($request));
    }

    #[Route('/api/v1/admin/auditorium/{id}', methods: ['PUT'])]
    public function updateAuditorium(int $id, #[MapRequestPayload] UpdateAuditoriumRequest $request): JsonResponse
    {
        $this->auditoriumService->updateAuditorium($id, $request);

        return $this->json(null);
    }

    #[Route('/api/v1/admin/auditorium/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->auditoriumService->deleteAuditorium($id);

        return $this->json(null);
    }

    #[Route(path: '/api/v1/admin/studyGroups', methods: ['GET'])]
    public function StudyGroups(): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroups());
    }

    #[Route(path: '/api/v1/admin/studyGroup/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getStudyGroup(int $id): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroup($id));
    }

    #[Route(path: 'api/v1/admin/studyGroup', methods: ['POST'])]
    public function createStudyGroup(#[MapRequestPayload] CreateStudyGroupRequest $request): JsonResponse
    {
        return $this->json($this->studyGroupService->createStudyGroup($request));
    }

    #[Route('api/v1/admin/studyGroup/{id}', methods: ['PATCH'])]
    public function editStudyGroup(int $id, #[MapRequestPayload] UpdateStudyGroupRequest $request): JsonResponse
    {
        $this->studyGroupService->updateStudyGroup($id, $request);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroup/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteStudyGroup(int $id): JsonResponse
    {
        $this->studyGroupService->deleteStudyGroup($id);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroup/{studyGroupId}/enroll/{studentUsername}', requirements: ['studyGroupId' => '\d+'], methods: ['POST'])]
    public function enrollStudent(int $studyGroupId, string $studentUsername): JsonResponse
    {
        $this->studyGroupService->enrollStudent($studyGroupId, $studentUsername);

        return $this->json(null);
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

    #[Route(path: 'api/v1/admin/studyGroupCategory/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function studyGroupsByCategory(int $id): Response
    {
        return $this->json($this->studyGroupService->getStudyGroupsByCategory($id));
    }

    #[Route(path: '/api/v1/admin/lesson', methods: ['GET'])]
    public function getLessons(): JsonResponse
    {
        return $this->json($this->lessonService->getLessons());
    }

    #[Route(path: '/api/v1/admin/lesson/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getLesson(int $id): JsonResponse
    {
        return $this->json($this->lessonService->getLesson($id));
    }

    #[Route(path: '/api/v1/admin/lesson', methods: ['POST'])]
    public function createLesson(#[MapRequestPayload] CreateLessonRequest $request): JsonResponse
    {
        return $this->json($this->lessonService->createLesson($request));
    }

    #[Route('/api/v1/admin/lesson/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteLesson(int $id): JsonResponse
    {
        $this->lessonService->deleteLesson($id);

        return $this->json(null);
    }
}