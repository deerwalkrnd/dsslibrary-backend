<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\GoogleAuthRepositoryInterface;
use App\Repositories\GoogleAuthRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(GoogleAuthRepositoryInterface::class, GoogleAuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
