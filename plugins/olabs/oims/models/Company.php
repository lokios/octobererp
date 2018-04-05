<?php

namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class Company extends Model {

    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */

    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_companies';
    
    /*
     * Images
     */
    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];

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

}