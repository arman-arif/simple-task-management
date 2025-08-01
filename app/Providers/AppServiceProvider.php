<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        Gate::define('update-task', function ($user, $task) {
            return $user->id == $task->user_id;
        });

        Gate::define('delete-task', function ($user, $task) {
            return $user->id == $task->user_id;
        });

        Gate::define('view-task', function ($user, $task) {
            return $user->id == $task->user_id;
        });
    }
}
