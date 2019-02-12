<?php

namespace Cyd293\BackendSkin\Skin;

use Config;
use Event;
use File;
use Input;
use Backend\Classes\Skin;
use Cms\Classes\Theme;
use October\Rain\Router\Helper as RouterHelper;


use BackendAuth; //Added by Amit;
/**
 * Description of BackendSkin
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class BackendSkin extends Skin
{
    public function __construct()
    {
        $this->skinPath = $this->defaultSkinPath = base_path() . '/modules/backend';
        $this->publicSkinPath = $this->defaultPublicSkinPath = File::localToPublic($this->skinPath);

        $skin = $this->getSkin();
        
        $super_admin = isset(BackendAuth::getUser()->is_superuser) ? BackendAuth::getUser()->is_superuser : FALSE;
        
        if ($skin != 'octobercms' && !$super_admin) {
            $this->skinPath = base_path() . '/themes/' . $skin . '/backend';
            $this->publicSkinPath = File::localToPublic($this->skinPath);
        }
    }

    public function getSkin()
    {
        
        if (Input::has('_skin')) {
            \Cookie::forget('backend_skin');
            $skin = Input::get('_skin');
            \Cookie::queue('backend_skin', $skin, 1);
        } elseif (\Cookie::has('backend_skin')) {
            $skin = \Cookie::get('backend_skin');
        } else {
            // $skin = Config::get('cyd293.backendskin::skin');
            $activeTheme = Theme::getActiveTheme();
            $skin = $activeTheme->getDirName();
        }

        return $skin;
    }

    public function skinDetails()
    {
        return [
            'name' => 'Customizable Skin',
        ];
    }

    public function getPath($path = null, $isPublic = false)
    {
        $path = RouterHelper::normalizeUrl($path);
        $assetFile = $this->skinPath . $path;
        if (File::isFile($assetFile)) {
            return $isPublic
                ? $this->publicSkinPath . $path
                : $this->skinPath . $path;
        }
        else {
            return $isPublic
                ? $this->defaultPublicSkinPath . $path
                : $this->defaultSkinPath . $path;
        }
    }
}
