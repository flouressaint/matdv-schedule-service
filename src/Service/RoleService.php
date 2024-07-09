<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Model\UserListResponse;
use App\Model\UserResponse;
use App\Repository\UserRepository;

class RoleService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function grantAdmin(string $username): void
    {
        $this->grantRole($username, 'ROLE_ADMIN');
    }

    public function grantTeacher(string $username): void
    {
        $this->grantRole($username, 'ROLE_TEACHER');
    }

    private function grantRole(string $username, string $role): void
    {
        $user = $this->userRepository->getUserByUsername($username);
        $user->setRoles([$role]);

        $this->userRepository->commit();
    }

    public function getTeachers(): UserListResponse
    {
        $teachers = $this->userRepository->getTeachers();
        $items = array_map(
            fn (User $teacher) => new UserResponse(
                $teacher->getId(),
                $teacher->getFullName(),
            ),
            $teachers
        );

        return new UserListResponse($items);
    }
}
