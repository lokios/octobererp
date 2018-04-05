<?php namespace Olabs\Pusher\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Activity extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Pusher', 'main-menu-item');
    }
}