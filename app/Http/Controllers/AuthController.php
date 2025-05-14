<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\GoogleAuthRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * AddUser
     */
    public function register(RegisterRequest $request)
    {
        return $this->userService->register($request);
    }
    /**
     * EditUser
     */
    public function editStudent(UpdateStudentRequest $request)
    {
        return $this->userService->edit($request);
    }
    /**
     * DeleteUser
     */
    public function deleteStudent(Request $request)
    {
        return $this->userService->delete($request);
    }
    /**
     * Login
     */
    public function login(LoginRequest $request)
    {
        return $this->userService->login($request);
    }
    /**
     * GetStudents
     */
    public function showStudents(Request $request)
    {
        return $this->userService->showStudents($request);
    }
    /**
     * SearchStudents
     */
    public function searchStudents(SearchRequest $request){
        return $this->userService->searchStudents($request);
    }
    /**
     * ChangePassword
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->userService->changePassword($request);
    }
    /**
     * Logout
     */
    public function userLogout(Request $request)
    {
        return $this->userService->logout($request);
    }

    public function redirect()
    {
        return $this->userService->redirectToGoogle();
    }

    public function callback(GoogleAuthRequest $request)
    {
        return $this->userService->handleGoogleCallback($request);
    }
    /**
     * GoogleLogout
     */
    public function googleLogout()
    {
        return $this->userService->googleLogout();
    }
}
