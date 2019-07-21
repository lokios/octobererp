<?php

namespace Cyd293\BackendSkin\Classes;

use App;
use File;
use Input;
use Config;
use System\Models\Parameter;
use Event;


/**
 * Description of Skin
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class Skin
{
    const ACTIVE_KEY = 'cyd293.backendskin::skin.active';
    const SKIN_DEFAULT = 'octobercms';

    protected static $activeSkinCache = null;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $path;

    /**
     * Load specific skin base on code
     *
     * @param string $code
     *
     * @return Skin Return the skin with the give code
     */
    public static function load($code)
    {
        $instance = new static;
        $instance->setCode($code);

        return $instance;
    }

    /**
     * Get active skin
     *
     * @return Skin Return the active skin
     */
    public static function getActiveSkin()
    {
        if (self::$activeSkinCache !== null) {
            return self::$activeSkinCache;
        }

        return self::$activeSkinCache = static::load(static::getActiveSkinCode());
    }

    /**
     * Get the code of active skin
     *
     * @return string Return the active skin code
     */
    public static function getActiveSkinCode()
    {
        $activeSkin = static::SKIN_DEFAULT;
        $dbResult = null;
        

        
        if (\Input::has('_skin')) {
            \Cookie::forget('backend_skin');
            $activeSkin = Input::get('_skin');
            \Cookie::queue('backend_skin', $activeSkin, 1);

            return $activeSkin;
        } elseif (\Cookie::has('backend_skin')) {
            $activeSkin = \Cookie::get('backend_skin');

            return $activeSkin;
        }

        if (App::hasDatabase()) {
            $dbResult = Parameter::applyKey(self::ACTIVE_KEY)->value('value');
            if ($dbResult !== null && $dbResult !== static::SKIN_DEFAULT && static::exists($dbResult)) {
                $activeSkin = $dbResult;
            }
        }

        if ($dbResult === null) {
            $activeThemeCode = Config::get('cyd293.backendskin::activeSkin');
            if ($activeThemeCode !== static::SKIN_DEFAULT && static::exists($activeThemeCode)) {
                $activeSkin = $activeThemeCode;
            } else {
                $activeThemeCode = \Cms\Classes\Theme::getActiveThemeCode();
                if (static::exists($activeThemeCode)) {
                    $activeSkin = $activeThemeCode;
                }
            }
        }
        
        //Show default theme to super admin : by Amit
        $super_admin = isset(\BackendAuth::getUser()->is_superuser) ? \BackendAuth::getUser()->is_superuser : FALSE;
        if ($super_admin) {
            $activeSkin = static::SKIN_DEFAULT;
        }

        return $activeSkin;
    }

    /**
     * Check if a directory is exists
     *
     * @return bool Return TRUE if skin is exists, otherwise FALSE
     */
    public static function exists($dirName)
    {
        $exists = false;
        foreach (static::possiblePaths($dirName) as $path) {
            if (File::isDirectory($path)) {
                $exists = true;
                break;
            }
        }

        return $exists;
    }

    /**
     * Set the active skin
     *
     * @param string $code
     */
    public static function setActiveSkin($code)
    {
        self::resetCache();

        Parameter::set(self::ACTIVE_KEY, $code);

        Event::fire('backendskin.setActiveSkin', compact('code'));
    }

    public static function resetCache()
    {
        self::$activeSkinCache = null;
    }

    /**
     * Set skin code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        $this->setPath();
    }

    /**
     * Get skin code
     *
     * @return string Return the skin code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the directory path of the skin
     *
     * @return string Return the path of the skin
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the default path of the skin
     * This will return base_path() . '/modules/backend' always
     *
     * @return string Return the default path
     */
    public function getDefaultPath()
    {
        return base_path() . '/modules/backend';
    }

    /**
     * Set the skin path
     */
    private function setPath()
    {
        if ($this->code === static::SKIN_DEFAULT) {
            $this->path = $this->getDefaultPath();

            return;
        }

        foreach ($this->possiblePaths($this->code) as $path) {
            if (File::isDirectory($path)) {
                $this->path = $path;
                break;
            }
        }
    }

    /**
     * Get all possible paths
     *
     * @return array Return array of possible paths for skin
     */
    private static function possiblePaths($dirName)
    {
        return [
            base_path() . '/backendskins/' . $dirName,
            base_path() . '/themes/' . $dirName . '/backend',
        ];
    }
}
