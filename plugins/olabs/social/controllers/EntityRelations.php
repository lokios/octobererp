<?php

namespace Olabs\Social\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class EntityRelations extends Controller {

    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Social', 'messaging', 'entityrelations');
    }

    public function syncDataAll() {
        $model = new \Olabs\Social\Models\EntityRelations();
        $status = $model->SyncData();
        echo $status;
    }

    public function syncData($id) {
        $status = "";
        $model = new \Olabs\Social\Models\EntityRelations();

//        if($id){
        $record = EntityRelations::whereIn('target_type', array(self::TARGET_TYPE_ATTENDANCE, self::TARGET_TYPE_MR_ENTRY, self::TARGET_TYPE_VOUCHERS))
                        ->where('status', self::STATUS_LIVE)->where('id', $id)->get();
        if ($record) {
            $status = $model->SyncDataRecord($record);
        }

        echo $status;
    }

}
