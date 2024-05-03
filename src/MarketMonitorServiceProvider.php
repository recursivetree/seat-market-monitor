<?php

namespace RecursiveTree\Seat\MarketMonitor;

use Seat\Services\AbstractSeatPlugin;

class MarketMonitorServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'marketmonitor');
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'marketmonitor');
    }

    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @return string
     * @example SeAT Web
     *
     */
    public function getName(): string
    {
        return 'Market Monitor';
    }

    /**
     * Return the plugin repository address.
     *
     * @example https://github.com/eveseat/web
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/recursivetree/seat-market-monitor';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @return string
     * @example web
     *
     */
    public function getPackagistPackageName(): string
    {
        return 'seat-market-monitor';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @return string
     * @example eveseat
     *
     */
    public function getPackagistVendorName(): string
    {
        return 'recursivetree';
    }
}