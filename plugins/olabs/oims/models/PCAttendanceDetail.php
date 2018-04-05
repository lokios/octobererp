<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class PCAttendanceDetail extends Model {

    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */

    public $timestamps = false;
    
    const ATTENDANCE_WORKING_HOUR = 8; //default working hours for attendance
    
    /*
     * Validation
     */
    public $rules = [
    ];

    protected $guarded = ['*'];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_pc_attendance_details';
    
    
    public $belongsTo = [
        'pcattendance' => [
            'Olabs\Oims\Models\PCAttendance',
            'key' => 'attendance_id'
        ],
//        'unit_code' => [
//            'Olabs\Oims\Models\Unit',
//            'key' => 'unit'
//        ],
        'employee_type_code' => [
            'Olabs\Oims\Models\EmployeeType',
            'key' => 'employee_type',
        ],
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        "employee_type_code",
        "daily_wages",
        "quantity",
        "total_price",
        "working_hour",
        "overtime",
        "total_working_hour",
        "total_wages",
        ];
    
//    public function beforeCreate() {
//
//        parent::beforeCreate();
//        $this->calculateWages();
////        if ($this->status == '') {
////            $this->status = Status::STATUS_NEW;
////        }
////        if ($this->payment_status == '') {
////            $this->payment_status = Status::PAYMENT_STATUS_PENDING;
////        }
//    }
    
    
    public function calculateWages() {

            //calculation of wages for offrole employees
            $working_hour = $this->working_hour > 0 ? $this->working_hour : self::ATTENDANCE_WORKING_HOUR;
            $this->working_hour =  $working_hour;
            
            $overtime = $this->overtime > 0 ? $this->overtime : 0;
            $this->overtime = $overtime;
            
            //get total working hours
            $total_working_hour = $working_hour + $overtime;
            
            $this->total_working_hour = $total_working_hour;

            //calculate wages on each updates as per current wages set
            $daily_wages = $this->daily_wages > 0 ? $this->daily_wages : 0;
            $this->daily_wages = $daily_wages;

            //full wages
            if ($total_working_hour == $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $this->total_wages = $daily_wages;
            }

            //full wages + over time wages
            if ($total_working_hour > $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $total_wages = $daily_wages;
                $hourly_wages = $total_wages / $working_hour;//self::ATTENDANCE_WORKING_HOUR;

                $this->total_wages = $total_wages + ($this->overtime * $hourly_wages);
            }

            //half wages
            if ($total_working_hour < $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $total_wages = $daily_wages;
                $hourly_wages = $total_wages / $working_hour;//self::ATTENDANCE_WORKING_HOUR;

                $this->total_wages = $total_working_hour * $hourly_wages;
            }
            
            $this->quantity = $this->quantity > 0 ? $this->quantity : 0;
            $this->total_price = $this->quantity * $this->total_wages;
    }
    
    
    
    
    public function filterFields($fields, $context = null) {
//        if ($this->product) {
//        dd('Hi');
//        $unitPriceValue = isset($fields->unit_price->value) ? $fields->unit_price->value : 0;
////            $retailPrice = isset($this->product->retail_price_with_tax) ? $this->product->retail_price_with_tax : 0;
////            $unitPriceValue = $fields->unit_price->value;
////        if (isset($fields->total_price->value)) {
        $quantity = isset($fields->quantity->value) ? $fields->quantity->value : 0;
//        $fields->total_price->value = $unitPriceValue * $quantity;
//        }
//        }
        
        //calculation of wages for offrole employees
            $working_hour = isset($fields->working_hour->value) ? $fields->working_hour->value : self::ATTENDANCE_WORKING_HOUR;
            $fields->working_hour->value =  $working_hour;
            
            $overtime = isset($fields->overtime->value) ? $fields->overtime->value : 0;
            $fields->overtime->value = $overtime;
            
            //get total working hours
            $total_working_hour = $working_hour + $overtime;
            
//            $this->total_working_hour->value = $total_working_hour;

            //calculate wages on each updates as per current wages set
            $daily_wages = isset($fields->daily_wages->value) ? $fields->daily_wages->value : 0;
            $fields->daily_wages->value = $daily_wages;

            //full wages
            $total_wages = 0;
            if ($total_working_hour == $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $total_wages = $daily_wages;
            }

            //full wages + over time wages
            if ($total_working_hour > $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $total_wages = $daily_wages;
                $hourly_wages = $total_wages / $working_hour;//self::ATTENDANCE_WORKING_HOUR;

                $total_wages = $total_wages + ($overtime * $hourly_wages);
            }

            //half wages
            if ($total_working_hour < $working_hour) {//self::ATTENDANCE_WORKING_HOUR) {
                $total_wages = $daily_wages;
                $hourly_wages = $total_wages / $working_hour;//self::ATTENDANCE_WORKING_HOUR;

                $total_wages = $total_working_hour * $hourly_wages;
            }
            
            $fields->total_price->value = $quantity * $total_wages;
        
    }

}
