<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateHometaskRequest
{
    #[Assert\NotBlank(message: 'Hometask description should not be empty')]
    private string $description;
    private string $attachment;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAttachment(): string
    {
        return $this->attachment;
    }

    public function setAttachment(string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }
}
