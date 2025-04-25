<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\BookRepository;
use App\Repositories\BorrowBookRepository;
use App\Repositories\Contracts\BorrowBookRepositoryInterface;
use App\Services\UserService;
use App\Services\BookService;
use App\Services\BorrowBookService;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });
        $this->app->bind(BookRepositoryInterface::class,BookRepository::class);
        $this->app->bind(BookService::class, function ($app) {
            return new BookService($app->make(BookRepositoryInterface::class));
        });
        $this->app->bind(BorrowBookRepositoryInterface::class,BorrowBookRepository::class);
        $this->app->bind(BorrowBookService::class, function ($app) {
            return new BorrowBookService($app->make(BorrowBookRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Scramble::configure()
        ->withDocumentTransformers(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });
    }
}
