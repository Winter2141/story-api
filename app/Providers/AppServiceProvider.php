<?php

namespace App\Providers;

use App\Services\Impl\StoryServiceImpl;
use App\Services\Interfaces\StoryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StoryService::class, StoryServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
