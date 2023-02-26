<?php

namespace SergeyBruhin\SeedFromJson\Providers;

use Illuminate\Support\ServiceProvider;
use SergeyBruhin\SeedFromJson\SeedFromJson;

class SeedFromJsonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'seed-from-json');
         $this->loadViewsFrom(__DIR__.'/../../resources/views', 'seed-from-json');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
//         $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

//        if ($this->app->runningInConsole()) {
//            $this->publishes([
//                __DIR__.'/../../config/config.php' => config_path('seed-from-json.php'),
//            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/seed-from-json'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/seed-from-json'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/seed-from-json'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
//        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
//        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'seed-from-json');

        // Register the main class to use with the facade
        $this->app->singleton('seed-from-json', function () {
            return new SeedFromJson();
        });
    }
}
