<?php

declare(strict_types=1);

namespace App\Model;

class DisciplineListResponse
{
    /**
     * @param DisciplineListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return DisciplineListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
