<?php namespace Mohsin\Rest\Models;

use Model;

/**
 * Settings Model
 */
class Setting extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'mohsin_rest_settings';

    public $settingsFields = 'fields.yaml';
}
