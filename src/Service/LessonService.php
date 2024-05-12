<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Auditorium;
use App\Entity\Lesson;
use App\Entity\StudyGroup;
use App\Model\AuditoriumListItem;
use App\Model\CreateHometaskRequest;
use App\Model\CreateLessonRequest;
use App\Model\HometaskResponse;
use App\Model\IdResponse;
use App\Model\LessonListItem;
use App\Model\LessonListResponse;
use App\Model\StudyGroupListItem;
use App\Model\UserResponse;
use App\Repository\AuditoriumRepository;
use App\Repository\LessonRepository;
use App\Repository\StudyGroupRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class LessonService
{
    public function __construct(
        private readonly HometaskService $hometaskService,
        private readonly LessonRepository $lessonRepository,
        private readonly AuditoriumRepository $auditoriumRepository,
        private readonly StudyGroupRepository $studyGroupRepository
    ) {
    }

    public function getLessonsForStudent(UserInterface $user): LessonListResponse
    {
        $lessons = $this->lessonRepository->findAllSortedByDateAndTime();
        $lessons = array_filter(
            $lessons,
            fn (Lesson $lesson) => $lesson->getStudyGroup()->getStudents()->contains($user)
        );
        $items = array_map(
            $this->mapLessonToListItem(...),
            $lessons
        );

        return new LessonListResponse($items);
    }

    public function getLessonsForTeacher(UserInterface $user): LessonListResponse
    {
        $lessons = $this->lessonRepository->findAllSortedByDateAndTime();
        $lessons = array_filter(
            $lessons,
            fn (Lesson $lesson) => $lesson->getStudyGroup()->getTeacher() === $user
        );
        $items = array_map(
            $this->mapLessonToListItem(...),
            $lessons
        );

        return new LessonListResponse($items);
    }

    public function getLessons(): LessonListResponse
    {
        $lessons = $this->lessonRepository->findAllSortedByDateAndTime();
        $items = array_map(
            $this->mapLessonToListItem(...),
            $lessons
        );

        return new LessonListResponse($items);
    }

    public function getLesson(int $id): LessonListItem
    {
        $lesson = $this->lessonRepository->getLessonById($id);

        return $this->mapLessonToListItem($lesson);
    }

    public function createLesson(CreateLessonRequest $request): IdResponse
    {
        $auditorium = $this->auditoriumRepository->getAuditoriumById($request->getAuditoriumId());
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($request->getStudyGroupId());
        $lessons = $this->lessonRepository->getLessonsByDateAndTime($request->getDate(), $request->getStartTime(), $request->getEndTime());
        if (!$this->isAuditoriumFree($auditorium, $lessons)) {
            throw new \DomainException('Auditorium is not free at this time', 400);
        }
        if (!$this->isStudyGroupFree($studyGroup, $lessons)) {
            throw new \DomainException('Study group is not free at this time', 400);
        }
        $lesson = (new Lesson())
            ->setDate($request->getDate())
            ->setStartTime($request->getStartTime())
            ->setEndTime($request->getEndTime())
            ->setAuditorium($auditorium)
            ->setStudyGroup($studyGroup)
        ;
        $this->lessonRepository->saveAndCommit($lesson);

        return new IdResponse($lesson->getId());
    }

    // public function updateLesson(int $id, UpdateLessonRequest $request): void
    // {
    //     $lesson = $this->lessonRepository->getLessonById($id);
    //     $lesson->setDescription($request->getDescription())
    //              ->setAttachment($request->getAttachment());
    //     $this->lessonRepository->commit();
    // }

    public function deleteLesson(int $id): void
    {
        $lesson = $this->lessonRepository->getLessonById($id);
        $this->lessonRepository->removeAndCommit($lesson);
    }

    public function setHometaskForLesson(UserInterface $user, int $id, CreateHometaskRequest $request)
    {
        $lesson = $this->lessonRepository->getLessonById($id);
        if ($lesson->getStudyGroup()->getTeacher() !== $user) {
            throw new \DomainException('You are not teacher of this lesson', 400);
        }

        if (null !== $lesson->getHometask()) {
            $this->hometaskService->updateHometask($lesson->getHometask()->getId(), $request);
        } else {
            $hometask = $this->hometaskService->createHometask($request);
            $lesson->setHometask($hometask);
            $this->lessonRepository->commit();
        }
    }

    /**
     * @param Lesson[] $lessons
     */
    private function isAuditoriumFree(Auditorium $auditorium, array $lessons): bool
    {
        foreach ($lessons as $lesson) {
            if ($lesson->getAuditorium()->getId() === $auditorium->getId()) {
                return false;
            }
        }

        return true;
    }

    private function isStudyGroupFree(StudyGroup $studyGroup, array $lessons): bool
    {
        foreach ($lessons as $lesson) {
            if ($lesson->getStudyGroup()->getId() === $studyGroup->getId()) {
                return false;
            }
        }

        return true;
    }

    private function mapLessonToListItem(Lesson $lesson): LessonListItem
    {
        return new LessonListItem(
            $lesson->getId(),
            $lesson->getDate()->format('Y-m-d'),
            $lesson->getStartTime()->format('H:i'),
            $lesson->getEndTime()->format('H:i'),
            new AuditoriumListItem(
                $lesson->getAuditorium()->getId(),
                $lesson->getAuditorium()->getName(),
            ),
            new StudyGroupListItem(
                $lesson->getStudyGroup()->getId(),
                $lesson->getStudyGroup()->getName(),
                new UserResponse(
                    $lesson->getStudyGroup()->getTeacher()->getId(),
                    $lesson->getStudyGroup()->getTeacher()->getFullName()
                )
            ),
            null === $lesson->getHometask() ? null :
                new HometaskResponse(
                    $lesson->getHometask()->getId(),
                    $lesson->getHometask()->getDescription(),
                    $lesson->getHometask()->getAttachment()
                ),
        );
    }
}
