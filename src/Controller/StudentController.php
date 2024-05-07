<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\LessonService;
use App\Service\RoleService;
use App\Service\StudyGroupCategoryService;
use App\Service\StudyGroupService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[OA\Tag(name: 'Student')]
class StudentController extends AbstractController
{
    public function __construct(
        private readonly RoleService $roleService,
        private readonly StudyGroupService $studyGroupService,
        private readonly StudyGroupCategoryService $studyGroupCategoryService,
        private readonly LessonService $lessonService
    ) {
    }

    #[Route(path: '/api/v1/student/lessons', methods: ['GET'])]
    public function getLessons(#[CurrentUser] UserInterface $user): JsonResponse
    {
        return $this->json($this->lessonService->getLessonsForStudent($user));
    }

    #[Route(path: '/api/v1/student/study-groups', methods: ['GET'])]
    public function getStudyGroups(#[CurrentUser] UserInterface $user): JsonResponse
    {
        return $this->json($this->studyGroupService->getStudyGroupsForStudent($user));
    }
}