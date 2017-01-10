<?php

namespace Edofre\NsApi;

use Illuminate\Support\ServiceProvider;

/**
 * Class NsApiServiceProvider
 * @package Edofre\NsAPi
 */
class NsApiServiceProvider extends ServiceProvider
{
    /** Identifier for the service */
    const IDENTIFIER = 'laravel-ns-api';

    /**
     * Register bindings in the container.
     * @return void
     */
    public function register()
    {
        $this->app->bind(self::IDENTIFIER, function ($app) {
            return $app->make(NsApi::class);
        });
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        // publish the config file
        $this->publishes([
            __DIR__ . '/config/laravel-ns-api.php' => config_path('laravel-ns-api.php'),
        ], 'config');
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [self::IDENTIFIER];
    }
}