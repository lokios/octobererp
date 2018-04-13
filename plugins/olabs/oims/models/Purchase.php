<?php namespace Olabs\Oims\Models;

use Model;
use DB;
use Mail;
use App;
use Lang;
use BackendAuth;
use Log;

/**
 * Purchase Model
 */
class Purchase extends BaseModel
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_purchases';

    const CNAME = 'purchases';
    
    
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
    ];
    
    public $rules = [
//        'title' => 'required|between:2,255',
        'reference_number' => 'numeric|required|between:1,255|unique:olabs_oims_purchases',
//        'reference_number' => [
//            'required',
////            'alpha_dash',
//            'between:1,255',
//            'unique:olabs_oims_purchases',
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
            'Olabs\Oims\Models\PurchaseProduct', 
            'key' => 'purchase_id'
        ],  
    ];
    public $belongsTo = [
        'objectstatus' => [
            'Olabs\Oims\Models\Status', 
            'key' => 'status'
        ],           
        'carrier' => [
            'Olabs\Oims\Models\Carrier', 
            'key' => 'carrier_id'
        ], 
        'project' => [
            'Olabs\Oims\Models\Project', 
            'key' => 'project_id'
        ], 
        'coupon' => [
            'Olabs\Oims\Models\Coupon', 
            'key' => 'coupon_id'
        ],        
        'paymentGateway' => [
            'Olabs\Oims\Models\PaymentGateway', 
            'key' => 'payment_gateway_id'
        ],    
        'supplier' => [
            'Backend\Models\User', 
            'key' => 'user_id'
        ],   
        'quote' => [
            'Olabs\Oims\Models\Quote',
            'key' => 'quote_id',
            'scope' => 'matchPurchase'
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
     * Complete create purchase from basket
     * - fill all
     * - create invoice
     * - 
     * 
     */
//    public function createFromBasket($basket) {
//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//        
//        // User - Rainlab User if exist
//        if (class_exists("\RainLab\User\Models\User")) {
//            $user = \RainLab\User\Facades\Auth::getUser();
//            if (isset($user)) {
//                $this->user_id = \RainLab\User\Facades\Auth::getUser()->id;
//            }
//        }
//        
//        // Delivery address
//        $this->ds_first_name = $basket["ds_first_name"];
//        $this->ds_last_name = $basket["ds_last_name"];
//        $this->ds_address = $basket["ds_address"];
//        $this->ds_address_2 = $basket["ds_address_2"];
//        $this->ds_postcode = $basket["ds_postcode"];
//        $this->ds_city = $basket["ds_city"];
//        $this->ds_county = $basket["ds_county"];
//        $this->ds_country = $basket["ds_country"];
//
//        // Invoice address
//        $this->is_first_name = $basket["is_first_name"];
//        $this->is_last_name = $basket["is_last_name"];
//        $this->is_address = $basket["is_address"];
//        $this->is_address_2 = $basket["is_address_2"];
//        $this->is_postcode = $basket["is_postcode"];
//        $this->is_city = $basket["is_city"];
//        $this->is_county = $basket["is_county"];
//        $this->is_country = $basket["is_country"];
//        
//        // Carrier
//        $this->carrier = Carrier::find($basket["shipping_id"]);
//        
//        // Price
//        $this->total_price_without_tax = $basket["total_price_without_tax"];
//        $this->total_tax = $basket["total_tax"];
//        $this->total_price = $basket["total_price"];
//        $this->total_global_discount = $basket["total_global_discount"];
//        
//        $this->shipping_price_without_tax = $basket["shipping_price_without_tax"];
//        $this->shipping_tax = $basket["shipping_tax"];
//        $this->shipping_price = $basket["shipping_price"];
//        
//        // coupon
//        if ($basket["coupon_model"] != null) {
//            $this->coupon = $basket["coupon_model"];
//            $wCoupon = Coupon::find($this->coupon->id);
//            $wCoupon->used_count++;
//            $wCoupon->save();
//        }
//        
//        
//        // Contact
//        $this->contact_email = $basket["contact_email"];
//        $this->contact_phone = $basket["contact_phone"];
//        $this->note = $basket["note"];
//
//        // Payment method + PurchaseStatus
//        //$this->payment_method = $basket["payment_method_id"]; // obsolete
//        $paymentGateway = PaymentGateway::find($basket["payment_method_id"]);
//        $this->paymentGateway = $paymentGateway;
//        if (($paymentGateway) && ($paymentGateway->purchaseStatusBefore)) {
//            $this->objectstatus = $paymentGateway->purchaseStatusBefore;
//        }
//        
//        // Products
//        $products_json = [];
//        foreach ($basket["products"] as $id => $productJson) {
//            
//            $qty = $productJson["basket_quantity"];
//            $product = Product::find($productJson["product_id"]);
//            
//            if ($oimsSetting->extended_inventory_management) {
//                // extended_inventory_management - after change purchase status
//            }
//            else {
//                // check and remove qty form stock
//                $qty = $product->purchaseProduct($qty, true);
//                // i call this immediately get basket and this method check stock availability
//            }
//            
//            // $basket["products"][$id]["product"]
//            $products_json[] = [
//                "product_id" => $productJson["product_id"],
//                "quantity" => $qty,
//                "total_price_without_tax" => $productJson["total_price_without_tax"],
//                "total_tax" => $productJson["total_tax"],
//                "total_price" => $productJson["total_price"],
//                "options_data" => $productJson["options_data"],
//                "options_text" => $productJson["options_text"],
//            ];
//        }
//        $this->products_json = $products_json;
//
//        // ---------------------------------------------------------------------
//        // Try to update rainlab user if exist
//        // ---------------------------------------------------------------------
//        try {
//            // User - Rainlab User if exist
//            if (class_exists("\RainLab\User\Models\User")) {
//                $user = \RainLab\User\Facades\Auth::getUser();
//                if (isset($user)) {
//                    // Delivery address
//                    $user->oims_ds_first_name = $basket["ds_first_name"];
//                    $user->oims_ds_last_name = $basket["ds_last_name"];
//                    $user->oims_ds_address = $basket["ds_address"];
//                    $user->oims_ds_address_2 = $basket["ds_address_2"];
//                    $user->oims_ds_postcode = $basket["ds_postcode"];
//                    $user->oims_ds_city = $basket["ds_city"];
//                    $user->oims_ds_county = $basket["ds_county"];
//                    $user->oims_ds_country = $basket["ds_country"];
//
//                    // Invoice address
//                    $user->oims_is_first_name = $basket["is_first_name"];
//                    $user->oims_is_last_name = $basket["is_last_name"];
//                    $user->oims_is_address = $basket["is_address"];
//                    $user->oims_is_address_2 = $basket["is_address_2"];
//                    $user->oims_is_postcode = $basket["is_postcode"];
//                    $user->oims_is_city = $basket["is_city"];
//                    $user->oims_is_county = $basket["is_county"];
//                    $user->oims_is_country = $basket["is_country"];
//
//                    // Contact
//                    $user->oims_contact_email = $basket["contact_email"];
//                    $user->oims_contact_phone = $basket["contact_phone"];
//
//                    $user->forceSave();
//                }
//            }
//        } catch (Exception $ex) {
//            // do nothing - update user is not important
//            return;
//        }
//        // ---------------------------------------------------------------------
//
//        
//    }
    
    /**
     * Event: after create
     * 
     */
  // public function afterCreate() {
  //      $this->genereateInvoice();
  //  }
    
    
    //public function afterUpdate() {
    //    $this->genereateInvoice();
    //}
    
    
    
    public function genereateInvoice($download = false){
        
        $this->onPurchaseStatusChange($this->objectstatus, null);
        
        // Create invoice html
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $html = "<html><head><style>".$oimsSetting->material_receipt_template_style."</style></head><body>".$oimsSetting->material_receipt_template_content."</body></html>";
        
        $html =  str_replace("{{m_r_number}}", $this->reference_number, $html);
        $html =  str_replace("{{context_date}}", $this->context_date, $html);

        if($this->user_id){
            $supplier = \Backend\Models\User::find($this->user_id);
            $supplierName = $supplier ? $supplier->getFullNameAttribute() : "";
        }else{
            $supplierName = "";
        }
        

        $html =  str_replace("{{supplier}}", $supplierName, $html);

        $html =  str_replace("{{bill_number}}", $this->bill_number, $html);
        $html =  str_replace("{{bill_date}}", $this->bill_date, $html);
        $html =  str_replace("{{thru_vehicle_number}}", $this->thru_vehicle_number, $html);
        $html =  str_replace("{{arrived_on_date}}", $this->arrived_on_date, $html);
        $html =  str_replace("{{driver_name}}", $this->driver_name, $html);        
        $html =  str_replace("{{note}}", $this->note, $html);

        $html =  str_replace("{{total_price}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price), $html);

        // products + shipping
        $htmlProducts = "";
        $productTableRow = "";

        $products = (count($this->products)) ? $this->products : PurchaseProduct::getPurchaseProducts($this->id);
        $productsTemplate = $oimsSetting->get_string_between($html, '<tr id="products_row">', '</tr>');

        if(count($products)) {
            // id based product template set in HTML
            $isProductTemplateSet = ($productsTemplate != "") ? true : false;

            foreach ($products as $product) {

                $title = $product->product->title;
                $qty = $product->quantity;
                $productUnit = $product->unit;
                $productRate = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $totalPrice = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);

                $productFields = array(
                    '{{product_title}}' => $title,
                    '{{product_unit}}' => $productUnit,
                    '{{product_qty}}' => $qty,
                    '{{product_rate}}' => $productRate,
                    '{{product_total_price}}' => $totalPrice
                    );
                
                $productTableRow .= $isProductTemplateSet ? "<tr>".strtr($productsTemplate, $productFields)."</tr>" : "";

                $htmlProducts .= "<div>";
                $htmlProducts .= "<span class='product-title'>".$title." <small class='product-title-options'>".$title."</small></span>";
                $htmlProducts .= "<span class='product-quantity'>".$qty."</span>";
                $htmlProducts .= "<span class='product-price-without-tax'>".$oimsSetting->getPriceFormatted($product->total_price_without_tax)."</span>";
                $htmlProducts .= "<span class='product-tax'>".$oimsSetting->getPriceFormatted($product->total_tax)."</span>";
                $htmlProducts .= "<span class='product-price'>".$oimsSetting->getPriceFormatted($product->total_price)."</span>";
                $htmlProducts .= "</div>";
            }
        }
        
        /* Log::info('replace html start ');
        trace_log($html);
        trace_log($productTableRow); */

        $html = $oimsSetting->replace_string($html, '<tr id="products_row">', '</tr>', $productTableRow);
        //Log::info('html after replace ');
        //trace_log($html);

        $html =  str_replace("{{products}}", $htmlProducts, $html);

//        dd($html);
        // Generate invoice
        $fileName = 'invoice_' . $this->id . '_' . time();
        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
//        $invoiceTempFile = temp_path()."/invoice-".$this->id.".pdf";
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $pdf->save($invoiceTempFile);
        
//        // add into invoice
//        $invoiceFile = new \System\Models\File();
//        $invoiceFile->fromFile($invoiceTempFile);
//        $this->invoice = $invoiceFile;
//        $this->save();
        
        if (!$download) {
            // add into invoice
            $invoiceFile = new \System\Models\File();
            $invoiceFile->fromFile($invoiceTempFile);
            $this->invoice = $invoiceFile;
            $this->save();

            // clear temp
            unlink($invoiceTempFile);
        }
        return $fileName;
        
        
    }

        /**
     * Event: before Update
     * 
     */
    public function beforeUpdate() {

        $this->uniqueMRNumberCheck();
        $oldModel = self::find($this->id);

        // check purchase status change
        if (isset($oldModel)) {
            if (($oldModel->objectstatus == null) && ($this->objectstatus != null)) {
                $this->onPurchaseStatusChange($this->objectstatus, null);
            }
            else if (($oldModel->objectstatus != null) && ($this->objectstatus != null)) {
                if ($oldModel->objectstatus->id != $this->objectstatus->id) {
                    $this->onPurchaseStatusChange($this->objectstatus, $oldModel->objectstatus);
                }
            }
        }
    }
    
    public function beforeCreate() {
        $this->uniqueMRNumberCheck();
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

    /**
     * After purchase status change - send email
     * 
     * @param type $newPurchaseStatus
     * @param type $prevPurchaseStatus
     */
    private function onPurchaseStatusChange($newPurchaseStatus, $prevPurchaseStatus) {
        
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
        
        if (isset($newPurchaseStatus)) {
            // prepair data
            $data = [];
            $data["first_name"] = $this->is_first_name;
            $data["last_name"] = $this->is_last_name;
            $data["purchase_id"] = $this->id;
            $tracking_url = ($this->carrier) ? $this->carrier->tracking_url : "";
            $tracking_url = str_replace("@", $this->tracking_number , $tracking_url);
            $data["tracking_url"] = ($this->tracking_number != null && $this->tracking_number != "") ? $tracking_url : "";
            
            // send email
            if ($newPurchaseStatus->mail_template != null) {
                Mail::send($newPurchaseStatus->mail_template->code, $data, function($message) use ($oimsSetting, $newPurchaseStatus) {

                    $message->to($this->contact_email);
                    
                    if ($oimsSetting->copy_all_purchase_emails_to != "") {
                        $message->bcc($oimsSetting->copy_all_purchase_emails_to);
                    }
                    
                    // attach invoice?
                    if (($newPurchaseStatus->attach_invoice_pdf_to_email) && ($this->invoice != null)) {
                        $message->attach($this->invoice->getLocalPath(), ['as' => "invoice-".$this->id.".pdf"]);
                    }
                });                
            }

            // extended_inventory_management - after change purchase status
            if ($oimsSetting->extended_inventory_management) {
                
                // qty decrease
                if ($newPurchaseStatus->qty_decrease) {
                    foreach ($this->products_json as $key => $producJson) {
                        $product = \Olabs\Oims\Models\Product::find($producJson["product_id"]);
                        if ($product) {
                            $qty = $producJson["quantity"];
                            $product->purchaseProduct($qty, true);
                        }
                    }
                }
                
                // qty increase back
                if ($newPurchaseStatus->qty_increase_back) {
                    // !!! ONLY if have previous status with qty_decrease
                    if (($prevPurchaseStatus != null) && ($prevPurchaseStatus->qty_decrease)) {
                        foreach ($this->products_json as $key => $producJson) {
                            $product = \Olabs\Oims\Models\Product::find($producJson["product_id"]);
                            if ($product) {
                                $qty = $producJson["quantity"];
                                $product->returnProductBack($qty, true);
                            }
                        }
                    }
                }
            }

        }
        
    }
    
    /**
     * Find purchase for payment gateway or return null
     * 
     * @param type $id
     */
    public static function findPurchaseBySlugForPaymentGateway($id) {
        $purchase = self::find($id);
        
        // check if purchase have user => user have to be logged in
        if ($purchase->user_id) {
            $user = \RainLab\User\Facades\Auth::getUser();
            
            // check anonymous access
            if ($user == null) {
                return null;
            }
            
            // check another user
            if ($purchase->user_id != $user->id) {
                return null;
            }
        }
        
        // check disallowed purchase statuses
        if ($purchase->objectstatus) {
            if ($purchase->objectstatus->disallow_for_gateway) {
                return null;
            }
        }
        
        return $purchase;
        
    }
    

    public function uniqueMRNumberCheck(){
//        return true; // Not required to check, running default
        
        //Check MR Number uniqueness through out project
        if($this->id){
            $invalid = Purchase::where('reference_number', $this->reference_number)
//                               ->where('project_id', $this->project_id)
                               ->where('id', '<>', $this->id)->count();
        }else{
            $invalid = Purchase::where('reference_number', $this->reference_number)
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
    }

}