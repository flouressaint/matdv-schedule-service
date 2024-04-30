<?php

declare(strict_types=1);

namespace App\Model;

class StudyGroupCategoryListResponse
{
    /**
     * @param StudyGroupCategoryListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return StudyGroupCategoryListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}