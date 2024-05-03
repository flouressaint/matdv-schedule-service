<?php

declare(strict_types=1);

namespace App\Model;

class LessonListItem
{
    public function __construct(
        private int $id,
        private string $date,
        private string $startTime,
        private string $endTime,
        private AuditoriumListItem $auditorium,
        private StudyGroupListItem $studyGroup,
        private ?HometaskResponse $hometask
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function getAuditorium(): AuditoriumListItem
    {
        return $this->auditorium;
    }

    public function getStudyGroup(): StudyGroupListItem
    {
        return $this->studyGroup;
    }

    public function getHometask(): ?HometaskResponse
    {
        return $this->hometask;
    }
}