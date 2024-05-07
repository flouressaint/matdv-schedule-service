<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CreateHometaskRequest;
use App\Service\LessonService;
use App\Service\RoleService;
use App\Service\StudyGroupCategoryService;
use App\Service\StudyGroupService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[OA\Tag(name: 'Teacher')]
class TeacherController extends AbstractController
{
    public function __construct(
        private readonly RoleService $roleService,
        private readonly StudyGroupService $studyGroupService,
        private readonly StudyGroupCategoryService $studyGroupCategoryService,
        private readonly LessonService $lessonService
    ) {
    }

    #[Route(path: '/api/v1/teacher/lessons', name: 'lesson_index', methods: ['GET'])]
    public function getLessons(#[CurrentUser] UserInterface $user): JsonResponse
    {
        return $this->json($this->lessonService->getLessonsForTeacher($user));
    }

    #[Route(path: '/api/v1/teacher/lesson/{id}/hometask', name: 'lesson_create_hometask', methods: ['POST'])]
    public function setHometask(#[CurrentUser] UserInterface $user, int $id, #[MapRequestPayload] CreateHometaskRequest $request): JsonResponse
    {
        return $this->json($this->lessonService->setHometaskForLesson($user, $id, $request));
    }
}