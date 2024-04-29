<?php

declare(strict_types=1);

namespace App\Model;

class StudyGroupListResponse
{
    /**
     * @param StudyGroupListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return StudyGroupListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}