<?php

namespace Olabs\Oims\Models;

use Model;
use DB;
use Mail;
use App;
use Lang;
use BackendAuth;

/**
 * Model
 */
class PCAttendance extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    const CNAME = 'pc_attendances';

    public function getEntityType() {
        return self::CNAME;
    }

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_pc_attendances';

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        "objectstatus",
        "note",
        "tracking_number",
        // User - Rainlab User if exist
        "user",
        // Delivery address
        "ds_first_name",
        "ds_last_name",
        "ds_address",
        "ds_address_2",
        "ds_postcode",
        "ds_city",
        "ds_county",
        "ds_country",
        // Invoice address
        "is_first_name",
        "is_last_name",
        "is_address",
        "is_address_2",
        "is_postcode",
        "is_city",
        "is_county",
        "is_country",
        // Contact
        "contact_email",
        "contact_phone",
        // Carrier
        "carrier",
        // Price
        "total_price_without_tax",
        "total_tax",
        "total_price",
        "coupon",
        "total_global_discount",
        "shipping_price_without_tax",
        "shipping_tax",
        "shipping_price",
        // Payment methods                            
        "payment_method", // obsolete
    ];
    protected $jsonable = [
        // Products
        // propably save ID + qty + price, all other can be from producst DB
        'products_json',
        'paid_detail'
    ];
    protected $dates = ['paid_date'];

    /**
     * @var array Relations
     */
//    public $hasOne = [];
    public $hasMany = [
        'products' => [
            'Olabs\Oims\Models\PCAttendanceDetail', 
            'key' => 'attendance_id'
        ],  
    ];
    public $belongsTo = [
        'objectstatus' => [
            'Olabs\Oims\Models\Status',
            'key' => 'status'
        ],
        'project' => [
            'Olabs\Oims\Models\Project',
            'key' => 'project_id'
        ],
        'paymentGateway' => [
            'Olabs\Oims\Models\PaymentGateway',
            'key' => 'payment_gateway_id'
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'invoice' => 'System\Models\File',
    ];
    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];

    public function getSetupCodeAttribute() {
        return strtoupper(str_random(8));
    }

    public function getProductOptions() {
        return Product::get()->lists("title", "id");
    }

    /**
     * Get Payment Method Label
     * 
     * @return string
     */
    public function getPaymentMethodLabel() {
//        $arr = $this->getPaymentMethodOptions();
//        
//        if (array_key_exists($this->payment_method, $arr)) {
//            return $arr[$this->payment_method];
//        }
//        else {
//            return "";
//        }
        // 12.11.2016 new version
        if ($this->paymentGateway) {
            return $this->paymentGateway->gateway_title;
        } else {
            return "";
        }
    }

    public function beforeCreate() {

        if ($this->status == '') {
            $this->status = Status::STATUS_NEW;
        }

        $user = BackendAuth::getUser();
        if ($this->created_by == '') {
            $this->created_by = $user->id;
        }
        if ($this->updated_by == '') {
            $this->updated_by = $user->id;
        }
    }

}
