<?php

declare(strict_types=1);

namespace App\Model;

class AuditoriumListResponse
{
    /**
     * @param AuditoriumListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return AuditoriumListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
