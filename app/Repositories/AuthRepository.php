<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'roll_number' => 'required|unique:users',
        ]);

        $user = new User();
        $user->forceFill([
            'roll_number' => $data['roll_number'],
            'password'    => Hash::make($data['password'] ?? 'password'),
            'role'        => $data['role'] ?? 'student',
        ])->save();

        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
        ]);
    }

    public function login(Request $request)
    {
        $fields = $request->has('roll_number')
            ? $request->validate([
                'roll_number' => 'required',
                'password'    => 'required',
            ])
            : $request->validate([
                'email'    => 'required',
                'password' => 'required',
            ]);

        $user = $request->has('roll_number')
            ? User::where('roll_number', $fields['roll_number'])->first()
            : User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Wrong credentials'], 401);
        }

        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'Type'  => 'Bearer',
            'role'  => $user->role,
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.',
            ], 403);
        }

        if ($request->new_password === $request->current_password) {
            return response()->json('New password should not be same as current password.');
        }

        $user->password = Hash::make($request->new_password);
        $user->change_password_status = true;
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully.',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}

