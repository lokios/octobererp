<?php namespace Olabs\Oims\Models;

use Model;
use DB;
use Mail;
use App;
use Lang;
use BackendAuth;

/**
 * Sales Model
 */
class Sales extends BaseModel
{

    use \October\Rain\Database\Traits\Validation;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_sales';

    const CNAME = 'sales';
    
    
    public function getEntityType()
    {
        return self::CNAME;
    }
    
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
        "payment_method",  // obsolete
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
    public $hasOne = [];
    public $hasMany = [
        'products' => [
            'Olabs\Oims\Models\SalesProduct', 
            'key' => 'sales_id'
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
//            1 => Lang::get("olabs.oims::lang.settings.cash_on_delivery"),
//            2 => Lang::get("olabs.oims::lang.settings.bank_transfer"),
//            3 => Lang::get("olabs.oims::lang.settings.cheque"),
//           // 3 => Lang::get("olabs.oims::lang.settings.paypal"),
//           // 4 => Lang::get("olabs.oims::lang.settings.stripe"),
//        ];
//        
//        
////        if ($activeOnly) {
////            $jkshopSetting = \Jiri\JKShop\Models\Settings::instance();
////            if (!$jkshopSetting->cash_on_delivery_active) { unset($options[1]); }
////            if (!$jkshopSetting->bank_transfer_active) { unset($options[2]); }
////            if (!$jkshopSetting->paypal_active) { unset($options[3]); }
////            if (!$jkshopSetting->stripe_active) { unset($options[4]); }
////        }
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
     * Complete create sales from basket
     * - fill all
     * - create invoice
     * - 
     * 
     */
    public function createFromBasket($basket) {
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
        
        // User - Rainlab User if exist
        if (class_exists("\RainLab\User\Models\User")) {
            $user = \RainLab\User\Facades\Auth::getUser();
            if (isset($user)) {
                $this->user_id = \RainLab\User\Facades\Auth::getUser()->id;
            }
        }
        
        // Delivery address
        $this->ds_first_name = $basket["ds_first_name"];
        $this->ds_last_name = $basket["ds_last_name"];
        $this->ds_address = $basket["ds_address"];
        $this->ds_address_2 = $basket["ds_address_2"];
        $this->ds_postcode = $basket["ds_postcode"];
        $this->ds_city = $basket["ds_city"];
        $this->ds_county = $basket["ds_county"];
        $this->ds_country = $basket["ds_country"];

        // Invoice address
        $this->is_first_name = $basket["is_first_name"];
        $this->is_last_name = $basket["is_last_name"];
        $this->is_address = $basket["is_address"];
        $this->is_address_2 = $basket["is_address_2"];
        $this->is_postcode = $basket["is_postcode"];
        $this->is_city = $basket["is_city"];
        $this->is_county = $basket["is_county"];
        $this->is_country = $basket["is_country"];
        
        // Carrier
        $this->carrier = Carrier::find($basket["shipping_id"]);
        
        // Price
        $this->total_price_without_tax = $basket["total_price_without_tax"];
        $this->total_tax = $basket["total_tax"];
        $this->total_price = $basket["total_price"];
        $this->total_global_discount = $basket["total_global_discount"];
        
        $this->shipping_price_without_tax = $basket["shipping_price_without_tax"];
        $this->shipping_tax = $basket["shipping_tax"];
        $this->shipping_price = $basket["shipping_price"];
        
        // coupon
        if ($basket["coupon_model"] != null) {
            $this->coupon = $basket["coupon_model"];
            $wCoupon = Coupon::find($this->coupon->id);
            $wCoupon->used_count++;
            $wCoupon->save();
        }
        
        
        // Contact
        $this->contact_email = $basket["contact_email"];
        $this->contact_phone = $basket["contact_phone"];
        $this->note = $basket["note"];

        // Payment method + SalesStatus
        //$this->payment_method = $basket["payment_method_id"]; // obsolete
        $paymentGateway = PaymentGateway::find($basket["payment_method_id"]);
        $this->paymentGateway = $paymentGateway;
        if (($paymentGateway) && ($paymentGateway->salesStatusBefore)) {
            $this->objectstatus = $paymentGateway->salesStatusBefore;
        }
        
        // Products
        $products_json = [];
        foreach ($basket["products"] as $id => $productJson) {
            
            $qty = $productJson["basket_quantity"];
            $product = Product::find($productJson["product_id"]);
            
            if ($oimsSetting->extended_inventory_management) {
                // extended_inventory_management - after change sales status
            }
            else {
                // check and remove qty form stock
                $qty = $product->salesProduct($qty, true);
                // i call this immediately get basket and this method check stock availability
            }
            
            // $basket["products"][$id]["product"]
            $products_json[] = [
                "product_id" => $productJson["product_id"],
                "quantity" => $qty,
                "total_price_without_tax" => $productJson["total_price_without_tax"],
                "total_tax" => $productJson["total_tax"],
                "total_price" => $productJson["total_price"],
                "options_data" => $productJson["options_data"],
                "options_text" => $productJson["options_text"],
            ];
        }
        $this->products_json = $products_json;

        // ---------------------------------------------------------------------
        // Try to update rainlab user if exist
        // ---------------------------------------------------------------------
        try {
            // User - Rainlab User if exist
            if (class_exists("\RainLab\User\Models\User")) {
                $user = \RainLab\User\Facades\Auth::getUser();
                if (isset($user)) {
                    // Delivery address
                    $user->oims_ds_first_name = $basket["ds_first_name"];
                    $user->oims_ds_last_name = $basket["ds_last_name"];
                    $user->oims_ds_address = $basket["ds_address"];
                    $user->oims_ds_address_2 = $basket["ds_address_2"];
                    $user->oims_ds_postcode = $basket["ds_postcode"];
                    $user->oims_ds_city = $basket["ds_city"];
                    $user->oims_ds_county = $basket["ds_county"];
                    $user->oims_ds_country = $basket["ds_country"];

                    // Invoice address
                    $user->oims_is_first_name = $basket["is_first_name"];
                    $user->oims_is_last_name = $basket["is_last_name"];
                    $user->oims_is_address = $basket["is_address"];
                    $user->oims_is_address_2 = $basket["is_address_2"];
                    $user->oims_is_postcode = $basket["is_postcode"];
                    $user->oims_is_city = $basket["is_city"];
                    $user->oims_is_county = $basket["is_county"];
                    $user->oims_is_country = $basket["is_country"];

                    // Contact
                    $user->oims_contact_email = $basket["contact_email"];
                    $user->oims_contact_phone = $basket["contact_phone"];

                    $user->forceSave();
                }
            }
        } catch (Exception $ex) {
            // do nothing - update user is not important
            return;
        }
        // ---------------------------------------------------------------------

        
    }
    
    /**
     * Event: after create
     * 
     */
    public function afterCreate() {
        $this->onSalesStatusChange($this->objectstatus, null);
        
        // Create invoice html
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
        $html = "<html><head><style>".$oimsSetting->invoice_template_style."</style></head><body>".$oimsSetting->invoice_template_content."</body></html>";
        
        $html =  str_replace("{{sales_id}}", $this->id, $html);
        
        $html =  str_replace("{{first_name}}", $this->is_first_name, $html);
        $html =  str_replace("{{last_name}}", $this->is_last_name, $html);
        $html =  str_replace("{{address}}", $this->is_address, $html);
        $html =  str_replace("{{address2}}", $this->is_address_2, $html);
        $html =  str_replace("{{postcode}}", $this->is_postcode, $html);
        $html =  str_replace("{{city}}", $this->is_city, $html);
        $html =  str_replace("{{county}}", $this->is_county, $html);
        $html =  str_replace("{{country}}", $this->is_country, $html);
        
        $html =  str_replace("{{ds_first_name}}", $this->ds_first_name, $html);
        $html =  str_replace("{{ds_last_name}}", $this->ds_last_name, $html);
        $html =  str_replace("{{ds_address}}", $this->ds_address, $html);
        $html =  str_replace("{{ds_address2}}", $this->ds_address_2, $html);
        $html =  str_replace("{{ds_postcode}}", $this->ds_postcode, $html);
        $html =  str_replace("{{ds_city}}", $this->ds_city, $html);
        $html =  str_replace("{{ds_county}}", $this->ds_county, $html);
        $html =  str_replace("{{ds_country}}", $this->ds_country, $html);
        
        $html =  str_replace("{{email}}", $this->contact_email, $html);
        $html =  str_replace("{{phone}}", $this->contact_phone, $html);
        
        
        if ($this->coupon != null) {
            $html =  str_replace("{{coupon_code}}", $this->coupon->code, $html);
            $html =  str_replace("{{coupon_value}}", $this->coupon->getValueLabel(), $html);
        }
        else {
            $html =  str_replace("{{coupon_code}}", "", $html);
            $html =  str_replace("{{coupon_value}}", "", $html);
        }

        
        $html =  str_replace("{{total_global_discount}}", $oimsSetting->getPriceFormatted($this->total_global_discount), $html);
        $html =  str_replace("{{total_price_without_tax}}", $oimsSetting->getPriceFormatted($this->total_price_without_tax + $this->shipping_price_without_tax), $html);
        $html =  str_replace("{{total_tax}}", $oimsSetting->getPriceFormatted($this->total_tax + $this->shipping_tax ), $html);
        $html =  str_replace("{{total_price}}", $oimsSetting->getPriceFormatted($this->total_price + $this->shipping_price), $html);

        $html =  str_replace("{{payment_method}}", $this->getPaymentMethodLabel(), $html);
        
        $html =  str_replace("{{date_now}}", \Carbon\Carbon::now()->toDateString(), $html);
        $html =  str_replace("{{date_now_14}}", \Carbon\Carbon::now()->addDay(14)->toDateString(), $html);
        $html =  str_replace("{{date_now_31}}", \Carbon\Carbon::now()->addDay(31)->toDateString(), $html);
        
        // products + shipping
        $htmlProducts = "";
        if($this->products_json) {
            foreach ($this->products_json as $product_json) {
                $product = Product::find($product_json["product_id"]);
                $title = "";
                if ($product != null) {
                    $title = $product->title;
                }

                $options_text = "";
                if (array_key_exists("options_text", $product_json)) {
                    $options_text = $product_json["options_text"];
                }

                $htmlProducts .= "<div>";
                $htmlProducts .= "<span class='product-title'>".$title." <small class='product-title-options'>".$options_text."</small></span>";
                $htmlProducts .= "<span class='product-quantity'>".$product_json["quantity"]."</span>";
                $htmlProducts .= "<span class='product-price-without-tax'>".$oimsSetting->getPriceFormatted($product_json["total_price_without_tax"])."</span>";
                $htmlProducts .= "<span class='product-tax'>".$oimsSetting->getPriceFormatted($product_json["total_tax"])."</span>";
                $htmlProducts .= "<span class='product-price'>".$oimsSetting->getPriceFormatted($product_json["total_price"])."</span>";
                $htmlProducts .= "</div>";
            }
        }
        // shipping
        $htmlProducts .= "<div>";
        $htmlProducts .= "<span class='product-title'>Shipping</span>";
        $htmlProducts .= "<span class='product-quantity'>1</span>";
        $htmlProducts .= "<span class='product-price-without-tax'>".$oimsSetting->getPriceFormatted($this->shipping_price_without_tax)."</span>";
        $htmlProducts .= "<span class='product-tax'>".$oimsSetting->getPriceFormatted($this->shipping_tax)."</span>";
        $htmlProducts .= "<span class='product-price'>".$oimsSetting->getPriceFormatted($this->shipping_price)."</span>";
        $htmlProducts .= "</div>";  
        
        $html =  str_replace("{{products}}", $htmlProducts, $html);
        
        
        // Generate invoice
        $invoiceTempFile = temp_path()."/invoice-".$this->id.".pdf";
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $pdf->save($invoiceTempFile);
        
        // add into invoice
        $invoiceFile = new \System\Models\File();
        $invoiceFile->fromFile($invoiceTempFile);
        $this->invoice = $invoiceFile;
        $this->save();
        
        // clear temp
        unlink($invoiceTempFile);
    }
    
    /**
     * Event: before Update
     * 
     */
    public function beforeUpdate() {
        $oldModel = self::find($this->id);
        
        // check sales status change
        if (isset($oldModel)) {
            if (($oldModel->objectstatus == null) && ($this->objectstatus != null)) {
                $this->onSalesStatusChange($this->objectstatus, null);
            }
            else if (($oldModel->objectstatus != null) && ($this->objectstatus != null)) {
                if ($oldModel->objectstatus->id != $this->objectstatus->id) {
                    $this->onSalesStatusChange($this->objectstatus, $oldModel->objectstatus);
                }
            }
        }
    }
    
    public function beforeCreate() {
        
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
     * After sales status change - send email
     * 
     * @param type $newSalesStatus
     * @param type $prevSalesStatus
     */
    private function onSalesStatusChange($newSalesStatus, $prevSalesStatus) {
        
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
        
        if (isset($newSalesStatus)) {
            // prepair data
            $data = [];
            $data["first_name"] = $this->is_first_name;
            $data["last_name"] = $this->is_last_name;
            $data["sales_id"] = $this->id;
            $tracking_url = ($this->carrier) ? $this->carrier->tracking_url : "";
            $tracking_url = str_replace("@", $this->tracking_number , $tracking_url);
            $data["tracking_url"] = ($this->tracking_number != null && $this->tracking_number != "") ? $tracking_url : "";
            
            // send email
            if ($newSalesStatus->mail_template != null) {
                Mail::send($newSalesStatus->mail_template->code, $data, function($message) use ($oimsSetting, $newSalesStatus) {

                    $message->to($this->contact_email);
                    
                    if ($oimsSetting->copy_all_sales_emails_to != "") {
                        $message->bcc($oimsSetting->copy_all_sales_emails_to);
                    }
                    
                    // attach invoice?
                    if (($newSalesStatus->attach_invoice_pdf_to_email) && ($this->invoice != null)) {
                        $message->attach($this->invoice->getLocalPath(), ['as' => "invoice-".$this->id.".pdf"]);
                    }
                });                
            }

            // extended_inventory_management - after change sales status
            if ($oimsSetting->extended_inventory_management) {
                
                // qty decrease
                if ($newSalesStatus->qty_decrease) {
                    foreach ($this->products_json as $key => $producJson) {
                        $product = \Olabs\Oims\Models\Product::find($producJson["product_id"]);
                        if ($product) {
                            $qty = $producJson["quantity"];
                            $product->salesProduct($qty, true);
                        }
                    }
                }
                
                // qty increase back
                if ($newSalesStatus->qty_increase_back) {
                    // !!! ONLY if have previous status with qty_decrease
                    if (($prevSalesStatus != null) && ($prevSalesStatus->qty_decrease)) {
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
     * Find sales for payment gateway or return null
     * 
     * @param type $id
     */
    public static function findSalesBySlugForPaymentGateway($id) {
        $sales = self::find($id);
        
        // check if sales have user => user have to be logged in
        if ($sales->user_id) {
            $user = \RainLab\User\Facades\Auth::getUser();
            
            // check anonymous access
            if ($user == null) {
                return null;
            }
            
            // check another user
            if ($sales->user_id != $user->id) {
                return null;
            }
        }
        
        // check disallowed sales statuses
        if ($sales->objectstatus) {
            if ($sales->objectstatus->disallow_for_gateway) {
                return null;
            }
        }
        
        return $sales;
        
    }
    

}