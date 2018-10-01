<?php

namespace Olabs\Oims\Models;

use Model;
use Kocholes\BarcodeGenerator\Classes\BarcodeManager;

/**
 * Model
 */
class OffroleEmployee extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    const CNAME = 'offrole';

    public function getEntityType() {
        return self::CNAME;
    }

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    
    public $rules = [
        'pan_number' => 'between:4,255|unique',
        'supplier_id' => 'required',
        'daily_wages' => 'required|numeric',
        'working_hour' => 'required|numeric'
    ];
    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];
    
    public $attachOne = [
        'avatar' => \System\Models\File::class
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_offrole_employees';
    public $belongsTo = [
        'project' => [
            'Olabs\Oims\Models\Project',
            'key' => 'project_id'
        ],
        'supplier' => [
            'Olabs\Oims\Models\Supplier',
            'key' => 'supplier_id'
        ],
        'employee_types' => [
            'Olabs\Oims\Models\EmployeeType',
            'key' => 'employee_type',
        ],
    ];

    public function scopeMatchProject($query, $model) {

        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
        if (!$projectId) {
            $assigned_projects = $this->getProjectOptions();
            //check with session value
            $projectId = array_keys($assigned_projects);//\Session::get('projectProgress_ProjectId', $projectId);
        }else{
            $projectId = array($projectId);
        }

        return $query->whereIn('project_id', $projectId); // ->orderBy('name', 'desc')
    }
    
    public function getOffRoleEmployeeType(){
        
        return isset($this->employee_types) ? $this->employee_types->name : $this->employee_types;
    }

        /**
     * @return string Returns the user's full name.
     */
    public function getFullNameAttribute()
    {
        return trim($this->name);
    }
    
    public function getEmployeeCodeAttribute() {
        $emp_code = "O" . str_pad($this->id, 8, "0", STR_PAD_LEFT);
        return $emp_code;
    }
    
    public function getCompanyNameAttribute() {
        $name = '';
        if ($this->project) {
            $name = isset($this->project->company) ? $this->project->company->name : '';
        }
        return $name;
    }
    
    public function getSupplierNameAttribute() {
        $name = '';
        if ($this->supplier) {
            $name = $this->supplier->getFullNameAttribute();
        }
        return $name;
    }
    
    public function getProjectNameAttribute() {
        $name = '';
        if ($this->project) {
            $name = $this->project->name ;
        }
        return $name;
    }
    
    public function getDOBAttribute(){
        return $this->date_of_birth != '' ? date('d/m/Y', strtotime($this->date_of_birth)) : '';
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
    
    /**
     * Returns the public image file path to this user's avatar.
     */
    public function getAvatarThumb($size = 25, $options = null)
    {
        if (is_string($options)) {
            $options = ['default' => $options];
        }
        elseif (!is_array($options)) {
            $options = [];
        }

        // Default is "mm" (Mystery man)
        $default = array_get($options, 'default', 'mm');

        if ($this->avatar) {
            return $this->avatar->getThumb($size, $size, $options);
        }
        else {
            return '//www.gravatar.com/avatar/' .
                md5(strtolower(trim($this->email))) .
                '?s='. $size .
                '&d='. urlencode($default);
        }
    }
    
    public function getProfileImageAttribute() {
        $profile_image = $this->getAvatarThumb('80');
        if ($profile_image != null) {
            return '<img src="' . $profile_image . '" alt="profile image"  />';
        } else {
            return "";
        }
    }
    
    public function getBarcode($format, $params = array()) {
        $manager = new BarcodeManager();

//        $barcode_string = $this->getEntityType() . "|" . $this->getEmployeeCodeAttribute() . "|" . $this->getFullNameAttribute() . "|" . $this->getSupplierNameAttribute() . "|" . $this->getProjectNameAttribute();
        $barcode_string =  $this->getBarcodeString();
//        dd($barcode_string);
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
    
    public function getBarcodeString(){
        $params = [
            'type' => $this->getEntityType(),
            'emp_code' => $this->getEmployeeCodeAttribute(),
            'emp_name' => $this->getFullNameAttribute(),
            'supplier_id' => 'None',
            'supplier_name' => 'None',
            'project_id' => 'None',
            'project_name' => 'None',
        ];
        
        if($this->project){
            $params['supplier_id'] = $this->supplier->id;
            $params['supplier_name'] = $this->getSupplierNameAttribute();
        }
        
        if($this->project){
            $params['project_id'] = $this->project->id;
            $params['project_name'] = $this->getProjectNameAttribute();
        }
        
        $barcode_string = implode('|', $params);
        
//        $barcode_array = ['data' => $params];
//        $barcode_string = json_encode($barcode_array)
                
        return $barcode_string;
    }

}
