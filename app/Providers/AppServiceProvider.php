<?php

namespace SweetFace\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // MariaDB compatibility
        Schema::defaultStringLength(191);

        // Register these service providers only on non-production envs
        if ($this->app->environment('local', 'testing', 'acceptance')) {
            $this->app->register(\Sepehr\BehatLaravelJs\ServiceProvider::class);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
