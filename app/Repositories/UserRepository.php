<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findByEmail(string $email): User|null
    {
        return $this->user->where('email', $email)->first();
    }

    public function create($data): User
    {
        return $this->user->create($data);
    }
}