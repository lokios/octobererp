<?php namespace Olabs\Social\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class EntityRelations extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Social', 'messaging', 'entityrelations');
    }
    
    public function syncData(){
        $model = new \Olabs\Social\Models\EntityRelations();
        $status = $model->SyncData();
        echo $status;
        
    }
}