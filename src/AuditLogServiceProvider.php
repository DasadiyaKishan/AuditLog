<?php

namespace Kishan\AuditLog;

use Illuminate\Support\ServiceProvider;

class AuditLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load migration
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publish config
        $this->publishes([
            __DIR__.'/../config/audit-log.php' => config_path('audit-log.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/audit-log.php', 'audit-log');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
$this->loadViewsFrom(__DIR__.'/../resources/views', 'audit-log');

    }
}
