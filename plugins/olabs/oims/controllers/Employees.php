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
        $filter = ['employee'];
//        $query->whereHas('groups', function ($q) {
//            $q->whereIn('code', 'inventory_supplier');
//        });
        $query->whereHas('groups', function($group) use($filter) {
            $group->whereIn('code', $filter);
        });
    }
    
}
