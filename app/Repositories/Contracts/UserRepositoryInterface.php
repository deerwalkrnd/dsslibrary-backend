<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser(array $data): User;
    public function getUserForLogin(array $fields): ?User;
    public function updatePassword(User $user, string $newPassword): void;
    public function getOrCreateGoogleUser($googleUser): User;
    public function findById(string $id);
    public function get();
}
