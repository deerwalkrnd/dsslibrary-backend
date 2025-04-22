<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function register(Request $request);
    public function login(Request $request);
    public function changePassword(Request $request);
    public function logout(Request $request);
}
