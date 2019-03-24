<?php

namespace Roam\Core\Metrics;

use Illuminate\Support\ServiceProvider;

class MetricServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__.'/../config/metrics.php' => config_path('metrics.php'),
            ]
        );

        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    MetricPullCommand::class,
                    MetricPushCommand::class,
                ]
            );
        }
    }

    public function register()
    {
        $this->app->singleton(
            MetricService::class,
            function ($app) {
                return new MetricService($app['config']->get('metrics.metrics', []));
            }
        );
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            MetricService::class,
        ];
    }
}
