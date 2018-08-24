<?php

namespace Olabs\Oims\Models;

use Model;
use Carbon\Carbon;

//use BackendAuth;
/**
 * Model
 */
class Attendance extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at', 'check_in', 'check_out'];
    public $attendance_date;
    public $onrole_employee_id;
    public $execute_validation = True;

    const CNAME = 'attendances';
    const EMPLOYEE_TYPE_OFFROLE = 'offrole';
    const EMPLOYEE_TYPE_ONROLE = 'onrole';

    public $employee_onrole;

    public function getEntityType() {
        return self::CNAME;
    }

    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];

    /*
     * Validation
     */
    public $rules = [
        'employee_id' => 'required',
//        'daily_wages' => 'required',
//        'check_id' => 'required',
//        'check_out' => 'required',
//        'project_id' => 'required',
//        'supplier_id' => 'required',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'total_working_hour',
        'employee_id',
        'employee_type',
        'check_in',
        'check_out',
        'execute_validation',
    ];
//    protected $dates = ['paid_date'];

    public $belongsTo = [
        'employee_offrole' => [
            'Olabs\Oims\Models\OffroleEmployee',
            'key' => 'employee_id',
            'scope' => 'matchProject'
        ],
//        'employee_onrole' => [
//            'Olabs\Oims\Models\Employee',
//            'key' => 'employee_id',
//        ],
        'project' => [
            'Olabs\Oims\Models\Project',
            'key' => 'project_id'
        ],
        'supplier' => [
            'Olabs\Oims\Models\Supplier',
            'key' => 'supplier_id'
        ],
        'objectstatus' => [
            'Olabs\Oims\Models\Status',
            'key' => 'status'
        ],
    ];
    public $hasMany = [
        'entity_relations' => [
            '\Olabs\Social\Models\EntityRelations',
            'key' => 'target_id',
            'conditions' => "target_type='" . \Olabs\Social\Models\EntityRelations::TARGET_TYPE_ATTENDANCE . "'",
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_attendances';

    public function filterFields($fields, $context = null) {
        if ($this->employee_offrole) {
//            $fields->employee_id->value = $this->employee_offrole->id;
            $fields->daily_wages->value = $this->employee_offrole->daily_wages;
            $fields->project_id->value = $this->employee_offrole->project_id;
            $fields->supplier_id->value = $this->employee_offrole->supplier_id;
            $fields->working_hour->value = $this->employee_offrole->working_hour > 0 ? $this->employee_offrole->working_hour : 8;
//            $fields->check_in->value = date('Y-m-d H:i:s');
        }
    }

    /*
     * After fetch data from DB
     * 
     */

    public function afterFetch() {

        $this->attendance_date = $this->check_in;
        if ($this->employee_type == self::EMPLOYEE_TYPE_ONROLE) {
            $this->employee_onrole = $this->employee_id;
            $this->employee_offrole = FALSE;
        }
    }

    public function getEmployeeName() {
        $name = "";
        if ($this->employee_type == self::EMPLOYEE_TYPE_OFFROLE) {
            $name = isset($this->employee_offrole->name) ? $this->employee_offrole->name : '';
        } else if ($this->employee_type == self::EMPLOYEE_TYPE_ONROLE) {

            $employee = $this->getOnRoleEmployee();

            $name = isset($employee) ? $employee->getFullNameAttribute() : '';
        }
        return $name;
    }

    public function getEmployeeType() {
        $name = "";
        if ($this->employee_type == self::EMPLOYEE_TYPE_OFFROLE) {
            $name = isset($this->employee_offrole->employee_type) ? $this->employee_offrole->employee_type : '';
        } else if ($this->employee_type == self::EMPLOYEE_TYPE_ONROLE) {

//            $employee = $this->getOnRoleEmployee();

            $name = 'OnRole';
        }
        return $name;
    }

    public function getEmployeeProjectName() {
        $name = "";
        if ($this->employee_type == self::EMPLOYEE_TYPE_OFFROLE) {
            $name = isset($report->project->name) ? $report->project->name : '';
        } else if ($this->employee_type == self::EMPLOYEE_TYPE_ONROLE) {

            $employee = $this->getOnRoleEmployee();

            $name = isset($employee->employee_project->name) ? $employee->employee_project->name : '';
        }
        return $name;
    }

    public function getOnRoleEmployee() {
        $model = Employee::where('id', $this->employee_onrole)->first();
        return $model;
    }

    public function beforeCreate() {

        parent::beforeCreate();
        $this->calculateWages();
        if ($this->status == '') {
            $this->status = Status::STATUS_NEW;
        }
        if ($this->payment_status == '') {
            $this->payment_status = Status::PAYMENT_STATUS_PENDING;
        }
    }

    public function beforeUpdate() {

        $this->calculateWages();
        parent::beforeUpdate();
    }

    public function calculateWages() {

        if ($this->employee_offrole) {
            //calculation of wages for offrole employees
            $working_hour = $this->employee_offrole->working_hour > 0 ? $this->employee_offrole->working_hour : self::ATTENDANCE_WORKING_HOUR;

            $lunch_hour = $this->employee_offrole->lunch_hour > 0 ? $this->employee_offrole->lunch_hour : self::ATTENDANCE_LUNCH_HOUR;

            $this->working_hour = $working_hour;
            //get total working hours
            $total_working_hour = ceil((strtotime($this->check_out) - strtotime($this->check_in)) / 3600);

            //        if($total_working_hour >= )
            $this->total_working_hour = $total_working_hour - $lunch_hour; //deduct lunch hour from total working hour
            //calculate total over time if any
            $overtime = $this->total_working_hour - $working_hour; //self::ATTENDANCE_WORKING_HOUR;

            $this->overtime = $overtime > 0 ? $overtime : 0;

            //calculate wages on each updates as per current wages set
            $daily_wages = 0; // $this->employee_offrole->daily_wages;

            if (!$this->daily_wages) {
                $daily_wages = $this->employee_offrole->daily_wages > 0 ? $this->employee_offrole->daily_wages : 0;
                //if isset monthly wages then get daily wages from that else use daily wages
                if ($this->employee_offrole->monthly_wages > 0) {

                    $days_in_month = Carbon::createFromTimestamp(strtotime($this->check_in))->daysInMonth;
//                    dd($days_in_month);
                    $daily_wages = $this->employee_offrole->monthly_wages / $days_in_month;
                }
            } else {
                $daily_wages = $this->daily_wages;
            }


//            if (!$this->daily_wages) {
            $this->daily_wages = $daily_wages;
//            }
            //full wages
            if ($total_working_hour == $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $this->total_wages = $daily_wages;
            }

            //full wages + over time wages
            if ($total_working_hour > $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $total_wages = $daily_wages;
                $hourly_wages = $total_wages / $working_hour; //self::ATTENDANCE_WORKING_HOUR;

                $this->total_wages = $total_wages + ($this->overtime * $hourly_wages);
            }

            //half wages
            if ($total_working_hour < $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $total_wages = $daily_wages;
                $hourly_wages = $total_wages / $working_hour; //self::ATTENDANCE_WORKING_HOUR;

                $this->total_wages = $total_working_hour * $hourly_wages;
            }


//            if (!$this->employee_id) {
//                $this->employee_id = $this->employee_offrole->id;
//            }
            if (!$this->project_id) {
                $this->project_id = $this->employee_offrole->project_id;
            }
            if (!$this->supplier_id) {
                $this->supplier_id = $this->employee_offrole->supplier_id;
            }

            if (!$this->employee_type) {
                $this->employee_type = self::EMPLOYEE_TYPE_OFFROLE;
            }
        }
        if ($this->employee_onrole) {
            //calculation of working hours for on role employees
            $working_hour = self::ATTENDANCE_WORKING_HOUR_ONROLE;

            $this->working_hour = $working_hour;
            //get total working hours
            $total_working_hour = ceil((strtotime($this->check_out) - strtotime($this->check_in)) / 3600);

            //        if($total_working_hour >= )
            $this->total_working_hour = $total_working_hour;

            //calculate total over time if any
            $overtime = $this->total_working_hour - $working_hour; //self::ATTENDANCE_WORKING_HOUR;

            $this->overtime = $overtime > 0 ? $overtime : 0;

            if (!$this->employee_type) {
                $this->employee_type = self::EMPLOYEE_TYPE_ONROLE;
            }

            if (!$this->employee_id) {
                $this->employee_id = $this->employee_onrole;
            }

            if (!$this->project_id) {
                $employee = $this->getOnRoleEmployee();

                $this->project_id = $employee ? $employee->employee_project_id : '';
            }
        }
    }

    //validatoin for checking same employee is not adding twice
    public function beforeValidate() {

        //If dont want to execute validation : use in Entity Relation data sync from mobile
        if (!$this->execute_validation) {
            return;
        }

        if ($this->employee_onrole && $this->employee_offrole) {
            throw new \ValidationException(['employee_id' => 'Select either onrole or offrole employee.']);
        }

        //if on role employee selected then over right employee id
        if ($this->employee_onrole) {
            $this->employee_id = $this->employee_onrole;
        }

        //check for check IN time should be less then check Out time and minimum time difference is 1 hours
        $check_in = strtotime($this->check_in);
        $check_out = strtotime($this->check_out);

        $time_difference = $check_out - $check_in;
        if ($time_difference <= 0) {
            throw new \ValidationException(['check_in' => 'CheckOut time should be greater than CheckIn time.']);
        }
        //if time difference is less then one hour then throught exception
        $time_difference_hours = $time_difference / 3600;
        if ($time_difference_hours <= self::ATTENDANCE_GRACE_TIME) {
            throw new \ValidationException(['check_out' => 'CheckOut and CheckIn time diffenece should be ' . self::ATTENDANCE_GRACE_TIME . ' hours minimum']);
        }

        //check for already exist
        $fromDate = date('Y-m-d' . ' 00:00:00', strtotime($this->check_in));
        $toDate = date('Y-m-d' . ' 23:59:59', strtotime($this->check_in));

        if ($this->id) {
            $invalid = Attendance::where('employee_id', $this->employee_id)
//                ->where('check_in','>=', $this->check_in)
//                ->where('check_out','<=', $this->check_out)
                            ->where('id', '<>', $this->id)
                            ->whereBetween('check_in', [$fromDate, $toDate])
                            ->count() > 0;
        } else {
            $invalid = Attendance::where('employee_id', $this->employee_id)
                            ->whereBetween('check_in', [$fromDate, $toDate])
                            ->count() > 0;
        }

//        dd($this->check_in);
//        $invalid = $this->newQuery()->where(....)->count() > 0;
        if ($invalid) {
            throw new \ValidationException(['employee_id' => 'Employee attendace already created.']);
        }
    }

}
