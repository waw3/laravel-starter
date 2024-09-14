<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Gate;

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
        Builder::useVite();

        Gate::policy(App\Models\User::class, App\Policies\UserPolicy::class);
        Gate::policy(App\Models\Role::class, App\Policies\RolePolicy::class);
        Gate::policy(App\Models\Permission::class, App\Policies\PermissionPolicy::class);
        Gate::policy(App\Models\Blog::class, App\Policies\BlogPolicy::class);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
