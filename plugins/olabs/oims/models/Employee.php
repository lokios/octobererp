<?php

namespace Olabs\Oims\Models;

use Model;
use BackendAuth;
use Backend\Models\User;
use Backend\Models\UserGroup;
use Backend\Models\UserRole;
use Kocholes\BarcodeGenerator\Classes\BarcodeManager;

/**
 * Model
 */
class Employee extends User {

    //use \October\Rain\Database\Traits\Validation;

    const CNAME = 'onrole';

    public function getEntityType() {
        return self::CNAME;
    }

    /*
     * Validation
     */

    public $rules = [
        'email' => 'required|between:6,255|email|unique:backend_users',
//        'username' => 'required|between:2,255|unique:users',
        'password' => 'required:create|between:4,255|confirmed',
        'password_confirmation' => 'required_with:password|between:4,255',
        'pan' => 'between:4,255|unique:backend_users',
        'first_name' => 'required',
    ];

    /**
     * Relations
     */
    public $belongsToMany = [
        'groups' => ['Backend\Models\UserGroup',
            'table' => 'backend_users_groups',
            'key' => 'user_id',
            'otherKey' => 'user_group_id',
        ]
    ];

    public function beforeCreate() {
        $this->role_id = $this->getEmployeeRole()->id;
    }

    public function afterCreate() {
        $group = $this->getEmployeeGroup();

        $this->groups()->add($group);
    }

    public function getEmployeeGroup() {
        $model = UserGroup::where('code', 'employee')->first();
        return $model;
    }

    public function getEmployeeRole() {
        $model = UserRole::where('code', 'employee')->first();
        return $model;
    }

    
    public function getBarcode($format, $params = array()) {
        $manager = new BarcodeManager();

        $barcode_string = $this->getEntityType() . "|" . $this->getEmployeeCodeAttribute() . "|" . $this->getFullNameAttribute();

        if (!isset($params['data'])) {
            $params['data'] = $barcode_string;
        }
        if (!isset($params['type'])) {
            $params['type'] = 'QRCODE';
        }

        if (!isset($params['width'])) {
            $params['width'] = 2;
        }
        if (!isset($params['height'])) {
            $params['height'] = 30;
        }
        if (!isset($params['color'])) {
            $params['color'] = $format != 'PNG' ? 'black' : [0, 0, 0];
        }
        return $manager->getBarcode($format, $params['data'], strtoupper($params['type']), $params['width'], $params['height'], $params['color']);
    }

    public function getBarCodeImageAttribute() {
        $bar_code_image = $this->getBarcode('PNG');
        if ($bar_code_image != null) {
            return '<img src="data:image/png;base64,' . $bar_code_image . '" alt="barcode" width="80px" />';
        } else {
            return "";
        }
    }

    public function getFullAddressAttribute() {

        $temp = array();
        if (!empty($this->address)) {
            $temp[] = $this->address;
        }
        if (!empty($this->address_2)) {
            $temp[] = $this->address_2;
        }

        if (!empty($this->city)) {
            $temp[] = $this->city;
        }

        if (!empty($this->country)) {
            $temp[] = $this->country;
        }

        $add = implode(', ', $temp);

        if (!empty($this->postcode)) {
            $add = ( trim($add) == "" ) ? $this->postcode : $add . ' - ' . $this->postcode;
        }

        return $add;
    }

    public function getContactNumberAttribute() {
        return $this->contact_phone;
    }

    public function getCompanyNameAttribute() {
        $name = '';
        $user_project = UserProject::where('user_id', $this->id)->first();
        if ($user_project) {
            $name = isset($user_project->project->company) ? $user_project->project->company->name : '';
        }
        return $name;
    }

    public function getEmployeeCodeAttribute() {
        $emp_code = "E" . str_pad($this->id, 8, "0", STR_PAD_LEFT);
        return $emp_code;
    }

    public function getProfileImageAttribute() {
        $profile_image = $this->getAvatarThumb('80');
        if ($profile_image != null) {
            return '<img src="' . $profile_image . '" alt="profile image"  />';
        } else {
            return "";
        }
    }

}
