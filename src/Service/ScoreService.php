<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Score;
use App\Exception\LessonNotFoundException;
use App\Exception\UserNotFoundException;
use App\Exception\WrongStudentOfStudyGroupException;
use App\Exception\WrongTeacherOfLessonException;
use App\Model\ScoreListItem;
use App\Model\ScoresListResponse;
use App\Model\SetScoresListRequest;
use App\Repository\LessonRepository;
use App\Repository\ScoreRepository;
use App\Repository\StudyGroupRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ScoreService
{
    public function __construct(
        private readonly ScoreRepository $scoreRepository,
        private readonly LessonRepository $lessonRepository,
        private readonly UserRepository $userRepository,
        private readonly StudyGroupRepository $studyGroupRepository
    ) {
    }

    public function getScoresForLesson(UserInterface $user, int $lessonId)
    {
        $lesson = $this->lessonRepository->find($lessonId);
        if (null === $lesson) {
            throw new LessonNotFoundException();
        }
        if ($lesson->getStudyGroup()->getTeacher() !== $user) {
            throw new WrongTeacherOfLessonException();
        }

        $scores = $this->scoreRepository->getScoresByLesson($lessonId);

        $scores = array_map(
            function (Score $score) {
                return new ScoreListItem(
                    $score->getValue(),
                    $score->getStudent()->getId(),
                );
            }, $scores
        );

        return new ScoresListResponse($scores);
    }

    public function setScoresToLesson(UserInterface $user, int $lessonId, SetScoresListRequest $request)
    {
        $lesson = $this->lessonRepository->find($lessonId);
        if (null === $lesson) {
            throw new LessonNotFoundException();
        }
        if ($lesson->getStudyGroup()->getTeacher() !== $user) {
            throw new WrongTeacherOfLessonException();
        }

        foreach ($request->getScores() as $score) {
            $student = $this->userRepository->find($score->getStudentId());
            if (null === $student) {
                throw new UserNotFoundException();
            }

            if (false === $student->getStudyGroups()->contains($lesson->getStudyGroup())) {
                throw new WrongStudentOfStudyGroupException();
            }

            $existingScore = $this->scoreRepository->getScoreByStudentAndLesson($student->getId(), $lessonId);
            if (null !== $existingScore) {
                $existingScore->setValue($score->getValue());
            } else {
                $scoreEntity = (new Score())
                    ->setLesson($lesson)
                    ->setStudent($student)
                    ->setValue($score->getValue());
                $this->scoreRepository->save($scoreEntity);
            }
        }

        $this->scoreRepository->commit();
    }
}
