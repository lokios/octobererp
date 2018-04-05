<?php

namespace Olabs\Oims\Models;

use Model;
use Backend\Models\User;
use Backend\Models\UserGroup;
use Backend\Models\UserRole;
/**
 * Model
 */
class Employee extends User {

    //use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */

    public $rules = [
        'email'    => 'required|between:6,255|email|unique:backend_users',
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
    
     public function beforeCreate(){
        $this->role_id = $this->getEmployeeRole()->id;
    }
    
    public function afterCreate(){
        $group = $this->getEmployeeGroup();
        
        $this->groups()->add($group);
//        if(!$this->groups){
//            
//        }
//        $group = UserGroup::where('code','inventory_supplier')->first();
//        dd($this->groups);
       
    }
    
    public function getEmployeeGroup(){
        $model = UserGroup::where('code','employee')->first();
        return $model;
    }
    
    public function getEmployeeRole(){
        $model = UserRole::where('code','employee')->first();
        return $model;
    }

    
//    public function getSupplierTypeOptions() {
////        $list = $this->SUPPLIER_TYPES;//['material_supplier'=>'Material Supplier','petty_contractor'=>'Petty Contractor'];
//
//        
//
//        return  $this->SUPPLIER_TYPES;
//    }
//    
//    public function getSupplierType($code) {
////        $list = $this->SUPPLIER_TYPES;//['material_supplier'=>'Material Supplier','petty_contractor'=>'Petty Contractor'];
//
//        if(isset($this->SUPPLIER_TYPES[$code])){
//            return $this->SUPPLIER_TYPES[$code];
//        }
//
//        return  '';
//    }

    //
    // Scopes
    //
    
//    protected $primaryKey = 'id';



    
//    public function scopeIsActivated($query)
//    {
//        return $query->where('is_activated', 1);
//    }
//
//    public function scopeFilterByGroup($query, $filter)
//    {
////        dd($group);
//        return $query->whereHas('groups', function($group) use ($filter) {
//            $group->whereIn('id', $filter);
//        });
//    }
}
