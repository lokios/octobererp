<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class Project extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_projects';
    
    /*
     * Relations
     */
    public $belongsTo = [
        'company' => ['Olabs\Oims\Models\Company']
    ];


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
    
    public function getFullBillingAddressAttribute()
    {
        $temp = array();
        if (!empty($this->billing_address)) {
            $temp[] = $this->billing_address;
        }
        if (!empty($this->billing_address_2)) {
            $temp[] = $this->billing_address_2;
        }
        
        if (!empty($this->billing_city)) {
            $temp[] = $this->billing_city;
        }

        if (!empty($this->billing_country)) {
                $temp[] = $this->billing_country; 
        }

        $add = implode(', ', $temp);

        if (!empty($this->billing_postcode)) {
                $add = ( trim($add) == "" ) ? $this->billing_postcode : $add. ' - ' . $this->billing_postcode;
        } 

        return $add;

    }
}