<?php

declare(strict_types=1);

namespace App\Model;

class StudyGroupListItem
{
    public function __construct(
        private int $id,
        private string $name,
        private UserResponse $teacher,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeacher(): UserResponse
    {
        return $this->teacher;
    }
}
