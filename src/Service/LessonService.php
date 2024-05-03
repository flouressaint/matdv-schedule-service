<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Auditorium;
use App\Entity\Lesson;
use App\Entity\StudyGroup;
use App\Entity\User;
use App\Model\AuditoriumListItem;
use App\Model\CreateLessonRequest;
use App\Model\HometaskResponse;
use App\Model\IdResponse;
use App\Model\LessonListItem;
use App\Model\LessonListResponse;
use App\Model\StudyGroupListItem;
use App\Model\UpdateLessonRequest;
use App\Model\UserResponse;
use App\Repository\AuditoriumRepository;
use App\Repository\LessonRepository;
use App\Repository\StudyGroupRepository;

class LessonService
{
    public function __construct(
        private readonly LessonRepository $lessonRepository,
        private readonly AuditoriumRepository $auditoriumRepository,
        private readonly StudyGroupRepository $studyGroupRepository
    ) {
    }

    public function getLessons(): LessonListResponse
    {
        $lessons = $this->lessonRepository->findAllSortedByDateAndTime();
        $items = array_map(
            fn (Lesson $lesson) => new LessonListItem(
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
                    ),
                    array_map(
                        fn (User $student) => new UserResponse($student->getId(), $student->getFullName()),
                        $lesson->getStudyGroup()->getStudents()->toArray()
                    )
                ),
                null === $lesson->getHometask() ? null :
                    new HometaskResponse(
                        $lesson->getHometask()->getId(),
                        $lesson->getHometask()->getDescription(),
                        $lesson->getHometask()->getAttachment()
                    ),
            ),
            $lessons
        );

        return new LessonListResponse($items);
    }

    public function getLesson(int $id): LessonListItem
    {
        $lesson = $this->lessonRepository->getLessonById($id);

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
                ),
                array_map(
                    fn (User $student) => new UserResponse($student->getId(), $student->getFullName()),
                    $lesson->getStudyGroup()->getStudents()->toArray()
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

    public function createLesson(CreateLessonRequest $request): IdResponse
    {
        $auditorium = $this->auditoriumRepository->getAuditoriumById($request->getAuditoriumId());
        $studyGroup = $this->studyGroupRepository->getStudyGroupById($request->getStudyGroupId());
        $lessons = $this->lessonRepository->getLessonsByDateAndTime($request->getDate(), $request->getStartTime(), $request->getEndTime());
        if (!$this->isAuditoriumFree($auditorium, $lessons)) {
            throw new \DomainException('Auditorium is not free in this time', 400);
        }
        if (!$this->isStudyGroupFree($studyGroup, $lessons)) {
            throw new \DomainException('Study group is not free in this time', 400);
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
}