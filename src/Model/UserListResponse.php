<?php

declare(strict_types=1);

namespace App\Model;

class UserListResponse
{
    /**
     * @param UserResponse[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return UserResponse[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
