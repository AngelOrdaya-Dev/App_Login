<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $view->with('global_notifications', \App\Models\Notification::where('is_read', false)->latest()->take(5)->get());
                $view->with('unread_notifications_count', \App\Models\Notification::where('is_read', false)->count());
            }
        });
    }
}
