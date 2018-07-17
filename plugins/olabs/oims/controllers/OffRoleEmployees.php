<?php

namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class OffRoleEmployees extends Controller {

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend\Behaviors\ReorderController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $requiredPermissions = ['olabs.oims.offrole_employees'];

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'oims_projects', 'offrole_employees');
    }

    //Extend user list by associated project list
    public function listExtendQuery($query, $scope) {

        if (!$this->user->isAdmin()) {
            $baseModel = new \Olabs\Oims\Models\BaseModel();
            $assigned_projects = $baseModel->getProjectOptions();
            $query->whereIn('project_id', array_keys($assigned_projects));
        }
    }
    
     public function onPrintEmployeeIdCard() {
        $employee_ids = request('id', '');
        $employee_type = 'offrole'; //get('type', 'onrole'); //offrole / onrole
        $assigned_projects = [];


        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = $baseModel->getProjectOptions();

        if (!is_array($employee_ids)) {
            $employee_ids = explode(',', $employee_ids);
        }


        $records = \Olabs\Oims\Models\OffroleEmployee::whereIn('id', $employee_ids)
                ->whereIn('project_id', array_keys($assigned_projects))
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
