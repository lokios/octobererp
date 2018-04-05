<?php namespace Olabs\Iot;

use System\Classes\PluginBase;
use App;
use Event;
use Backend;

use System\Classes\SettingsManager;
use Illuminate\Foundation\AliasLoader;
class Plugin extends PluginBase
{
    
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'IOT embedded system',
            'description' => 'IOT embedded system',
            'author' => 'Anuj Sinha',
            'icon' => 'icon-leaf'
        ];
    }
    
    public function registerComponents()
    {
        return [
//            'Olabs\Tenant\Components\Session'       => 'olabs_session',
//            'Olabs\Tenant\Components\Account'       => 'olabs_account',
//            'Olabs\Tenant\Components\ResetPassword' => 'olabs_resetPassword'
        ];
    }
    public function register()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('OlabsAuth', 'Backend\Facades\BackendAuth');


    }

    public function registerSettings()
    {
    }
    
    public function registerPermissions() {
        return [
            'olabs.iot.awsMessage' => ['tab' => 'IOT', 'label' => 'Manage IOT message response'],
        ];
    }
    
    public function registerNavigation() {
        return [
            'reports' => [
                'label' => 'Iot',
                'url' => \Backend::url('olabs/iot/awsMessages'),
                'icon' => 'icon-file',
                'permissions' => ['olabs.iot.awsMessage'],
                'order' => 500,
            ]
        ];
    }
}