<?php

namespace NikitinUser\UserManagementModule;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('role', function ($role){
            return "<?php if(auth()->check() && auth()->user()->hasRole($role)): ?>";
        });
        Blade::directive('endrole', function ($role){
            return "<?php endif; ?>";
        });
        
        $this->loadRoutesFrom(__DIR__.'/lib/routes.php');
        $this->loadViewsFrom(__DIR__.'/lib/Views', 'user-management-module');
    }
}