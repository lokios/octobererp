<?php namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ReferenceNumbers extends Controller
{
    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
//    public $reorderConfig = 'config_reorder.yaml';
    
    public $requiredPermissions = ['olabs.oims.reference_numbers'];

    
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'oims_projects', 'reference_numbers');
    }
}
