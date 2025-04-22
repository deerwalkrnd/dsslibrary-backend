<?php

namespace App\Http\Controllers;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authRepo;
    protected $userRepo;

    public function __construct(
        AuthRepositoryInterface $authRepo,
    ) {
        $this->authRepo = $authRepo;
    }

    public function register(Request $request)
    {
        return $this->authRepo->register($request);
    }

    public function login(Request $request)
    {
        return $this->authRepo->login($request);
    }

    public function changePassword(Request $request)
    {
        return $this->authRepo->changePassword($request);
    }

    public function userlogout(Request $request)
    {
        return $this->authRepo->logout($request);
    }
}
