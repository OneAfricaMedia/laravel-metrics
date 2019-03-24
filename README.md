# laravel-metrics

Integrate Laravel with InfluxDB easily.

## Installation

Require the package into your project:

    composer require oneafricamedia/laravel-metrics

Publish the package config:

    php artisan vendor:publish --provider="Roam\Core\Metrics\MetricServiceProvider"

## Add a metric

Create a metric class in your project at _App\Metrics\UserMetric.php_ with the following contents:

    <?php

    namespace App\Metrics;

    use App;
    use App\Models\User;
    use Roam\Core\Metrics\Metric;

    class UserMetric extends Metric
    {
        /**
         * Return the measurement string for the metric.
         *
         * Equivalent to a table of data, for example: users
         *
         * @return string
         */
        protected function measurement(): string
        {
            return 'users';
        }

        /**
         * Return the fields for the metric.
         *
         * Equivalent to a record of data, for example:
         *
         * [
         *     'count' => 1234678,
         *     'newest' => 60,
         *     'online' => 2345678,
         * ]
         *
         * @return array
         */
        protected function fields(): array
        {
            return [
                'count' => User::count(),
            ];
        }

        /**
         * Return the tags for the metric.
         *
         * For example:
         *
         * [
         *     'domain' => 'blogs',
         * ]
         *
         * @return array
         */
        protected function tags(): array
        {
            return [
                'env' => App::environment(),
            ];
        }
    }

Add the newly defined metric to _config/metrics.php_:

    /**
     * Add metric classes here. They will be included in the
     * payload when pushing or pulling metrics.
     *
     * Classes must be descended from Roam\Core\Metrics\Metric class.
     */
    'metrics' => [
        App\Metrics\UserMetric::class,
    ],

Verify a correct metrics line is generated:

    php artisan metrics:pull

You should see something like:

    users,env=local count=25 1553423942735399936

Now verify that your _.env_ has the correct values. Defaults are below:

    INFLUXDB_HOST=http://127.0.0.1:8086
    INFLUXDB_DB=metrics

And finally push the metrics to _influxdb_:

    php artisan metrics:push

You can optionally specify the _host_ and _db_ on the command line above. See _--help_.

Open [_chronograf_](http://127.0.0.1:8888) to see the data.
