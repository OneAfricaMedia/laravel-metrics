<?php

return [
    'host' => env('INFLUXDB_HOST', 'http://127.0.0.1:8086'),
    'db' => env('INFLUXDB_DB', 'metrics'),

    /**
     * Add metric classes here. They will be included in the
     * payload when pushing or pulling metrics.
     *
     * Classes must be descended from Roam\Core\Metrics\Metric class.
     */
    'metrics' => [
        // App\Metrics\DatabaseMetric::class,
    ],
];
