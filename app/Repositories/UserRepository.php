<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements IUserRepository
{
    /**
     * Initializes the class with a User model instance
     *
     * @param  User $user
     */
    public function __construct(protected User $user) {}

    /**
     * Update or create user 
     * 
     * @param array $userData
     * @param string $token
     */
    public function createOrUpdate(array $userData, string $token = null): User
    {

        $user = User::updateOrCreate(
            ['email' => $userData['email']],
            [
                'name'                => $userData['name'],
                'email_verified_at'   => $userData['email_verified'] ?? null,
                'birth_date'          => $userData['bith_day'] ?? null,
                'cpf'                 => $userData['cpf'] ?? null,
                'password'            => $userData['password'] ?? 1,
                'google_access_token' => $token,
                'picture'             => $userData['picture'] ?? null
            ]
        );

        return $user;
    }

    /**
     * Update user
     *
     * @param array $userData
     * @param string $id
     * 
     * @return User
     */
    public function update(array $userData, string $id): User
    {

        $user = User::findOrFail($id);

        $user->update([
            'name'                  => $userData['name'],
            'birth_date'            => $userData['birth_date'],
            'cpf'                   => $userData['cpf'],
            'password'              => $userData['password'],
            'google_access_token'   => $userData['google_access_token'],
            'registration_finished' => $userData['registration_finished'] ?? false
        ]);

        return $user;
    }

    /**
     * Get all users
     * 
     * @return LengthAwarePaginator
     */

    public function getAll(array $filters = null): LengthAwarePaginator
    {

        return User::where('registration_finished', 1)
            ->when(!empty($filters['name']), function ($query) use ($filters)
            {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['cpf']), function ($query) use ($filters)
            {
                $query->where('cpf', 'like', '%' . $filters['cpf'] . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(9);
    }

    /**
     * Find a user by email
     * 
     * @param string $email
     * @return User|null
     */

    public function findByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    /**
     * Find a user by google access token
     * 
     * @param string $token
     * @return User|null
     */
    public function findByGoogleToken(string $token): User|null
    {

        return User::where('google_access_token', $token)->first();
    }

}

