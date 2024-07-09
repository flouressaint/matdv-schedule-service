<?php

declare(strict_types=1);

namespace App\Model;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateLessonRequest
{
    #[Assert\NotBlank(message: 'Date is required')]
    #[OA\Property(type: 'string', format: 'date')]
    private \DateTimeImmutable $date;
    #[Assert\NotBlank(message: 'Start time is required')]
    #[OA\Property(type: 'string', format: 'date-time', example: '10:00')]
    private \DateTimeImmutable $startTime;
    #[Assert\NotBlank(message: 'End time is required')]
    #[OA\Property(type: 'string', format: 'date-time', example: '11:00')]
    private \DateTimeImmutable $endTime;
    #[Assert\NotBlank(message: 'AuditoriumId is required')]
    private int $auditoriumId;
    #[Assert\NotBlank(message: 'StudyGroupId is required')]
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
