<?php namespace Olabs\Tenant;

use System\Classes\PluginBase;
use App;
use Event;
use Backend;

use System\Classes\SettingsManager;
use Illuminate\Foundation\AliasLoader;
class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Olabs\Tenant\Components\Session'       => 'olabs_session',
            'Olabs\Tenant\Components\Account'       => 'olabs_account',
            'Olabs\Tenant\Components\ResetPassword' => 'olabs_resetPassword'
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
}