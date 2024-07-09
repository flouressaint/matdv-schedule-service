<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;

class SignUpRequest
{
    #[Assert\NotBlank(message: 'Full name cannot be blank')]
    private string $fullName;

    #[Assert\NotBlank(message: 'Username cannot be blank')]
    private string $username;

    #[Assert\NotBlank(message: 'Password cannot be blank')]
    #[Length(min: 8)]
    private string $password;

    #[Assert\NotBlank(message: 'Confirm password cannot be blank')]
    #[EqualTo(propertyPath: 'password', message: 'This value should be equal to password field')]
    private string $confirmPassword;

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
