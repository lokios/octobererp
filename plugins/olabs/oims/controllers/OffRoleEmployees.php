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
    
    public function onPrintEmployeeIdCard($id) {
        $employee_id = get('id',$id);
        $employee_type = get('type', 'offrole'); //offrole / onrole

        if($employee_type == 'onrole'){
            $record = \Olabs\Oims\Models\Employee::find($employee_id);
        }else{
            $record = \Olabs\Oims\Models\OffroleEmployee::find($employee_id);
        }
        
        $style = '';
        $html = "<html><head><style>" . $style . "</style></head><body>";

        $html .= $this->makePartial('employee_id_card', [
            'record' => $record,
            'print_style' => get('style',12),
                ]);

        $html .= "</body></html>";

        echo $html;
        exit();
        
        
    }

}
