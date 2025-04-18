<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google’s OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        try {
            $user = Socialite::driver('google')->user();
            if (! str_ends_with($user->email, '@deerwalk.edu.np')) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors'  => [
                        'email' => ['Only deerwalk.edu.np email addresses are allowed.'],
                    ],
                ], 422);
            }
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                Auth::login($existingUser);
            } else {
                $existingUser = User::create([
                    'email'             => $user->email,
                    'name'              => $user->name,
                    'role'              => 'student',
                    'password'          => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                ]);
                Auth::login($existingUser);
            }
            $token = $existingUser->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user'    => $existingUser,
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
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
