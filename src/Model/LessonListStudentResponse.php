<?php

declare(strict_types=1);

namespace App\Model;

class LessonListStudentResponse
{
    /**
     * @param LessonListStudentItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return LessonListStudentItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
