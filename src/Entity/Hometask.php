<?php

namespace App\Entity;

use App\Repository\HometaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HometaskRepository::class)]
class Hometask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 700, nullable: true)]
    private ?string $attachment = null;

    #[ORM\OneToOne(mappedBy: 'hometask', cascade: ['persist', 'remove'])]
    private ?Lesson $lesson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function setAttachment(?string $attachment): static
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): static
    {
        // unset the owning side of the relation if necessary
        if ($lesson === null && $this->lesson !== null) {
            $this->lesson->setHometask(null);
        }

        // set the owning side of the relation if necessary
        if ($lesson !== null && $lesson->getHometask() !== $this) {
            $lesson->setHometask($this);
        }

        $this->lesson = $lesson;

        return $this;
    }
}
