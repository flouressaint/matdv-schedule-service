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
    #[OA\Parameter(parameter: 'username', name: 'username', description: 'Username', in: 'path', required: true)]
    public function grantTeacher(string $username): Response
    {
        $this->roleService->grantTeacher($username);

        return $this->json(null);
    }

    #[Route('/api/v1/admin/auditoriums', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Returns list of auditoriums')]
    public function auditoriums(): JsonResponse
    {
        return $this->json($this->auditoriumService->getAuditoriums());
    }

    #[Route('/api/v1/admin/auditorium', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Returns id of created auditorium')]
    #[OA\Response(response: 422, description: 'Validation failed', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 409, description: 'Auditorium already exists with this name', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\RequestBody(content: new Model(type: CreateAuditoriumRequest::class))]
    public function createAuditorium(#[MapRequestPayload] CreateAuditoriumRequest $request): JsonResponse
    {
        return $this->json($this->auditoriumService->createAuditorium($request));
    }

    #[Route('/api/v1/admin/auditorium/{id}', methods: ['PUT'])]
    #[OA\Response(response: 200, description: 'Auditorium updated')]
    #[OA\Response(response: 404, description: 'Auditorium not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 422, description: 'Validation failed', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 409, description: 'Auditorium already exists with this name', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'id', name: 'id', description: 'Auditorium id', in: 'path', required: true)]
    #[OA\RequestBody(content: new Model(type: UpdateAuditoriumRequest::class))]
    public function updateAuditorium(int $id, #[MapRequestPayload] UpdateAuditoriumRequest $request): JsonResponse
    {
        $this->auditoriumService->updateAuditorium($id, $request);

        return $this->json(null);
    }

    #[Route('/api/v1/admin/auditorium/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Auditorium deleted')]
    #[OA\Response(response: 404, description: 'Auditorium not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'id', name: 'id', description: 'Auditorium id', in: 'path', required: true)]
    public function deleteAuditorium(int $id): JsonResponse
    {
        $this->auditoriumService->deleteAuditorium($id);

        return $this->json(null);
    }

    #[Route(path: '/api/v1/admin/studyGroups', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Returns list of study groups')]
    public function StudyGroups(): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroups());
    }

    #[Route(path: '/api/v1/admin/studyGroup/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Returns study group full information')]
    #[OA\Response(response: 404, description: 'Study group not found', attachables: [new Model(type: ErrorResponse::class)])]
    public function getStudyGroup(int $id): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroup($id));
    }

    #[Route(path: 'api/v1/admin/studyGroup', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Returns id of created study group')]
    #[OA\Response(response: 422, description: 'Validation failed', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 409, description: 'Study group already exists with this name', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\RequestBody(content: new Model(type: CreateStudyGroupRequest::class))]
    public function createStudyGroup(#[MapRequestPayload] CreateStudyGroupRequest $request): JsonResponse
    {
        return $this->json($this->studyGroupService->createStudyGroup($request));
    }

    #[Route('api/v1/admin/studyGroup/{id}', methods: ['PATCH'])]
    #[OA\Response(response: 200, description: 'Study group updated')]
    #[OA\Response(response: 404, description: 'Study group not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 422, description: 'Validation failed', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 409, description: 'Study group already exists with this name', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\RequestBody(content: new Model(type: UpdateStudyGroupRequest::class))]
    public function editStudyGroup(int $id, #[MapRequestPayload] UpdateStudyGroupRequest $request): JsonResponse
    {
        $this->studyGroupService->updateStudyGroup($id, $request);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroup/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Study group deleted')]
    #[OA\Response(response: 404, description: 'Study group not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'id', name: 'id', description: 'Study group id', in: 'path', required: true)]
    public function deleteStudyGroup(int $id): JsonResponse
    {
        $this->studyGroupService->deleteStudyGroup($id);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroup/{studyGroupId}/enroll/{studentUsername}', requirements: ['studyGroupId' => '\d+'], methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Enroll student in study group')]
    #[OA\Response(response: 404, description: 'Study group or student not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 409, description: 'Student already enrolled in study group', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'studyGroupId', name: 'studyGroupId', description: 'Study group id', in: 'path', required: true)]
    #[OA\Parameter(parameter: 'studentUsername', name: 'studentUsername', description: 'Student username', in: 'path', required: true)]
    public function enrollStudent(int $studyGroupId, string $studentUsername): JsonResponse
    {
        $this->studyGroupService->enrollStudent($studyGroupId, $studentUsername);

        return $this->json(null);
    }

    #[Route(path: 'api/v1/admin/studyGroupCategory', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Returns id of created study group category')]
    #[OA\Response(response: 422, description: 'Validation failed', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 409, description: 'Study group category already exists with this name', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\RequestBody(content: new Model(type: CreateStudyGroupCategoryRequest::class))]
    public function createStudyGroupCategory(#[MapRequestPayload] CreateStudyGroupCategoryRequest $request): JsonResponse
    {
        return $this->json($this->studyGroupCategoryService->createStudyGroupCategory($request));
    }

    #[Route('api/v1/admin/studyGroupCategory/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    #[OA\Response(response: 200, description: 'Study group category updated')]
    #[OA\Response(response: 404, description: 'Study group category not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 422, description: 'Validation failed', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 409, description: 'Study group category already exists with this name', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\RequestBody(content: new Model(type: UpdateStudyGroupCategoryRequest::class))]
    public function editStudyGroupCategory(int $id, #[MapRequestPayload] UpdateStudyGroupCategoryRequest $request): JsonResponse
    {
        $this->studyGroupCategoryService->updateStudyGroupCategory($id, $request);

        return $this->json(null);
    }

    #[Route('api/v1/admin/studyGroupCategory/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Study group category deleted')]
    #[OA\Response(response: 404, description: 'Study group category not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'id', name: 'id', description: 'Study group category id', in: 'path', required: true)]
    public function deleteStudyGroupCategory(int $id): JsonResponse
    {
        $this->studyGroupCategoryService->deleteStudyGroupCategory($id);

        return $this->json(null);
    }

    #[Route(path: '/api/v1/admin/lessons', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Returns list of lessons')]
    public function Lessons(): JsonResponse
    {
        return $this->json($this->lessonService->getLessons());
    }

    #[Route(path: '/api/v1/admin/lesson/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Returns lesson full information')]
    #[OA\Response(response: 404, description: 'Lesson not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'id', name: 'id', description: 'Lesson id', in: 'path', required: true)]
    public function getLesson(int $id): JsonResponse
    {
        return $this->json($this->lessonService->getLesson($id));
    }

    #[Route(path: '/api/v1/admin/lesson', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Returns id of created lesson')]
    #[OA\Response(response: 422, description: 'Validation failed', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\RequestBody(content: new Model(type: CreateLessonRequest::class))]
    public function createLesson(#[MapRequestPayload] CreateLessonRequest $request): JsonResponse
    {
        return $this->json($this->lessonService->createLesson($request));
    }

    #[Route('/api/v1/admin/lesson/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Lesson deleted')]
    #[OA\Response(response: 404, description: 'Lesson not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Parameter(parameter: 'id', name: 'id', description: 'Lesson id', in: 'path', required: true)]
    public function deleteLesson(int $id): JsonResponse
    {
        $this->lessonService->deleteLesson($id);

        return $this->json(null);
    }
}
