<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CreateHometaskRequest;
use App\Model\SetScoresListRequest;
use App\Service\LessonService;
use App\Service\RoleService;
use App\Service\ScoreService;
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
        private readonly LessonService $lessonService,
        private readonly ScoreService $scoreService
    ) {
    }

    #[Route(path: '/api/v1/teacher/lessons', name: 'lesson_index', methods: ['GET'])]
    public function getLessons(#[CurrentUser] UserInterface $user): JsonResponse
    {
        return $this->json($this->lessonService->getLessonsForTeacher($user));
    }

    #[Route(path: '/api/v1/teacher/lesson/{lessonId}/hometask', name: 'lesson_create_hometask', methods: ['POST'])]
    public function setHometask(#[CurrentUser] UserInterface $user, int $lessonId, #[MapRequestPayload] CreateHometaskRequest $request): JsonResponse
    {
        return $this->json($this->lessonService->setHometaskForLesson($user, $lessonId, $request));
    }

    #[Route(path: '/api/v1/teacher/study-groups', name: 'study_group_index', methods: ['GET'])]
    public function getStudyGroups(#[CurrentUser] UserInterface $user): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroupsForTeacher($user));
    }

    #[Route(path: '/api/v1/teacher/study-group/{id}/lessons', name: 'study_group_show', methods: ['GET'])]
    public function getStudyGroupLessons(int $id): JsonResponse
    {
        return $this->json($this->lessonService->getLessonsForStudyGroup($id));
    }

    #[Route(path: '/api/v1/teacher/lesson/{lessonId}/scores', methods: ['GET'])]
    public function getScores(#[CurrentUser] UserInterface $user, int $lessonId): JsonResponse
    {
        return $this->json($this->scoreService->getScoresForLesson($user, $lessonId));
    }

    #[Route(path: '/api/v1/teacher/lesson/{lessonId}/scores', methods: ['POST'])]
    public function setScoreToStudent(#[CurrentUser] UserInterface $user, int $lessonId, #[MapRequestPayload] SetScoresListRequest $request): JsonResponse
    {
        return $this->json($this->scoreService->setScoresToLesson($user, $lessonId, $request));
    }
}
