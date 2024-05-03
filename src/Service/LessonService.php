<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Auditorium;
use App\Entity\Lesson;
use App\Entity\StudyGroup;
use App\Model\CreateLessonRequest;
use App\Model\IdResponse;
use App\Model\LessonResponse;
use App\Model\UpdateLessonRequest;
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

    // public function getLesson(int $id): LessonResponse
    // {
    //     $lesson = $this->lessonRepository->getLessonById($id);

    //     return new LessonResponse($lesson->getId(), $lesson->getDescription(), $lesson->getAttachment());
    // }

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