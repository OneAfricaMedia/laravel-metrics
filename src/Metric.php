<?php

namespace Roam\Core\Metrics;

use App;

abstract class Metric
{
    /**
     * @return bool
     */
    public function when()
    {
        return true;
    }

    /**
     * @param mixed $value
     * @param mixed $key
     *
     * @return string
     */
    public function map($value, $key): string
    {
        $key = trim((string) $key);

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        if (is_string($value)) {
            $value = trim($value);
            $value = str_replace('"', '\"', $value);
            $value = "\"$value\"";
        }

        return "$key=$value";
    }

    /**
     * @param array $values
     *
     * @return string
     */
    protected function generateValues(array $values): string
    {
        return collect($values)
            ->map([$this, 'map'])
            ->values()
            ->implode(',');
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $measurement = $this->measurement();
        $tags = $this->generateValues($this->tags());
        $fields = $this->generateValues($this->fields());
        $timestamp = (int) (microtime(true) * 10 ** 9);

        return "$measurement,$tags $fields $timestamp";
    }

    /**
     * Return the measurement string for the metric.
     *
     * Equivalent to a table of data, for example: listings
     *
     * @return string
     */
    abstract protected function measurement(): string;

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
        return [];
    }

    /**
     * Return the tags for the metric.
     *
     * For example:
     *
     * [
     *     'domain' => 'ke',
     * ]
     *
     * @return array
     */
    protected function tags(): array
    {
        return [];
    }
}
