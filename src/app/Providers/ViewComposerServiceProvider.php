<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //        view()->composer('layouts.sidebar',function($view){
//$view->with('profile')
//        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        view()->composer('layouts.app','App\Http\Composers\SidebarComposer');
    }
}
