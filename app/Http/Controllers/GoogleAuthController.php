<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\GoogleAuthRepositoryInterface;

class GoogleAuthController extends Controller
{
    protected $googleAuth;

    public function __construct(GoogleAuthRepositoryInterface $googleAuth)
    {
        $this->googleAuth = $googleAuth;
    }

    public function redirect()
    {
        return $this->googleAuth->redirect();
    }

    public function callback()
    {
        return $this->googleAuth->callback();
    }

    public function logout()
    {
        return $this->googleAuth->logout();
    }
}
