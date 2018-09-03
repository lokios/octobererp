<?php

namespace Olabs\Oims\Models;

use Model;
use DB;
use Lang;
use BackendAuth;

/**
 * Model
 */
class BaseModel extends Model {

    const USER_GROUP_EMPLOYEE = 'employee';
    const USER_GROUP_SUPPLIER = 'inventory_supplier';
    const USER_GROUP_CUSTOMER = 'inventory_customer';
    const USER_GROUP_SITE_ENCHARGE = 'inventory_site_encharge';
    const USER_GROUP_PROJECT_ENCHARGE = 'project_encharge';
    const USER_GROUP_ADMIN = 'inventory_administrator';
    const ATTENDANCE_WORKING_HOUR = 8; //default working hours for attendance
    const ATTENDANCE_GRACE_TIME = 1; //default grace time total working hours
    const ATTENDANCE_LUNCH_HOUR = 0; //default lunch time
    const ATTENDANCE_WORKING_HOUR_ONROLE = 9; //default working hours for on role employee
    const PAYMENT_METHOD_NOT_PAID = 0;
    const PAYMENT_METHOD_CASH = 1;
    const PAYMENT_METHOD_BANK_TRANSFER = 2;
    const PAYMENT_METHOD_CHEQUE = 3;
    const PAYMENT_METHOD_DEMAND_DRAFT = 4;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const LEDGER_TYPE_PAYMENT = 'payment';
    const LEDGER_TYPE_REVENUE = 'revenue';

    public $comment;

    public function getUserGroups() {
        $groups = [];
        $user = BackendAuth::getUser();
//        dd($user->groups);
        foreach ($user->groups as $group) {
            $groups[] = $group->code;
        }

        return $groups;
    }

    public function beforeCreate() {

//        if($this->status == ''){
//            $this->status = Status::STATUS_NEW;
//        }

        $user = BackendAuth::getUser();
        if ($this->created_by == '') {
            $this->created_by = $user->id;
        }
        if ($this->updated_by == '') {
            $this->updated_by = $user->id;
        }
    }

    public function beforeUpdate() {
        $user = BackendAuth::getUser();
        if ($this->updated_by == '') {
            $this->updated_by = $user->id;
        }
    }

    public function afterUpdate() {

        if ($this->status == Status::STATUS_APPROVED) {
            //save in Status history
            $history = new StatusHistory();
            $history->_recordUpdated($this);
        }
    }

    public function getProjectOptions() {
        $list = [];

        $user = BackendAuth::getUser();
        if (!$user->isAdmin()) {
//            foreach ($user->projects as $project) {
//                $list[$project->id] = $project->name;
//            }
            $list = $user->projects->lists('name', 'id');
        } else {
            $list = Project::where('status', self::STATUS_ACTIVE)->get()->lists('name', 'id');
        }

        return $list;
    }

    public function getProjectToOptions() {
        $list = [];

        $user = BackendAuth::getUser();
        if (!$user->isAdmin()) {
//            foreach ($user->projects as $project) {
//                $list[$project->id] = $project->name;
//            }
            $list = $user->projects->lists('name', 'id');
        } else {
            $list = Project::all()->lists('name', 'id');
        }

        return $list;
    }

    public function getBankAccountOptions() {

        $list = BankAccount::select(
                        DB::raw("CONCAT_WS(' ', bank_code, '|', account_number) AS name, id")
                )->where('status', '1')->lists('name', 'id');
        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $list;
    }

    public function getCustomerOptions() {
        $filter = self::USER_GROUP_CUSTOMER; //'inventory_customer'; //group code
        $usersList = \Backend\Models\User::select(
                        DB::raw("CONCAT_WS(' ', id, '|', first_name, last_name) AS name, id")
                )->whereHas('groups', function($group) use ($filter) {
                    $group->where('code', $filter);
                })->lists('name', 'id');
        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $usersList;
    }

    public function getSupplierOptions() {
        $filter = self::USER_GROUP_SUPPLIER; //'inventory_supplier';
        $usersList = \Backend\Models\User::select(
                        DB::raw("CONCAT_WS(' ', id, '|', first_name, last_name) AS name, id")
                )->whereHas('groups', function($group) use ($filter) {
                    $group->where('code', $filter);
                })->lists('name', 'id');

        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $usersList;
    }

    public function getEmployeeOptions() {
        $filter = self::USER_GROUP_EMPLOYEE; //'inventory_supplier';
        $usersList = \Backend\Models\User::select(
                        DB::raw("CONCAT_WS(' ', id, '|', first_name, last_name) AS name, id")
                )->whereHas('groups', function($group) use ($filter) {
                    $group->where('code', $filter);
                })->lists('name', 'id');

        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $usersList;
    }

    public function getSupplierPettyContractorOptions() {
        $filter = self::USER_GROUP_SUPPLIER; //'inventory_supplier';
        $usersList = \Backend\Models\User::select(
                                DB::raw("CONCAT_WS(' ', id, '|', first_name, last_name) AS name, id")
                        )->where('supplier_type', Supplier::SUPPLIER_TYPE_PETTY_CONTRACTOR)
                        ->whereHas('groups', function($group) use ($filter) {
                            $group->where('code', $filter);
                        })->lists('name', 'id');

        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $usersList;
    }

