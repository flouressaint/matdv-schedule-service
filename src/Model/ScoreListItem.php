<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ScoreListItem
{
    #[Assert\NotBlank(message: 'Score value should not be empty')]
    private int $value;

    #[Assert\NotBlank(message: 'studentId should not be empty')]
    private int $studentId;

    public function __construct(int $value, int $studentId)
    {
        $this->value = $value;
        $this->studentId = $studentId;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): self
    {
        $this->studentId = $studentId;

        return $this;
    }
}
