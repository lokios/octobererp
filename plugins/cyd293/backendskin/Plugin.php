<?php

namespace Cyd293\BackendSkin;

use Config;
use Event;
use System\Classes\PluginBase;
use Cyd293\BackendSkin\Listener\PluginEventSubscriber;
use Backend\Classes\Skin as AbstractSkin;

class Plugin extends PluginBase
{
    public $elevated = true;

    public function boot()
    {
        Config::set('cms.backendSkin', Skin\BackendSkin::class);

        Event::subscribe(new PluginEventSubscriber());
        \Backend\Classes\WidgetBase::extendableExtendCallback(function (\Backend\Classes\WidgetBase $widget) {
            $origViewPath = $widget->guessViewPath();
            $newViewPath = str_replace(base_path(), '', $origViewPath);
            $newViewPath = $this->getActiveSkin()->skinPath . '/views/' . $newViewPath . '/partials';
            $widget->addViewPath($newViewPath);
        });
    }

    public function registerComponents()
    {

    }

    public function registerSettings()
    {
    }

    /**
     * @return AbstractSkin
     */
    private function getActiveSkin()
    {
        return AbstractSkin::getActive();
    }
}
