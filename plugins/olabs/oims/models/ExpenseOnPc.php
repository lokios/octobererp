<?php

namespace Olabs\Oims\Models;

use Model;
use DB;
use Mail;
use App;
use Lang;
use BackendAuth;

/**
 * ExpenseOnPc Model
 */
class ExpenseOnPc extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_expense_on_pcs';

    const CNAME = 'expenseonpcs';

    public function getEntityType() {
        return self::CNAME;
    }

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /*
     * Validation
     */
    public $rules = [
    ];

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
            'Olabs\Oims\Models\ExpenseOnPcProduct',
            'key' => 'expense_on_pc_id'
        ],
    ];
    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
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
        'quote' => [
            'Olabs\Oims\Models\Quote',
            'key' => 'quote_id',
            'scope' => 'matchExpenseOnPc'
        ],
    ];
    public $attachOne = [
        'invoice' => 'System\Models\File',
    ];

//    public $attachMany = [];


    public function getSetupCodeAttribute() {
        return strtoupper(str_random(8));
    }

    /**
     * Get Payment Method Label
     * 
     * @return string
     */
    public function getPaymentMethodLabel() {
        // 12.11.2016 new version
        if ($this->paymentGateway) {
            return $this->paymentGateway->gateway_title;
        } else {
            return "";
        }
    }

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller) {
        $params = [
            'id' => $this->id,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
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
    
//    public function filterFields($fields, $context = null)
//    {
//
//        if ($this->quote_id) {
////            
////            $fields->unit_price->value = $fields->unit_price->value > 0 ?$fields->unit_price->value : $this->product->retail_price_with_tax;
////            $fields->total_price->value = $fields->unit_price->value * $fields->quantity->value ;
//        }
//    }
    
//    public function scopeMatchProject($query, $model) {
//
//        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
//
//        if (!$projectId) {
//            //check with session value
//            $projectId = \Session::get('expenseOnPc_ProjectId', $projectId);
//        }
//        //if still projectId is null then check with assign projects
//        if (!$projectId) {
//            $projects = $this->getProjectOptions();
//            $projectId = array_keys($projects);
//        }
//
//
////        if(!is_array($projects))
////        dd($projectId);
//        return is_array($projectId) ? $query->whereIn('project_id', $projectId) : $query->where('project_id', $projectId); // ->orderBy('name', 'desc')
//    }

}
