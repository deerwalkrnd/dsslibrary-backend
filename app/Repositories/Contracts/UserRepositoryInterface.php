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

    public function get(int $perPage=10);

    public function search(int $perPage=10, string $search);

    public function update($user, array $data);

    public function delete($user);
}
