<?php

namespace Roam\Core\Metrics;

use Illuminate\Console\Command;
use Oneafricamedia\Core\Commands\AbstractDomainCodeCommand;

class MetricPushCommand extends AbstractDomainCodeCommand
{
    /**
     * @var string
     */
    protected $signature = 'metrics:push {--host=} {--db=}';

    /**
     * @var string
     */
    protected $description = 'Push metrics to InfluxDB for ops dashboard.';

    public function handle()
    {
        $host = $this->option('host') ?: config('metrics.host');
        $db = $this->option('db') ?: config('metrics.db');

        app(MetricService::class)->write($host, $db);
    }
}
