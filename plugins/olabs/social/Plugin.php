<?php

namespace Olabs\Social;

use System\Classes\PluginBase;

class Plugin extends PluginBase {

    public function registerComponents() {
        
    }

    public function registerSettings() {
        
    }
    
    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return [
            'olabs.social.notifications' => ['tab' => 'olabs.social::lang.plugin.social', 'label' => 'olabs.social::lang.plugin.access_notifications'],
            'olabs.social.clients' => ['tab' => 'olabs.social::lang.plugin.social', 'label' => 'olabs.social::lang.plugin.access_clients'],
            'olabs.social.clientsbilling' => ['tab' => 'olabs.social::lang.plugin.social', 'label' => 'olabs.social::lang.plugin.access_clientsbilling'],
            'olabs.social.entityrelations' => ['tab' => 'olabs.social::lang.plugin.social', 'label' => 'olabs.social::lang.plugin.access_entityrelations'],
            
            ];
    }

}
