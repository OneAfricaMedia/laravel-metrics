<?php

namespace Roam\Core\Metrics;

use Illuminate\Console\Command;
use Oneafricamedia\Core\Commands\AbstractDomainCodeCommand;

class MetricPullCommand extends AbstractDomainCodeCommand
{
    /**
     * @var string
     */
    protected $signature = 'metrics:pull';

    /**
     * @var string
     */
    protected $description = 'Pulls metrics for insertion into InfluxDB for ops dashboard.';

    public function handle()
    {
        $this->info(app(MetricService::class)->render());
    }
}
