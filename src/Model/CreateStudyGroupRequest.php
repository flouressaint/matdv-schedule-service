<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;

class CreateStudyGroupRequest
{
    #[NotBlank]
    private string $name;
    #[NotBlank]
    private int $teacherId;
    #[NotBlank]
    private int $categoryId;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function setTeacherId(int $teacherId): self
    {
        $this->teacherId = $teacherId;

        return $this;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}