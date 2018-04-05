<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class ProjectWork extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
    ];

    public $hasMany = [
        'products' => [
            'Olabs\Oims\Models\ProjectWorkProduct', 
            'key' => 'project_work_id',
//            'otherKey' => 'my_id'
        ],  
    ];
    
    public $belongsTo = [
        'work_group' => [
            'Olabs\Oims\Models\Workgroup', 
            'key' => 'work_group_id'
        ],
        'project' => [
            'Olabs\Oims\Models\Project', 
            'key' => 'project_id'
        ],
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
    ];
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_project_works';


    public function scopeMatchProject($query , $model)
    {

        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
        if(!$projectId){
            //check with session value
            $projectId = \Session::get('projectProgress_ProjectId', $projectId);
        }
        //if still projectId is null then check with assign projects
        if(!$projectId){
            $projects = $this->getProjectOptions();
            $projectId = array_keys($projects);
        }
//        dd($projectId); 
        
        return is_array($projectId) ? $query->whereIn('project_id', $projectId) : $query->where('project_id', $projectId); // ->orderBy('name', 'desc')
    }
    
    
    public function filterFields($fields, $context = null)
    {
//        $fields->unit_code->value = "unit";
//        if ($this->product) {
//            dd($this->product->unit);
//            $fields->unit_code->value = $this->product->unit;
//            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
            $unitPriceValue = $fields->unit_price->value > 0 ? $fields->unit_price->value : 0;
            $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value;
//        }
    }


}