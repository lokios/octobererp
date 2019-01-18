<?php

namespace Olabs\Messaging\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

/**

  https://github.com/octobercms/october/issues/855
 * */
class Timeline extends Controller {

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend\Behaviors\ReorderController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

//    public $requiredPermissions = ['olabs.messaging.timeline'];

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Messaging', 'messaging', 'timeline');
    }

    //Extend user list by associated project list
    public function listExtendQuery($query, $scope) {

        $user = BackendAuth::getUser();

        $query->where('notification_type', 'web_push');
//        $query->where('target_id', '6');
        $query->where('target_id', $user->id);
        $query->where('target_type', 'user');
    }

}
