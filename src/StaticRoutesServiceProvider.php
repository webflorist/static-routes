<?php

namespace Webflorist\StaticRoutes;

use Illuminate\Support\ServiceProvider;
use Webflorist\StaticRoutes\Commands\GenerateCommand;

class StaticRoutesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->registerArtisanCommands();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();
        $this->registerService();
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/config/static-routes.php' => config_path('static-routes.php'),
        ]);
    }

    protected function registerArtisanCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class
            ]);
        }
    }

    protected function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/static-routes.php', 'static-routes');
    }

    protected function registerService()
    {
        $this->app->singleton(StaticRoutes::class, function () {
            return new StaticRoutes();
        });
    }
}