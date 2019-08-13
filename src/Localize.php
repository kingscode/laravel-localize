<?php

declare(strict_types=1);

namespace KingsCode\LaravelLocalize;

use Illuminate\Contracts\Config\Repository;
use function implode;

class Localize
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get all the available locale.
     *
     * @return array
     */
    public function getLocalePrefixes(): array
    {
        return $this->config->get('localize.route_prefix_options', []);
    }

    /**
     * Generate regex that is used in the where to select {locale}.
     *
     * @return string
     */
    public function getRouteRegex(): string
    {
        return sprintf("^(%s)$", implode('|', $this->getLocalePrefixes()));
    }
}
