<?php namespace Reportico\Reports;


use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
           '\Reportico\Reports\Components\ReporticoEngine' => 'ReporticoEngine'
        ];
    }

    public function pluginDetails()
    {
        return [
            'name'        => 'Reportico for October',
            'description' => 'Embeds Reportico into October',
            'author'      => 'Peter Deed',
            'icon'        => 'icon-sun-o'
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'reportico.reports::lang.plugin.name',
                'description' => 'SQL Reports within your October website',
                //'category'    => SettingsManager::CATEGORY_USERS,
                'icon'        => 'icon-text-file',
                //'class'       => 'RainLab\User\Models\Settings',
                'order'       => 500,
                //'permissions' => ['rainlab.users.access_settings'],
            ]
        ];

    }

    public function registerPermissions()
    {   
        return 
            [ 'reportico.reports.*' => [ 
                'label' => 'Access Reportico Reports',
                'tab' => 'Reports' 
                ] 
                ]
        ;
    }


    public function registerNavigation()
    {   
        return [
            'reports' => [
                'label'       => 'Reports',
                'url'         => \Backend::url('reportico/reports'),
                'icon'        => 'icon-text-file',
                'iconSvg'     => 'plugins/reportico/reports/assets/images/reportico-icon.svg',
                //'permissions' => ['reportico.reports.*'],
                'order'       => 500,
            ]
        ];
    }

}
