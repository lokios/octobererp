<?php

namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Backend;

class ProjectBooks extends Controller {

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend\Behaviors\ReorderController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    
    public $requiredPermissions = ['olabs.oims.project_books'];

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'oims_projects', 'project_books');
    }
    
    
    public function update($recordId = null, $context = null) {
        parent::update($recordId, $context);
        //check if form is editable
        $model = \Olabs\Oims\Models\ProjectBook::find($recordId);
        if ($model->leaf_count != $model->leaf_balance) {
            Flash::warning('You are not permitted for update record! Book already is in use.');
//            redirect('purchases');
            $redirectUrl = 'olabs/oims/projectbooks'; // . $id;
            return Backend::redirect($redirectUrl);
        }
//        var_dump();exit();
    }

}
