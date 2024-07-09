<?php

declare(strict_types=1);

namespace App\Model;

class ScoresListResponse
{
    /**
     * @param ScoreListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return ScoreListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
