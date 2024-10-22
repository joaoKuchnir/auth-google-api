<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IUserRepository
{
    public function __construct(User $user);

    public function createOrUpdate(array $userData, string $token): User;
    public function update(array $userData, string $id);
    public function getAll(): LengthAwarePaginator;
    public function findByEmail(string $email): User|null;

}

