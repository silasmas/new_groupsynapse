<?php

namespace App\Providers;


use Carbon\Carbon;
use App\Models\service_user;
use App\Observers\ServiceUserObserver;
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
        Carbon::setLocale('fr');
          service_user::observe(ServiceUserObserver::class);
    }
}
