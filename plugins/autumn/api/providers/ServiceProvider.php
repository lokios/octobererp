<?php

namespace Autumn\Api\Providers;

use Autumn\Api\Http\Middleware\ThrottleRequests;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->addMiddlewareAlias('api.throttle', ThrottleRequests::class);
    }

    /**
     * Register a short-hand name for a middleware.
     *
     * @param string $name
     * @param string $class
     */
    protected function addMiddlewareAlias($name, $class)
    {
        $router = $this->app['router'];

        $router->middleware($name, $class);
    }
}
