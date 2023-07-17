<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        //
        /*
            Sharing Data With All Views
            
            Occasionally, you may need to share data with all views that are rendered by your application. You may do so using the
            View facade's share method. Typically, you should place calls to the share method within a service provider's boot method.
            You are free to add them to the App\Providers\AppServiceProvider class or generate a separate service provider to house them
        */
        View::share('website_name', 'Belajar Laravel');
    }
}
