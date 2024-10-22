<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Contracts\IUserService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements IUserService
{
    /**
     * Instantiates a user repository
     * 
     * @param UserRepository $userRepository
     */
    public function __construct(protected UserRepository $userRepository) {}

    /**
     * Try creating or update a new user
     * 
     * @param array $userData
     * @param string $token
     */
    public function updateOrCreateUser(array $userData, string $token): User
    {

        $userData['email_verified'] = !empty($userData['email_verified']) || $userData['verifiedEmail'] ? Carbon::now() : null;

        try {
            return $this->userRepository->createOrUpdate(userData: $userData, token: $token);

        } catch ( \Exception $e ) {

            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Try update a user
     * 
     * @param array $userData
     * @param string $id
     */
    public function updateUser(array $userData, string $id): User
    {

        try {
            $userData['birth_date'] = $this->formatDate(userData: $userData);

            return $this->userRepository->update(userData: $userData, id: $id);

        } catch ( \Exception $e ) {

            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Try get all users
     * 
     * @return 
     */
    public function getAllUsers(): LengthAwarePaginator
    {

        try {

            return $this->userRepository->getAll();

        } catch ( \Exception $e ) {

            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Try find a user by google access token
     * 
     * @param string $token
     * @return User|null
     */
    public function findUserByToken(string $token): User|null
    {

        try {
            return $this->userRepository->findByGoogleToken($token);

        } catch ( \Exception $e ) {

            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Try find a user by email
     * 
     * @param string $email
     * @return User|null
     */
    public function findUserByEmail(string $email): User|null
    {
        try {
            return $this->userRepository->findByEmail($email);

        } catch ( \Exception $e ) {

            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Format date from input
     * 
     * @param array $userData
     * @return string|null
     */
    public function formatDate(array $userData): string|null
    {

        $birthDAay = !empty($userData['birth_date']) ? $userData['birth_date'] : null;

        if ( empty($birthDAay) ) {
            return null;
        }

        return Carbon::parse($birthDAay)->format('Y-m-d');
    }

}

