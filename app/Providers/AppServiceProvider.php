<?php

namespace App\Providers;

use App\Services\Impl\StoryServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\Interfaces\StoryService;
use App\Services\Interfaces\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StoryService::class, StoryServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
