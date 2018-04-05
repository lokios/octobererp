<?php namespace Mohsin\Rest;

use Backend;
use System\Classes\PluginBase;

/**
 * Rest Plugin Information File
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
            'name'        => 'RESTful',
            'description' => 'Generate RESTful controllers',
            'author'      => 'Mohsin',
            'icon'        => 'icon-cloud'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('create.restcontroller', 'Mohsin\Rest\Console\CreateRestController');
    }

}
