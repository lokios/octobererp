<?php

namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Employees extends Controller {

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend\Behaviors\ReorderController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $requiredPermissions = ['olabs.oims.employees'];

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'oims_projects', 'employees');
    }

    public function listExtendQuery($query) {
        // Extend the list query to filter by the user id
//        if ($this->userId)
//            $query->where('user_id', $this->userId);
        if (!$this->user->isAdmin()) {
            $baseModel = new \Olabs\Oims\Models\BaseModel();
            $assigned_projects = $baseModel->getProjectOptions();
            $query->whereIn('employee_project_id', array_keys($assigned_projects));
        }
        
        $filter = ['employee'];
//        $query->whereHas('groups', function ($q) {
//            $q->whereIn('code', 'inventory_supplier');
//        });
        $query->whereHas('groups', function($group) use($filter) {
            $group->whereIn('code', $filter);
        });
    }

    public function onPrintEmployeeIdCard() {
        $employee_ids = request('id', '');
        $employee_type = 'onrole'; //get('type', 'onrole'); //offrole / onrole
        $assigned_projects = [];


        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = $baseModel->getProjectOptions();

        if (!is_array($employee_ids)) {
            $employee_ids = explode(',', $employee_ids);
        }


        $records = \Olabs\Oims\Models\Employee::whereIn('id', $employee_ids)
                ->whereIn('employee_project_id', array_keys($assigned_projects))
                ->get();
        $style = '';
        $html = "<html><head><style>" . $style . "</style></head><body>";

        $html .= $this->makePartial('employee_id_card', [
            'records' => $records,
            'print_style' => get('style', 12),
        ]);

        $html .= "</body></html>";

        echo $html;
        exit();
    }

}
