<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class Project extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    
    /*
     * Validation
     */
    public $rules = [
        'slug' => [
//            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_oims_projects',
        ],      
    ];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_projects';
    
    /*
     * Relations
     */
    public $belongsTo = [
        'company' => ['Olabs\Oims\Models\Company'],
        'customer' => ['Olabs\Oims\Models\Customer']
    ];


     public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];
     
     public function scopeUserProject($query , $model)
    {

//        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
//        if(!$projectId){
//            //check with session value
//            $projectId = \Session::get('projectProgress_ProjectId', $projectId);
//        }
//        //if still projectId is null then check with assign projects
//        if(!$projectId){
//            $projects = $this->getProjectOptions();
//            $projectId = array_keys($projects);
//        }
////        dd($projectId); 
//        $query->where('status', BaseModel::STATUS_ACTIVE);
        
        return $query->where('status', BaseModel::STATUS_ACTIVE); // ->orderBy('name', 'desc')
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
    
//    public function scopeMatchProjects($query, $model){
//        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
////        
////        if (!$projectId) {
////            //check with session value
////            $projectId = \Session::get('purchase_ProjectId', $projectId);
////        }
//        //if still projectId is null then check with assign projects
//        if (!$projectId) {
//            $projects = $this->getProjectOptions();
//            $projectId = array_keys($projects);
//        }
//        dd($this->getProjectOptions());
//        //check for quote type Petty Contract
////        $query->where('quote_type', self::QUOTE_TYPE_MATERIAL);
//
//        return is_array($projectId) ? $query->whereIn('id', $projectId) : $query->where('id', $projectId); // ->orderBy('name', 'desc')
//    }
}