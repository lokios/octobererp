<?php

namespace Olabs\Widgets\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ReportWidgets extends Controller {

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend\Behaviors\ReorderController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = ['olabs.widgets.manage_widgetss'];
    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'widgets', 'manage_widgets');
    }

}
