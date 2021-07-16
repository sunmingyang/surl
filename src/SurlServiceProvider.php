<?php

namespace HaiXin\Surl;

use Illuminate\Support\ServiceProvider;

class SurlServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerPublishing();
    }
    
    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
    
    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'surl-migration');
    
            $this->publishes([
                __DIR__.'/../config/surl.php' => config_path('surl.php'),
            ], 'surl-config');
        }
    }
    
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/surl.php', 'surl');
    
        // Register the service the package provides.
        $this->app->singleton('surl', function ($app) {
            return new Surl($app['config']->get('surl'));
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['surl'];
    }
}
