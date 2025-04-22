<?php

namespace App\Services;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\GoogleAuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(protected UserRepositoryInterface $authRepository)
    {
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->authRepository->createUser([
            'roll_number' => $data['roll_number'],
            'password'    => Hash::make($data['password'] ?? 'password'),
            'role'        => $data['role'] ?? 'student',
        ]);

        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'token'   => $token,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $fields = $request->validated();
        $user = $this->authRepository->getUserForLogin($fields);

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

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->validated();
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 403);
        }

        if ($request->new_password === $request->current_password) {
            return response()->json(['message' => 'New password should not be same as current password.']);
        }

        $this->authRepository->updatePassword($user, $request->new_password);

        return response()->json(['message' => 'Password changed successfully.']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(GoogleAuthRequest $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $request->validateGoogleUser($googleUser);

            $user = $this->authRepository->getOrCreateGoogleUser($googleUser);
            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user'    => $user,
                'token'   => $token,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Google authentication failed.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function googleLogout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
