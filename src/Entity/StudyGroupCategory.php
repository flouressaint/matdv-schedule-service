<?php

namespace App\Entity;

use App\Repository\StudyGroupCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudyGroupCategoryRepository::class)]
class StudyGroupCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: StudyGroup::class, mappedBy: 'studyGroupCategory', orphanRemoval: true)]
    private Collection $studyGroups;

    public function __construct()
    {
        $this->studyGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, StudyGroup>
     */
    public function getStudyGroups(): Collection
    {
        return $this->studyGroups;
    }

    public function addStudyGroup(StudyGroup $studyGroup): static
    {
        if (!$this->studyGroups->contains($studyGroup)) {
            $this->studyGroups->add($studyGroup);
            $studyGroup->setStudyGroupCategory($this);
        }

        return $this;
    }

    public function removeStudyGroup(StudyGroup $studyGroup): static
    {
        if ($this->studyGroups->removeElement($studyGroup)) {
            // set the owning side to null (unless already changed)
            if ($studyGroup->getStudyGroupCategory() === $this) {
                $studyGroup->setStudyGroupCategory(null);
            }
        }

        return $this;
    }
}