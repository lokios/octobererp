<?php namespace Olabs\Oims\Models;

use Model;
use DB;
use Mail;
use App;
use Lang;
use BackendAuth;
use Log;

/**
 * Voucher Model
 */
class Voucher extends BaseModel
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_vouchers';

    const CNAME = 'vouchers';
    
    public $execute_validation = True;
    
    
    public function getEntityType()
    {
        return self::CNAME;
    }
    
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
        "user_id",
        
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
        "payment_method",  // obsolete
        "execute_validation",
    ];
    
    public $rules = [
//        'title' => 'required|between:2,255',
        'user_id' => 'numeric|required',
        'reference_number' => 'numeric|required|between:1,255|unique:olabs_oims_vouchers',
//        'reference_number' => [
//            'required',
////            'alpha_dash',
//            'between:1,255',
//            'unique:olabs_oims_vouchers',
//        ],        
//        'ean_13'   => 'numeric|ean13',
////        'default_category' => 'required',
//        'retail_price_with_tax' => 'numeric|required',
        
    ];  
            
    protected $jsonable = [
        // Products
        // propably save ID + qty + price, all other can be from producst DB
//        'products_json', 
        'paid_detail'
        ];
    
    protected $dates = ['paid_date'];
    
    
    
    
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'products' => [
            'Olabs\Oims\Models\VoucherProduct', 
            'key' => 'voucher_id'
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
       
        'supplier' => [
            'Backend\Models\User', 
            'key' => 'user_id'
        ],   
        'ledger_type' => [
            'Olabs\Oims\Models\LedgerType',
            'key' => 'payment_type'
        ],
        
    ];
//    public $belongsToMany = [];
//    public $morphTo = [];
//    public $morphOne = [];
//    public $morphMany = [];
    public $attachOne = [
        'invoice' => 'System\Models\File',
    ];
    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];
    
    
    public function getSetupCodeAttribute()
    {
        return strtoupper(str_random(8));
    }
    
    public function getProductOptions()
    {
        return Product::get()->lists("title","id");
    }
    
    public function getUserOptions()
    {
        if (class_exists("\RainLab\User\Models\User")) {
            $usersList = \RainLab\User\Models\User::select(
                    DB::raw("CONCAT_WS(' ', id, '|', name, surname) AS full_name, id")
                    )->lists('full_name', 'id');
            return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $usersList;
        }
        else {
            return [
                null => "Firstly install Rainlab User plugin"
            ];
        }
    }  

    /**
     * OBSOLETE 12.11.2016 
     * 
     * PaymentMethodOptions
     * 
     * @param type $activeOnly
     * @return type
     */
