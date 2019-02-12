<?php namespace Olabs\Messaging\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Circles extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['olabs.messaging.circles'];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Messaging', 'messaging', 'circles');
    }
}
