<?php

namespace App\Providers;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\ContactRepositoryInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\ContactRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Đăng ký các bindings cho Repository pattern
     */
    public function register(): void
    {
        // Bind ProjectRepositoryInterface với ProjectRepository implementation
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        // Bind ContactRepositoryInterface với ContactRepository implementation
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
