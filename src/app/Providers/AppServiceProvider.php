<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TasksMain;
use App\Observers\TasksMainObserver;
use App\Models\User;
use App\Observers\UserObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TasksMain::observe(TasksMainObserver::class);
        User::observe(UserObserver::class);
    }
}
