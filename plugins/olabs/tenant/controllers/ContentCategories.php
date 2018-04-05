<?php namespace Olabs\Tenant\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ContentCategories extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'manage.all.media' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Tenant', 'main-menu-item', 'side-menu-item5');
    }
}