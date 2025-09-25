<?php

namespace Rafiei\LaravelLogger\Laravel;

use Illuminate\Support\ServiceProvider;
use Rafiei\LaravelLogger\Contracts\LoggerInterface;
use Rafiei\LaravelLogger\Drivers\DatabaseLogger;
use Rafiei\LaravelLogger\Drivers\FileLogger;

class LoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/logger.php', 'logger');

        $this->app->singleton(LoggerInterface::class, function ($app) {
            $config = $app['config']['logger'];
            $driver = $config['driver'] ?? 'file';

            switch ($driver) {
                case 'database':
                    return new DatabaseLogger($config['database'] ?? []);
                case 'file':
                default:
                    return new FileLogger($config['file'] ?? []);
            }
        });

        $this->app->alias(LoggerInterface::class, 'logger');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/logger.php' => config_path('logger.php'),
        ], 'config');
    }
}