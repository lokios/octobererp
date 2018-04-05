<?php

namespace Autumn\Api;

use App;
use System\Classes\PluginBase;
use Autumn\Api\Console\CreateApi;
use Autumn\Api\Providers\ServiceProvider;
use Barryvdh\Cors\ServiceProvider as CorsServiceProvider;

/**
 * Api Plugin Information File.
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Api',
            'description' => 'Tools for building RESTful HTTP + JSON APIs.',
            'author' => 'Autumn',
            'icon' => 'icon-paper-plane',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        App::register(CorsServiceProvider::class);
        App::register(ServiceProvider::class);

        $this->registerConsoleCommand('create.api', CreateApi::class);
    }
}
