<?php

namespace Olabs\Oims\Models;

use Model;
use DateTime;
/**
 * Model
 */
class ProjectWork extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
        'planned_start_date' => 'required',
        'planned_end_date' => 'required|after_or_equal:planned_start_date',
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

    public function scopeMatchProject($query, $model) {

        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
        if (!$projectId) {
            //check with session value
            $projectId = \Session::get('projectProgress_ProjectId', $projectId);
        }
        //if still projectId is null then check with assign projects
        if (!$projectId) {
            $projects = $this->getProjectOptions();
            $projectId = array_keys($projects);
        }
//        dd($projectId); 
        $query->where('status', BaseModel::STATUS_ACTIVE);

        return is_array($projectId) ? $query->whereIn('project_id', $projectId) : $query->where('project_id', $projectId); // ->orderBy('name', 'desc')
    }

    public function filterFields($fields, $context = null) {
//        $fields->unit_code->value = "unit";
//        if ($this->product) {
//            dd($this->product->unit);
//            $fields->unit_code->value = $this->product->unit;
//            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
        $unitPriceValue = $fields->unit_price->value > 0 ? $fields->unit_price->value : 0;
        $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value;
//        }

//        $planned_start_date = \Olabs\Oims\Models\Settings::convertToDBDate($fields->planned_start_date->value);//$fields->planned_start_date->value != "" ? $fields->planned_start_date->value : "";
//        $planned_end_date =  \Olabs\Oims\Models\Settings::convertToDBDate($fields->planned_end_date->value);//$fields->planned_end_date->value != "" ? $fields->planned_end_date->value : "";
        $planned_start_date =  $fields->planned_start_date->value != "" ? $fields->planned_start_date->value : "";
        $planned_end_date =  $fields->planned_end_date->value != "" ? $fields->planned_end_date->value : "";
//        print($planned_start_date . "   "  . $planned_end_date);
        
        if ($planned_start_date != "" && $planned_end_date != "") {
            $datetime1 = new DateTime($planned_start_date);
            $datetime2 = new DateTime($planned_end_date);
            $interval = $datetime2->diff($datetime1);
            $total_days = $interval->format('%a') + 1; //to add current date 
            $fields->work_days->value = $total_days;
        }
    }

}
