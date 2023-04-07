<?php

namespace Services;

use Models\User;
use Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login($email, $password): ?User
    {
        return $this->userRepository->login($email, $password);
    }

    public function register(mixed $user): ?User
    {
        return $this->userRepository->register($user);
    }

    public function userExists($email): bool
    {
        return $this->userRepository->userExists($email);
    }
}
