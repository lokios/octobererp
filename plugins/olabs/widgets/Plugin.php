<?php

namespace Olabs\Widgets;

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
            'name' => 'olabs.widgets::lang.plugin.name',
            'description' => 'olabs.widgets::lang.plugin.description',
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
            'olabs.widgets.manage_widgets' => ['tab' => 'olabs.widgets::lang.plugin.widgets', 'label' => 'olabs.widgets::lang.plugin.access_manage_widgets'],
        ];
    }

    public function registerSettings() {
        return [
//            'settings' => [
//                'label' => 'olabs.widgets::lang.settings.menu_label',
//                'description' => 'olabs.widgets::lang.settings.description',
//                'category' => 'olabs.widgets::lang.settings.category',
//                'icon' => 'icon-shopping-cart',
//                'class' => 'Olabs\Oims\Models\Settings',
//                'order' => 69,
//                'keywords' => 'security shop',
//                'permissions' => ['olabs.oims.access_settings']
//            ]
        ];
    }

    /**
     * Main boot function
     */
    public function boot() {
        
    }

    public function registerReportWidgets() {
        return [
            'Olabs\Widgets\ReportWidgets\CustomReportWidgets' => [
                'label' => 'Custom Report Widgets',
                'context' => 'dashboard'
            ],
            
        ];
    }

}
