<?php

namespace Olabs\Messaging\Models;

use Model;
use DB;
use Lang;
use BackendAuth;

/**
 * Model
 */
class BaseModel extends Model {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_LIVE = 'L';
    const STATUS_DRAFT = 'D';
    const STATUS_OLD = 'O';

    public $comment;
    protected $settings_tenant_code;
    protected $settings_fcm_access_keys;
    protected $settings_messaging_api_url;
    protected $settings_messaging_api_key;

    public function beforeCreate() {

        $user = BackendAuth::getUser();
        
        if ($user && $this->created_by == '') {
            $this->created_by = $user->id;
        }
        if ($user && $this->updated_by == '') {
            $this->updated_by = $user->id;
        }
        if (isset($this->tenant_code) && $this->tenant_code == '') {
            $this->tenant_code = $this->getSettingsTenantCode();
        }
    }

    public function beforeUpdate() {
        $user = BackendAuth::getUser();
        if ($user && $this->updated_by == '') {
            $this->updated_by = $user->id;
        }
        if (isset($this->tenant_code) && $this->tenant_code == '') {
            $this->tenant_code = $this->getSettingsTenantCode();
        }
    }

    public function isStatusLive() {
        if ($this->status == self::STATUS_LIVE) {
            return true;
        }
        return FALSE;
    }

    public function isStatusDraft() {
        if ($this->status == self::STATUS_DRAFT) {
            return true;
        }
        return FALSE;
    }

    public function isStatusOld() {
        if ($this->status == self::STATUS_OLD) {
            return true;
        }
        return FALSE;
    }

    public function getSettingsTenantCode() {

        if ($this->settings_tenant_code == '') {
            $messagingSettings = \Olabs\Messaging\Models\Settings::instance();

            $this->settings_tenant_code = isset($messagingSettings->tenant_code) ? $messagingSettings->tenant_code : '';
        }

        return $this->settings_tenant_code;
    }

    /*
     * 
     */

    public function getSettingsFCMAccessKey($tenant_code = NULL) {

        $fcm_access_key = '';

        $tenant_code = $tenant_code == '' ? $this->getSettingsTenantCode() : $tenant_code;


        if ($this->settings_fcm_access_keys == '') {
            $messagingSettings = \Olabs\Messaging\Models\Settings::instance();

            $setting_fcm_access_keys = isset($messagingSettings->messaging_fcm) ? $messagingSettings->messaging_fcm : [];

            foreach ($setting_fcm_access_keys as $setting_fcm_access_key) {
                if(isset($setting_fcm_access_key->tenant_code) AND $setting_fcm_access_key->tenant_code != ''){
                    $this->settings_fcm_access_keys[$setting_fcm_access_key->tenant_code] = $setting_fcm_access_key->api_access_key;
                }
                

//            if($setting_fcm_access_key->tenant_code == $tenant_code){
//                $fcm_access_key = $setting_fcm_access_key->api_access_key;
//                break;
//            }
            }
        }


        if (isset($this->settings_fcm_access_keys[$tenant_code])) {
            $fcm_access_key = $this->settings_fcm_access_keys[$tenant_code];
        }

        return $fcm_access_key;

//        if ($this->settings_fcm_access_key == '') {
//            $messagingSettings = \Olabs\Messaging\Models\Settings::instance();
//
//            $this->settings_fcm_access_key = isset($messagingSettings->fcm_access_key) ? $messagingSettings->fcm_access_key : '';
//        }
//
//        return $this->settings_fcm_access_key;
    }

    public function getSettingsMessaginApiUrl() {

        if ($this->settings_messaging_api_url == '') {
            $messagingSettings = \Olabs\Messaging\Models\Settings::instance();

            $this->settings_messaging_api_url = isset($messagingSettings->messaging_api_url) ? $messagingSettings->messaging_api_url : '';
        }

        return $this->settings_messaging_api_url;
    }

    public function getSettingsMessaginApiKey() {

        if ($this->settings_messaging_api_key == '') {
            $messagingSettings = \Olabs\Messaging\Models\Settings::instance();

            $this->settings_messaging_api_key = isset($messagingSettings->messaging_api_key) ? $messagingSettings->messaging_api_key : '';
        }

        return $this->settings_messaging_api_key;
    }

}
