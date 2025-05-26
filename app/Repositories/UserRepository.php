<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data): User
    {
        $user = new User;
        $user->forceFill($data)->save();

        return $user;
    }

    public function getUserForLogin(array $fields): ?User
    {
        return array_key_exists('roll_number', $fields)
            ? User::where('roll_number', $fields['roll_number'])->first()
            : User::where('email', $fields['email'])->first();
    }

    public function get(int $perPage = 10)
    {
        $users = User::where('role', 'student')->latest()->paginate($perPage);

        return $users;
    }

    public function search(int $perPage = 10,string $search)
    {
        $users = User::where('name', 'like', "$search%")->where('role', 'student')->latest()->paginate($perPage);
        return $users;
    }


    public function updatePassword(User $user, string $newPassword): void
    {
        $user->password = $newPassword;
        $user->change_password_status = true;
        $user->save();
    }

    public function getOrCreateGoogleUser($googleUser): User
    {
        $existingUser = User::where('email', $googleUser->email)->first();

        if ($existingUser) {
            return $existingUser;
        }

        return User::create([
            'email' => $googleUser->email,
            'name' => $googleUser->name,
            'role' => 'student',
            'password' => bcrypt(Str::random(16)),
            'email_verified_at' => now(),
        ]);
    }

    public function findById(string $id)
    {
        $user = User::find($id);

        return $user;
    }

    public function update($user, array $data)
    {
        if (isset($data['password']) && ! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function delete($user)
    {
        return $user->delete();
    }
}
