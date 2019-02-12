<?php

namespace Olabs\Messaging;

use Backend;
use System\Classes\PluginBase;
use Event;
use Validator;
use App;
use Illuminate\Foundation\AliasLoader;
use Config;
use File;
use Route;
use Redirect;
use Yaml;

/**
 * Oims Plugin Information File
 */
class Plugin extends PluginBase {
    /**
     * @var array Plugin dependencies
     */
//    public $require = ['RainLab.User'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'olabs.messaging::lang.plugin.name',
            'description' => 'olabs.messaging::lang.plugin.description',
            'author' => 'Amit Srivastava',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return [
        ];
    }

//    public function register() {
//        Backend\Facades\BackendMenu::registerContextSidenavPartial('Olabs.Oims', 'oims', '@/plugins/olabs/oims/partials/_sidebar.htm');
//    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return [
            'olabs.messaging.manage_messaging' => ['tab' => 'olabs.messaging::lang.plugin.messaging', 'label' => 'olabs.messaging::lang.plugin.access_manage_messaging'],
            'olabs.messaging.manage_settings' => ['tab' => 'olabs.messaging::lang.plugin.messaging', 'label' => 'olabs.messaging::lang.plugin.access_manage_settings'],
            'olabs.messaging.members' => ['tab' => 'olabs.messaging::lang.plugin.messaging', 'label' => 'olabs.messaging::lang.plugin.access_members'],
            'olabs.messaging.templates' => ['tab' => 'olabs.messaging::lang.plugin.messaging', 'label' => 'olabs.messaging::lang.plugin.access_templates'],
            'olabs.messaging.circles' => ['tab' => 'olabs.messaging::lang.plugin.messaging', 'label' => 'olabs.messaging::lang.plugin.access_circles'],
            'olabs.messaging.notifications' => ['tab' => 'olabs.messaging::lang.plugin.messaging', 'label' => 'olabs.messaging::lang.plugin.access_notifications'],
        ];
    }

    public function registerSettings() {
        return [
            'settings' => [
                'label' => 'olabs.messaging::lang.settings.menu_label',
                'description' => 'olabs.messaging::lang.settings.description',
                'category' => 'olabs.messaging::lang.settings.category',
                'icon' => 'icon-bell',
                'class' => 'Olabs\Messaging\Models\Settings',
                'order' => 69,
                'keywords' => 'messaging notification',
                'permissions' => ['olabs.insurance.access_settings']
            ]
        ];
    }

    /**
     * Main boot function
     */
    public function boot() {
        $this->bootBackendUserExtend();

        $messagingSettings = \Olabs\Messaging\Models\Settings::instance();
        $alias = AliasLoader::getInstance();
        
        $this->bootBackendControllerExtend();
        
    }

    /**
     * Extend the Backend Controller for Notify Widget controller to include the Backend\Classes\Controller too
     */
    private function bootBackendControllerExtend() {
        Backend\Classes\Controller::extend(function($controller) {

            $myWidget = new \Olabs\Messaging\Widgets\Notify($controller);
            $myWidget->alias = 'Notify';
            $myWidget->bindToController();
        });
    }
    

    /**
     * Extend plugin Backend.User
     */
    private function bootBackendUserExtend() {

        if (class_exists("Backend\Models\User")) {

            Backend\Models\User::extend(function($model) {

                $model->belongsToMany['userDevices'] = ['Olabs\Messaging\Models\UserDevice', 'table' => 'olabs_messaging_user_devices', 'conditions' => 'status=`L`'];
            });
        }
    }

}
