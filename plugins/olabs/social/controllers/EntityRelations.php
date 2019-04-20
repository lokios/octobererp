<?php

namespace Olabs\Social\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;

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

    public function onSyncData($record_id) {
        $status = "";
        $model = new \Olabs\Social\Models\EntityRelations();

//        if($id){
        $record = \Olabs\Social\Models\EntityRelations::whereIn('target_type', array(\Olabs\Social\Models\EntityRelations::TARGET_TYPE_ATTENDANCE, \Olabs\Social\Models\EntityRelations::TARGET_TYPE_MR_ENTRY, \Olabs\Social\Models\EntityRelations::TARGET_TYPE_VOUCHERS))
                        ->where('status', \Olabs\Social\Models\EntityRelations::STATUS_LIVE)->where('id', $record_id)->first();
        if ($record) {
            $status = $model->SyncDataRecord($record);
        }

        Flash::success('Recored Synced.');
//        echo $status;
        return ["#object-status" => "Recored Synced."];
    }

}