    public function getSupplierMaterialSupplierOptions() {
        $filter = self::USER_GROUP_SUPPLIER; //'inventory_supplier';
        $usersList = \Backend\Models\User::select(
                                DB::raw("CONCAT_WS(' ', id, '|', first_name, last_name) AS name, id")
                        )->where('supplier_type', Supplier::SUPPLIER_TYPE_MATERIAL_SUPPLIER)
                        ->whereHas('groups', function($group) use ($filter) {
                            $group->where('code', $filter);
                        })->lists('name', 'id');

        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $usersList;
    }

    public function onSubmitForApproval() {
        $msg = [];
        //check for current status it should be new or rejected for resubmit
        if ($this->status != Status::STATUS_NEW && $this->status != Status::STATUS_REJECTED) {
            $msg['s'] = false;
            $msg['m'] = 'Current status of recored is not new or rejected!';

            return $msg;
        }

        $this->status = Status::STATUS_SUBMITTED;
        $this->save();

        //save in Status history
        $history = new StatusHistory();
        $history->_statusChange($this);


        $msg['s'] = true;
        $msg['m'] = 'Record submitted for approval successfully!';


        return $msg;
    }

    public function onApproved() {
        $msg = [];
        //check for current status
        if ($this->status != Status::STATUS_SUBMITTED) {
            $msg['s'] = false;
            $msg['m'] = 'Current status of recored is not submitted!';

            return $msg;
        }

        $this->status = Status::STATUS_APPROVED;
        $this->save();

        //save in Status history
        $history = new StatusHistory();
        $history->_statusChange($this);


        $msg['s'] = true;
        $msg['m'] = 'Record approved successfully!';


        return $msg;
    }

    public function onRejected() {
        $msg = [];
        //check for current status
        if ($this->status != Status::STATUS_SUBMITTED) {
            $msg['s'] = false;
            $msg['m'] = 'Current status of recored is not submitted!';

            return $msg;
        }

        $this->status = Status::STATUS_REJECTED;
        $this->save();

        //save in Status history
        $history = new StatusHistory();
        $history->_statusChange($this);


        $msg['s'] = true;
        $msg['m'] = 'Record rejected successfully!';


        return $msg;
    }

    public function onSubmitForHOApproval() {
        $msg = [];
        //check for current status it should be new or rejected for resubmit
        if ($this->status != Status::STATUS_HO_REJECTED) {
            $msg['s'] = false;
            $msg['m'] = 'Current status of recored is not HO rejected!';

            return $msg;
        }

        $this->status = Status::STATUS_HO_SUBMITTED;
        $this->save();

        //save in Status history
        $history = new StatusHistory();
        $history->_statusChange($this);


        $msg['s'] = true;
        $msg['m'] = 'Record submitted for HO approval successfully!';


        return $msg;
    }

    public function onHOApproved() {
        $msg = [];
        //check for current status
        if ($this->status != Status::STATUS_APPROVED && $this->status != Status::STATUS_HO_SUBMITTED) {
            $msg['s'] = false;
            $msg['m'] = 'Current status of recored is not approved or submitted for HO approval!';

            return $msg;
        }

        $this->status = Status::STATUS_HO_APPROVED;
        $this->save();

        //save in Status history
        $history = new StatusHistory();
        $history->_statusChange($this);


        $msg['s'] = true;
        $msg['m'] = 'Record approved by HO successfully!';


        return $msg;
    }

    public function onHORejected() {
        $msg = [];
        //check for current status
        if ($this->status != Status::STATUS_APPROVED && $this->status != Status::STATUS_HO_SUBMITTED) {
            $msg['s'] = false;
            $msg['m'] = 'Current status of recored is not approved or submitted for HO approval!';

            return $msg;
        }

        $this->status = Status::STATUS_HO_REJECTED;
        $this->save();

        //save in Status history
        $history = new StatusHistory();
        $history->_statusChange($this);


        $msg['s'] = true;
        $msg['m'] = 'Record rejected by HO successfully!';


        return $msg;
    }

    public function isStatusNew() {
        if ($this->status == Status::STATUS_NEW) {
            return true;
        }
        return FALSE;
    }

    public function isStatusSubmitted() {
        if ($this->status == Status::STATUS_SUBMITTED) {
            return true;
        }
        return FALSE;
    }

    public function isStatusApproved() {
        if ($this->status == Status::STATUS_APPROVED) {
            return true;
        }
        return FALSE;
    }

    public function isStatusRejected() {
        if ($this->status == Status::STATUS_REJECTED) {
            return true;
        }
        return FALSE;
    }

    public function isStatusHOSubmitted() {
        if ($this->status == Status::STATUS_HO_SUBMITTED) {
            return true;
        }
        return FALSE;
    }

    public function isStatusHOApproved() {
        if ($this->status == Status::STATUS_HO_APPROVED) {
            return true;
        }
        return FALSE;
    }

