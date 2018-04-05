<?php

namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Companies extends Controller {

    public $implement = [
        'Backend\Behaviors\ListController', 
        'Backend\Behaviors\FormController', 
        'Backend\Behaviors\ReorderController',
        ];
    
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = ['olabs.oims.companies'];
    
    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'oims_projects', 'companies');
    }

}