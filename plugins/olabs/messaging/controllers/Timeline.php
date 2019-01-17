<?php namespace Olabs\Messaging\Controllers;


use Backend\Classes\Controller;
use BackendMenu;


/**

https://github.com/octobercms/october/issues/855
**/
class Timeline extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

//    public $requiredPermissions = ['olabs.messaging.timeline'];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Messaging', 'messaging', 'timeline');
    }
    
    




   


}