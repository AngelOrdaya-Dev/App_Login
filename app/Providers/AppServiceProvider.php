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
        if (str_contains(config('app.url'), 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $query = \App\Models\Notification::where('is_read', false);
                
                if ($user->isAdmin()) {
                    // Admin ve globales (null) y personales
                    $query->where(function($q) use ($user) {
                        $q->whereNull('user_id')->orWhere('user_id', $user->id);
                    });
                } else {
                    // Estudiante solo ve las suyas
                    $query->where('user_id', $user->id);
                }

                $notifications = (clone $query)->latest()->take(5)->get();
                $count = (clone $query)->count();

                $view->with('global_notifications', $notifications);
                $view->with('unread_notifications_count', $count);
            }
        });
    }
}
