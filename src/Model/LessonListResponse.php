<?php

declare(strict_types=1);

namespace App\Model;

class LessonListResponse
{
    /**
     * @param LessonListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return LessonListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}