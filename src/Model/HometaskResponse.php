<?php

declare(strict_types=1);

namespace App\Model;

class HometaskResponse
{
    public function __construct(
        private int $id,
        private string $description,
        private string $attachment
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAttachment(): string
    {
        return $this->attachment;
    }
}