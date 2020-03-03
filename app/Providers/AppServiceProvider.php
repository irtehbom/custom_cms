<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Projects;
use App\User;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        
        view()->composer('layouts.backend', function($view) {

            $projects = new Projects;
            $user = \Auth::user();
            
            return $view
            ->with('projects',$projects)
            ->with('user', $user);
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
