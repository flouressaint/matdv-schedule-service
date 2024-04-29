<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Model\SignUpRequest;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UserRepository $userRepository,
        private readonly AuthenticationSuccessHandler $successHandler)
    {
    }

    public function signUp(SignUpRequest $signUpRequest): Response
    {
        if ($this->userRepository->existsByUsername($signUpRequest->getUsername())) {
            throw new UserAlreadyExistsException();
        }

        $user = (new User())
            ->setRoles(['ROLE_USER'])
            ->setUsername($signUpRequest->getUsername())
            ->setFullName($signUpRequest->getFullName());

        $user->setPassword($this->hasher->hashPassword($user, $signUpRequest->getPassword()));

        $this->userRepository->saveAndCommit($user);

        return $this->successHandler->handleAuthenticationSuccess($user);
    }
}