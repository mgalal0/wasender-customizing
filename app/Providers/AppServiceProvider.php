<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        View::composer('frontend.layouts.header', function ($view) {
            $languages = get_option('languages', true);
            $view->with('languages', $languages);
        });

        View::composer('frontend.layouts.header-1', function ($view) {
            $languages = get_option('languages', true);
            $view->with('languages', $languages);
        });

        View::composer('frontend.layouts.header-2', function ($view) {
            $languages = get_option('languages', true);
            $view->with('languages', $languages);
        });
    }
}
