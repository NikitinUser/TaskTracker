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
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TasksMain::observe(TasksMainObserver::class);
        User::observe(UserObserver::class);
    }
}
