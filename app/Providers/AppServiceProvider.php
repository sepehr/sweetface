<?php

namespace SweetFace\Providers;

use Facebook\FacebookApp;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use SweetFace\Services\Facebook\UserStorer;
use SweetFace\Services\Facebook\Connect\Connect;
use SweetFace\Services\Facebook\UserStorerContract;
use SweetFace\Services\Facebook\Connect\ConnectContract;
use SweetFace\Services\Facebook\Connect\User as GraphUser;
use SweetFace\Services\Facebook\Connect\UserContract as GraphUserContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerContainerBindings();

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

    /**
     * Registers container bindings.
     *
     * @return void
     */
    private function registerContainerBindings()
    {
        $this->app->bind(ConnectContract::class, Connect::class);

        $this->app->bind(GraphUserContract::class, GraphUser::class);

        $this->app->bind(UserStorerContract::class, UserStorer::class);

        $this->app->when(FacebookApp::class)
            ->needs('$id')
            ->give(config('laravel-facebook-sdk.facebook_config.app_id'));

        $this->app->when(FacebookApp::class)
            ->needs('$secret')
            ->give(config('laravel-facebook-sdk.facebook_config.app_secret'));
    }
}
