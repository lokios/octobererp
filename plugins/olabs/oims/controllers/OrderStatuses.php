<?php namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Order Statuses Back-end Controller
 */
class OrderStatuses extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];
    
    public $requiredPermissions = ['olabs.oims.orderstatuses'];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'oims_setup', 'orderstatuses');
    }
}