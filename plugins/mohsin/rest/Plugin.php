<?php namespace Mohsin\Rest;

use Backend;
use System\Classes\PluginBase;
use Mohsin\Rest\Classes\ApiManager;
use System\Classes\SettingsManager;

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
            'name'        => 'mohsin.rest::lang.plugin.name',
            'description' => 'mohsin.rest::lang.plugin.description',
            'author'      => 'Saifur Rahman Mohsin',
            'icon'        => 'icon-cloud'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('create.restcontroller', 'Mohsin\Rest\Console\CreateRestController');
    }

    public function boot()
    {
        // Register all the available API nodes
        $apiManager = ApiManager::instance();
    }

    /**
     * Registers settings controller for this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'mohsin.rest::lang.settings.name',
                'description' => 'mohsin.rest::lang.settings.description',
                'category'    => SettingsManager::CATEGORY_SYSTEM,
                'icon'        => 'icon-cloud',
                'url'         => Backend::url('mohsin/rest/settings'),
                'order'       => 507,
                'permissions' => ['mohsin.rest.access_settings'],
            ]
        ];
    }
}
