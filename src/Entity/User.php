<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: UserRole::class, inversedBy: 'users')]
    private Collection $role;

    #[ORM\ManyToMany(targetEntity: StudyGroup::class, inversedBy: 'users')]
    private Collection $study_group;

    #[ORM\OneToMany(targetEntity: Lesson::class, mappedBy: 'teacher')]
    private Collection $lessons;

    public function __construct()
    {
        $this->role = new ArrayCollection();
        $this->study_group = new ArrayCollection();
        $this->lessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, UserRole>
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(UserRole $role): static
    {
        if (!$this->role->contains($role)) {
            $this->role->add($role);
        }

        return $this;
    }

    public function removeRole(UserRole $role): static
    {
        $this->role->removeElement($role);

        return $this;
    }

    /**
     * @return Collection<int, StudyGroup>
     */
    public function getStudyGroup(): Collection
    {
        return $this->study_group;
    }

    public function addStudyGroup(StudyGroup $studyGroup): static
    {
        if (!$this->study_group->contains($studyGroup)) {
            $this->study_group->add($studyGroup);
        }

        return $this;
    }

    public function removeStudyGroup(StudyGroup $studyGroup): static
    {
        $this->study_group->removeElement($studyGroup);

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): static
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
            $lesson->setTeacher($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): static
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getTeacher() === $this) {
                $lesson->setTeacher(null);
            }
        }

        return $this;
    }
}
