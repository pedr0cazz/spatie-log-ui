<?php

namespace ActivityLogSpatieUi\SpatieLogUi;

use Illuminate\Support\ServiceProvider;

class SpatieLogUiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'spatie_log_ui');

        // Publish assets
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/spatie_log_ui'),
        ], 'spatie-log-ui-views');
    }

    public function register()
    {
        // Register any package services here
    }
}
