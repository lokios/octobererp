<?php

namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class OffroleEmployee extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    const CNAME = 'offrole_employees';

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

}
