<?php

namespace App\Services\Contracts;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IUserService
{
    public function __construct(UserRepository $userRepository);
    public function updateOrCreateUser(array $userData, string $token): User;
    public function updateUser(array $userData, string $id): User;
    public function getAllUsers(array $filters): LengthAwarePaginator;
    public function formatDate(array $userData): string|null;

}

