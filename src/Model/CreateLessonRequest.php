<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;

class CreateLessonRequest
{
    #[NotBlank]
    private \DateTimeImmutable $date;
    #[NotBlank]
    private \DateTimeImmutable $startTime;
    #[NotBlank]
    private \DateTimeImmutable $endTime;
    #[NotBlank]
    private int $auditoriumId;
    #[NotBlank]
    private int $studyGroupId;

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeImmutable $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): \DateTimeImmutable
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeImmutable $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getAuditoriumId(): int
    {
        return $this->auditoriumId;
    }

    public function setAuditoriumId(int $auditoriumId): self
    {
        $this->auditoriumId = $auditoriumId;

        return $this;
    }

    public function getStudyGroupId(): int
    {
        return $this->studyGroupId;
    }

    public function setStudyGroupId(int $studyGroupId): self
    {
        $this->studyGroupId = $studyGroupId;

        return $this;
    }
}