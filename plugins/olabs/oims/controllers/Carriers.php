<?php namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Carriers Back-end Controller
 */
class Carriers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];
    
    public $requiredPermissions = ['olabs.oims.carriers'];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'oims_setup', 'carriers');
    }
}