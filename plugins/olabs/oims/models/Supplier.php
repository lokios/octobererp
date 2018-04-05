<?php

namespace Olabs\Oims\Models;

use Model;
use Backend\Models\User;
use Backend\Models\UserGroup;
use Backend\Models\UserRole;
/**
 * Model
 */
class Supplier extends User {

    //use \October\Rain\Database\Traits\Validation;

    
    const SUPPLIER_TYPE_PETTY_CONTRACTOR = 'petty_contractor';
    const SUPPLIER_TYPE_MATERIAL_SUPPLIER = 'material_supplier';
    
    protected $SUPPLIER_TYPES = ['material_supplier'=>'Material Supplier','petty_contractor'=>'Petty Contractor'];
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
        $this->role_id = $this->getSupplierRole()->id;
    }

    public function afterCreate(){
        $group = $this->getSupplierGroup();
        
        $this->groups()->add($group);
//        if(!$this->groups){
//            
//        }
//        $group = UserGroup::where('code','inventory_supplier')->first();
//        dd($this->groups);
       
    }
    
    public function getSupplierGroup(){
        $model = UserGroup::where('code','inventory_supplier')->first();
        return $model;
    }
    
    public function getSupplierRole(){
        $model = UserRole::where('code','inventory_supplier')->first();
        return $model;
    }

    public function getSupplierTypeOptions() {
//        $list = $this->SUPPLIER_TYPES;//['material_supplier'=>'Material Supplier','petty_contractor'=>'Petty Contractor'];

        

        return  $this->SUPPLIER_TYPES;;
    }
    
    public function getSupplierType($code) {
//        $list = $this->SUPPLIER_TYPES;//['material_supplier'=>'Material Supplier','petty_contractor'=>'Petty Contractor'];

        if(isset($this->SUPPLIER_TYPES[$code])){
            return $this->SUPPLIER_TYPES[$code];
        }

        return  '';
    }
    
    public function getFullAddressAttribute()
    {
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
                $add = ( trim($add) == "" ) ? $this->postcode : $add. ' - ' . $this->postcode;
        } 

        return $add;

    }


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