<?php

namespace App\Providers;

use App\Observers\ServiceUserObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\service_user;
class ServiceUserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       service_user::observe(ServiceUserObserver::class);
    }
}
