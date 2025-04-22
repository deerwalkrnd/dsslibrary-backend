<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\GoogleAuthRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function createUser(array $data): User;
    public function getUserForLogin(array $fields): ?User;
    public function updatePassword(User $user, string $newPassword): void;
    public function getOrCreateGoogleUser($googleUser): User;
}
