<?php

namespace App\Providers;

use App\Listeners\LogLoginAttempt;
use App\Models\User;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

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
        // Register policies
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);

        // Register authentication event listeners
        Event::listen(Login::class, [LogLoginAttempt::class, 'handleLogin']);
        Event::listen(Logout::class, [LogLoginAttempt::class, 'handleLogout']);
        Event::listen(Failed::class, [LogLoginAttempt::class, 'handleFailed']);
    }
}
