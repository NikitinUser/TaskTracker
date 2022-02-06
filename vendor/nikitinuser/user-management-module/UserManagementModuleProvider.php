<?php

namespace NikitinUser\UserManagementModule;

use Illuminate\Support\ServiceProvider;

class UserManagementModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //   
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/lib/routes.php');
        $this->loadViewsFrom(__DIR__.'/lib/Views', 'user-management-module');
    }
}