    public function isStatusHORejected() {
        if ($this->status == Status::STATUS_HO_REJECTED) {
            return true;
        }
        return FALSE;
    }

    /**
     * Check recored is editable
     * @return boolean
     */
    public function isEditable() {

        $user = BackendAuth::getUser();

        $access_projects = $this->getProjectOptions();
        $access_projects = array_keys($access_projects);
        //project permission check
        if (!in_array($this->project_id, $access_projects)) {
            return FALSE;
        }

        //IF Entry is New 
        if ($this->isStatusNew()) {
            return true;
        }

        //IF entry is rejected by Project Enchagre and user have permission for Submit for approval
        if ($this->isStatusRejected() && $user->hasAccess('olabs.oims.record_submit_for_approval') && $user->hasAccess('olabs.oims.record_update')) {
            return true;
        }

        //IF entry is rejected by HO Accountant and user have permission for approval
        if ($this->isStatusHORejected() && $user->hasAccess('olabs.oims.record_approval') && $user->hasAccess('olabs.oims.record_update')) {
            return true;
        }


        if ($user->isAdmin() && ($this->isStatusRejected() || $this->isStatusHORejected())) {
            return true;
        }

        //In any case Admin should be able to update it
        if ($user->isAdmin()) {
            return true;
        }

        return FALSE;
    }

    /**
     * OBSOLETE 12.11.2016 
     * 
     * PaymentMethodOptions
     * 
     * @param type $activeOnly
     * @return type
     */
    public function getPaymentMethodOptions($activeOnly = false) {

        $options = [
            0 => Lang::get("olabs.oims::lang.settings.not_paid"),
            1 => Lang::get("olabs.oims::lang.settings.cash"),
            2 => Lang::get("olabs.oims::lang.settings.bank_transfer"),
            3 => Lang::get("olabs.oims::lang.settings.cheque"),
            4 => Lang::get("olabs.oims::lang.settings.demand_draft"),
        ];



        return $options;
    }

    public function getPaymentReceivedFromOptions($activeOnly = false) {

        $options = [
            'payment_ho' => Lang::get("olabs.oims::lang.settings.payment_ho"),
            'payment_client' => Lang::get("olabs.oims::lang.settings.payment_client"),
        ];



        return $options;
    }

    public function getLedgerTypesTypeOptions($activeOnly = false) {

        $options = [
            self::LEDGER_TYPE_PAYMENT => Lang::get("olabs.oims::lang.settings.payment"),
            self::LEDGER_TYPE_REVENUE => Lang::get("olabs.oims::lang.settings.revenue"),
        ];

        return $options;
    }
    
    public function getLedgerTypeRevenuOptions() {
        $list = [];
        $list = LedgerType::where('status', self::STATUS_ACTIVE)->where('type', self::LEDGER_TYPE_REVENUE)->get()->lists('name', 'slug');

        return $list;
    }
    
    public function getLedgerTypePaymentOptions() {
        $list = [];
        $list = LedgerType::where('status', self::STATUS_ACTIVE)->where('type', self::LEDGER_TYPE_PAYMENT)->get()->lists('name', 'slug');

        return $list;
    }

    /**
     * To show status history or the object
     * 
     */
    public function getStatusHistory() {


        $list = StatusHistory::where('entity_id', $this->id)
                ->where('entity_type', $this->getEntityType())
                ->orderBy('id', 'desc')
                ->get();
//        dd($list->count());
        return $list;
    }

    public function getStatusNameAttribute($value) {
        $name = 'New';

        if (isset($this->attributes['status']) && $this->attributes['status']) {
            $name = $this->objectstatus->name;
        }
        return $name;
    }

    public function getPrintStyleOptions() {
        $options = [];
        $options['40'] = '40 per sheet (a4) (1.799" x 1.003")';
        $options['30'] = '30 per sheet (2.625" x 1")';
        $options['24'] = '24 per sheet (a4) (2.48" x 1.334")';
        $options['20'] = '20 per sheet (4" x 1")';
        $options['18'] = '18 per sheet (a4) (2.5" x 1.835")';
        $options['14'] = '14 per sheet (4" x 1.33")';
        $options['12'] = '12 per sheet (a4) (2.5" x 2.834")';
        $options['10'] = '10 per sheet (4" x 2")';


//                <select name="style" class="form-control tip" id="style" required="required" tabindex="-1" title="" style="display: none;" data-original-title="Style" data-bv-field="style">
//<option value="">Select Style</option>
//<option value="40" selected="selected">40 per sheet (a4) (1.799" x 1.003")</option>
//<option value="30">30 per sheet (2.625" x 1")</option>
//<option value="24">24 per sheet (a4) (2.48" x 1.334")</option>
//<option value="20">20 per sheet (4" x 1")</option>
//<option value="18">18 per sheet (a4) (2.5" x 1.835")</option>
//<option value="14">14 per sheet (4" x 1.33")</option>
//<option value="12">12 per sheet (a4) (2.5" x 2.834")</option>
//<option value="10">10 per sheet (4" x 2")</option>
//<option value="50">Continuous feed</option>
//</select>
        return $options;
    }

}
