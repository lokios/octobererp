<?php

namespace Jenssegers\Date;

use Illuminate\Support\ServiceProvider;

class DateServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $localeChangedEvent = class_exists('\\Illuminate\\Foundation\\Events\\LocaleUpdated')
            ? \Illuminate\Foundation\Events\LocaleUpdated::class
            : 'locale.changed';

        $this->app['events']->listen($localeChangedEvent, function () {
            $this->setLocale();
        });

        $this->setLocale();
    }

    /**
     * Set the locale.
     */
    protected function setLocale()
    {
        $locale = $this->app['translator']->getLocale();

        Date::setLocale($locale);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Nothing.
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Date'];
    }
}
