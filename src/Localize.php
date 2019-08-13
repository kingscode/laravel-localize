<?php

namespace KingsCode\LaravelLocalize;

use Illuminate\Contracts\Config\Repository as Config;

class Localize
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
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
        $options = implode('|', array_filter($this->getLocalePrefixes() ?? []));
        return "^($options)$";
    }
}