//    public function getPaymentMethodOptions($activeOnly = false) {
//        
//        $options = [
//            0 => Lang::get("olabs.oims::lang.settings.not_paid"),
//            1 => Lang::get("olabs.oims::lang.settings.cash_on_delivery"),
//            2 => Lang::get("olabs.oims::lang.settings.bank_transfer"),
////            3 => Lang::get("olabs.oims::lang.settings.paypal"),
////            4 => Lang::get("olabs.oims::lang.settings.stripe"),
//            3 => Lang::get("olabs.oims::lang.settings.cheque"),
//            4 => Lang::get("olabs.oims::lang.settings.demand_draft"),
//
//        ];        
//      
//
//      
//        return $options;
//    }
    
    
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
        }
        else {
            return "";
        }
    }
    
    
    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }  
    


    /*
     * After fetch data from DB
     * 
     */
    public $extend_products_json = array();
    public function afterFetch() {
        // add product relation by products_json into extend_products_json
        $this->extend_products_json = array();
        if($this->products_json){
            foreach ($this->products_json as $key => $producJson) {
                $producJson["product"] = \Olabs\Oims\Models\Product::find($producJson["product_id"]);
                $this->extend_products_json += [$key => $producJson];
            }
        }
    }
    
   

    /**
     * Event: before Update
     * 
     */
    public function beforeUpdate() {
        
        $this->setNarration();
        $this->uniqueReferenceNumberCheck();
        
        $user = BackendAuth::getUser();
        if($this->updated_by == ''){
            $this->updated_by = $user->id;
        }
        
//        $oldModel = self::find($this->id);
//
//        // check voucher status change
//        if (isset($oldModel)) {
//            if (($oldModel->objectstatus == null) && ($this->objectstatus != null)) {
//                $this->onVoucherStatusChange($this->objectstatus, null);
//            }
//            else if (($oldModel->objectstatus != null) && ($this->objectstatus != null)) {
//                if ($oldModel->objectstatus->id != $this->objectstatus->id) {
//                    $this->onVoucherStatusChange($this->objectstatus, $oldModel->objectstatus);
//                }
//            }
//        }
    }
    
    public function beforeCreate() {
        $this->setNarration();
        $this->uniqueReferenceNumberCheck();
        if($this->status == ''){
            $this->status = Status::STATUS_NEW;
        }
        
        $user = BackendAuth::getUser();
        if($this->created_by == ''){
            $this->created_by = $user->id;
        }
        if($this->updated_by == ''){
            $this->updated_by = $user->id;
        }
    }
    
    private function setNarration(){
        
        $narration = $this->ledger_type->name;
        
        $suppliers = [];
        $employees = [];
        $material_receipts = [];
        
        foreach($this->products as $product){
            if($product->purchase_id){
                $material_receipts[] = $product->purchase->reference_number;
            }
            if($product->supplier_id){
                $suppliers[] = $product->supplier->full_name;
            }
            if($product->employee_id){
                $employees[] = $product->employee->full_name;
            }
        }
        
        if(count($material_receipts)){
            $narration .=  " For " . implode(", ", $material_receipts);
        }
        
        if(count($suppliers)){
            $narration .=  " To " . implode(", ", $suppliers);
        }
        
        if(count($employees)){
            $narration .=  " To " . implode(", ", $employees);
        }
        
        $this->narration = $narration;
        
        
    }

    



    public function uniqueReferenceNumberCheck(){
//        return true; // Not required to check, running default
        
        //If dont want to execute validation : use in Entity Relation data sync from mobile
        if(!$this->execute_validation){
            return;
        }
        
        //Check MR Number uniqueness through out project
        if($this->id){
            $invalid = Voucher::where('reference_number', $this->reference_number)
//                               ->where('project_id', $this->project_id)
                               ->where('id', '<>', $this->id)->count();
        }else{
            $invalid = Voucher::where('reference_number', $this->reference_number)
//                               ->where('project_id', $this->project_id)
                               ->count();
        }
        
        if ($invalid) {
            throw new \ValidationException(['reference_number' => 'M.R. Number must be unique for a project.']);
        }else{
            return true;
        }
    }
    
    
    public function filterFields($fields, $context = null)
    {
        if ($this->quote) {
            $fields->user_id->value = $this->quote->user_id;
        }
        
        if($fields->payment_method && isset($fields->{'paid_detail[payment_from]'})){
//            dd($fields->{'paid_detail[payment_from]'});
            $fields->{'paid_detail[payment_from]'}->hidden = true;
            $fields->{'paid_detail[payment_to]'}->hidden = true;
            $fields->{'paid_detail[transaction_id]'}->hidden = true;
            
            $fields->{'paid_detail[cheque_number]'}->hidden = true;
            $fields->{'paid_detail[cheque_date]'}->hidden = true;
            $fields->{'paid_detail[cheque_account]'}->hidden = true;
            
            $fields->{'paid_detail[dd_number]'}->hidden = true;
            $fields->{'paid_detail[issuing_bank]'}->hidden = true;
            $fields->{'paid_detail[issue_date]'}->hidden = true;
            
            if($fields->payment_method->value == PaymentReceivable::PAYMENT_METHOD_CHEQUE){
                $fields->{'paid_detail[cheque_number]'}->hidden = false;
                $fields->{'paid_detail[cheque_date]'}->hidden = false;
                $fields->{'paid_detail[cheque_account]'}->hidden = false;
            }else if($fields->payment_method->value == PaymentReceivable::PAYMENT_METHOD_BANK_TRANSFER){
                $fields->{'paid_detail[payment_from]'}->hidden = false;
                $fields->{'paid_detail[payment_to]'}->hidden = false;
                $fields->{'paid_detail[transaction_id]'}->hidden = false;
            }else if($fields->payment_method->value == PaymentReceivable::PAYMENT_METHOD_DEMAND_DRAFT){
                $fields->{'paid_detail[dd_number]'}->hidden = false;
                $fields->{'paid_detail[issuing_bank]'}->hidden = false;
                $fields->{'paid_detail[issue_date]'}->hidden = false;
            }
                
        }
        
    }

}