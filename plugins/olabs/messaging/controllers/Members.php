<?php namespace Olabs\Messaging\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Members extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['olabs.messaging.members'];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Messaging', 'messaging', 'members');
    }
}
