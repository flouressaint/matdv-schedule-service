<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateHometaskRequest
{
    #[Assert\NotBlank(message: 'Hometask description should not be empty')]
    private string $description;
    #[Assert\NotBlank(message: 'Hometask max score should not be empty')]
    private int $maxScore;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxScore(): int
    {
        return $this->maxScore;
    }

    public function setMaxScore(int $maxScore): self
    {
        $this->maxScore = $maxScore;

        return $this;
    }
}