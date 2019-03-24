<?php

namespace Roam\Core\Metrics;

use Exception;
use GuzzleHttp\Client;

class MetricService
{
    /**
     * @var array
     */
    protected $classes;

    /**
     * @param array $classes
     */
    public function __construct(array $classes)
    {
        $this->classes = $classes;
    }

    /**
     * @return string
     */
    public function render()
    {
        $lines = [];

        foreach ($this->classes as $class) {
            $metric = new $class();

            if ($metric->when()) {
                $lines[] = $metric->render();
            }
        }

        return implode("\n", $lines);
    }

    /**
     * @param string $host
     * @param string $db
     *
     * @throws Exception
     */
    public function write(string $host, string $db)
    {
        if (!class_exists(Client::class)) {
            throw new Exception('Install guzzlehttp/guzzle to use the metrics:push command');
        }

        $client = new Client();

        foreach ($this->classes as $class) {
            $metric = new $class();

            if ($metric->when()) {
                $client->post(
                    $host . '/write?db=' . $db,
                    ['body' => $metric->render()]
                );
            }
        }
    }
}
