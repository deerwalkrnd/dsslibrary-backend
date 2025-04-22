<?php
namespace App\Repositories\Contracts;

interface GoogleAuthRepositoryInterface
{
    public function redirect();
    public function callback();
    public function logout();
}
