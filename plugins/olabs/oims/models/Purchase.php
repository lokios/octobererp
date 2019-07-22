<?php

namespace Olabs\Oims\Models;

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
class Purchase extends BaseModel {

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_purchases';

    const CNAME = 'purchases';

    public $execute_validation = True;

    public function getEntityType() {
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
        "payment_method", // obsolete
        "execute_validation",
    ];
    public $rules = [
//        'title' => 'required|between:2,255',
        'user_id' => 'numeric|required',
        'reference_number' => 'numeric|required|unique:olabs_oims_purchases',
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
        'paid_detail',
        'vehicle_meta',
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
        'projectBook' => [
            'Olabs\Oims\ProjectBook\Coupon',
            'key' => 'project_book_id'
        ],
        'createdBy' => [
            'Backend\Models\User',
            'key' => 'created_by'
        ],
        'updatedBy' => [
            'Backend\Models\User',
            'key' => 'updated_by'
        ],
        'vehicle' => [
            'Olabs\Oims\Models\Vehicle',
            'key' => 'vehicle_id'
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

    public function getSetupCodeAttribute() {
        return strtoupper(str_random(8));
    }

    public function getProductOptions() {
        return Product::get()->lists("title", "id");
    }

    public function getUserOptions() {
        if (class_exists("\RainLab\User\Models\User")) {
            $usersList = \RainLab\User\Models\User::select(
                            DB::raw("CONCAT_WS(' ', id, '|', name, surname) AS full_name, id")
                    )->lists('full_name', 'id');
            return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $usersList;
        } else {
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

    /*
     * After fetch data from DB
     * 
     */

    public $extend_products_json = array();

    public function afterFetch() {
        // add product relation by products_json into extend_products_json
        $this->extend_products_json = array();
        if ($this->products_json) {
            foreach ($this->products_json as $key => $producJson) {
                $producJson["product"] = \Olabs\Oims\Models\Product::find($producJson["product_id"]);
                $this->extend_products_json += [$key => $producJson];
            }
        }
    }

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



    public function genereateInvoice($download = false) {

        $this->onPurchaseStatusChange($this->objectstatus, null);

        // Create invoice html
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

//        $html = "<html><head><style>".$oimsSetting->material_receipt_template_style."</style></head><body>".$oimsSetting->material_receipt_template_content."</body></html>";

        $template_style = str_replace("\r\n", "", $oimsSetting->material_receipt_template_style);



        $template_content = str_replace("\r\n", "", $oimsSetting->material_receipt_template_content);
        $template_content = str_replace("\t", "", $template_content);

        $html = "";
        $html = "<html><head><style> $template_style </style></head><body>$template_content</body></html>";


        $html = str_replace("{{m_r_number}}", $this->reference_number, $html);
        $html = str_replace("{{context_date}}", $this->context_date, $html);

        if ($this->user_id) {
            $supplier = \Backend\Models\User::find($this->user_id);
            $supplierName = $supplier ? $supplier->getFullNameAttribute() : "";
        } else {
            $supplierName = "";
        }


        $html = str_replace("{{supplier}}", $supplierName, $html);

        $html = str_replace("{{bill_number}}", $this->bill_number, $html);
        $html = str_replace("{{bill_date}}", $this->bill_date, $html);
        $html = str_replace("{{thru_vehicle_number}}", $this->thru_vehicle_number, $html);
        $html = str_replace("{{arrived_on_date}}", $this->arrived_on_date, $html);
        $html = str_replace("{{driver_name}}", $this->driver_name, $html);
        $html = str_replace("{{note}}", $this->note, $html);

//        $html =  str_replace("{{total_price}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price), $html);
        $html = str_replace("{{total_global_discount}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_global_discount), $html);
        $html = str_replace("{{total_price_without_tax}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price_without_tax + $this->shipping_price_without_tax), $html);
        $html = str_replace("{{total_tax}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_tax + $this->shipping_tax), $html);
        $html = str_replace("{{total_price}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price), $html);

        $html = str_replace("{{total_price}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price), $html);
        $html = str_replace("{{total_tax}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_tax), $html);

        // products + shipping
        $htmlProducts = "";
        $productTableRow = "";
        $taxTableRow = "";

        $products = (count($this->products)) ? $this->products : PurchaseProduct::getPurchaseProducts($this->id);
        $productsTemplate = $oimsSetting->get_string_between($html, '<tr id="products_row">', '</tr>');

        if (count($products)) {
            // id based product template set in HTML
            $isProductTemplateSet = ($productsTemplate != "") ? true : false;
            $serialNumber = 1;
            foreach ($products as $product) {

                $title = $product->product ? $product->product->title : $product->description;
                $qty = $product->quantity;
                $productUnit = $product->unit;
                $productTaxPercent = $product->tax_percent;
                $productRate = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $totalPrice = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $totalTax = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_tax);

                $productFields = array(
                    '{{product_sno}}' => $serialNumber,
                    '{{product_title}}' => $title,
                    '{{product_unit}}' => $productUnit,
                    '{{product_tax_percent}}' => $productTaxPercent,
                    '{{product_qty}}' => $qty,
                    '{{product_rate}}' => $productRate,
                    '{{product_total_price}}' => $totalPrice,
                    '{{product_total_tax}}' => $totalTax
                );

                $productTableRow .= $isProductTemplateSet ? "<tr>" . strtr($productsTemplate, $productFields) . "</tr>" : "";

                $htmlProducts .= "<div>";
                $htmlProducts .= "<span class='product-title'>" . $title . " <small class='product-title-options'>" . $title . "</small></span>";
                $htmlProducts .= "<span class='product-quantity'>" . $qty . "</span>";
                $htmlProducts .= "<span class='product-price-without-tax'>" . $oimsSetting->getPriceFormatted($product->total_price_without_tax) . "</span>";
                $htmlProducts .= "<span class='product-tax'>" . $oimsSetting->getPriceFormatted($product->total_tax) . "</span>";
                $htmlProducts .= "<span class='product-price'>" . $oimsSetting->getPriceFormatted($product->total_price) . "</span>";
                $htmlProducts .= "</div>";

                $serialNumber += 1;
            }
        }

        /* Log::info('replace html start ');
          trace_log($html);
          trace_log($productTableRow); */

        $html = $oimsSetting->replace_string($html, '<tr id="products_row">', '</tr>', $productTableRow);
        //Log::info('html after replace ');
        //trace_log($html);

        $html = str_replace("{{products}}", $htmlProducts, $html);

        //Tax breakups
        $taxTemplate = $oimsSetting->getTableRowContent($html, 'class', 'tax_row');
        $isTaxTemplateSet = ($taxTemplate != "") ? true : false;
//        if($this->tax_igst_amount > 0){
        if ($this->tax_igst > 0) {
//            $label = "iGST $this->tax_igst%";
            $label = "iGST";
            $amount = $oimsSetting->getPriceFormattedWithoutCurrency($this->tax_igst_amount);
            $fields = array(
                '{{tax_label}}' => $label,
                '{{tax_amount}}' => $amount,
            );
            $taxTableRow .= $isTaxTemplateSet ? strtr($taxTemplate, $fields) : "";
        }
//        if($this->tax_cgst_amount > 0){
        if ($this->tax_cgst > 0) {
//            $label = "cGST $this->tax_cgst%";
            $label = "cGST";
            $amount = $oimsSetting->getPriceFormattedWithoutCurrency($this->tax_cgst_amount);
            $fields = array(
                '{{tax_label}}' => $label,
                '{{tax_amount}}' => $amount,
            );
            $taxTableRow .= $isTaxTemplateSet ? strtr($taxTemplate, $fields) : "";
        }
//        if($this->tax_sgst_amount > 0){
        if ($this->tax_sgst > 0) {
//            $label = "sGST $this->tax_sgst%";
            $label = "sGST";
            $amount = $oimsSetting->getPriceFormattedWithoutCurrency($this->tax_sgst_amount);
            $fields = array(
                '{{tax_label}}' => $label,
                '{{tax_amount}}' => $amount,
            );
            $taxTableRow .= $isTaxTemplateSet ? strtr($taxTemplate, $fields) : "";
        }

        $html = str_replace($taxTemplate, $taxTableRow, $html);





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

        $this->uniqueReferenceNumberCheck();
        $oldModel = self::find($this->id);

        $user = BackendAuth::getUser();
        
        if ($this->updated_by == '') {
            $this->updated_by = $user->id;
        }
        
        // check purchase status change
        if (isset($oldModel)) {
            if (($oldModel->objectstatus == null) && ($this->objectstatus != null)) {
                $this->onPurchaseStatusChange($this->objectstatus, null);
            } else if (($oldModel->objectstatus != null) && ($this->objectstatus != null)) {
                if ($oldModel->objectstatus->id != $this->objectstatus->id) {
                    $this->onPurchaseStatusChange($this->objectstatus, $oldModel->objectstatus);
                }
            }
        }
    }

    public function beforeCreate() {

        $this->contextDateCheck();

        $this->uniqueReferenceNumberCheck();
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

    //Recalcualte Taxes and final amount
    public function recalculateAmounts() {

//        $total_price_without_tax = $this->total_price_without_tax;
//        if(!$this->total_price_without_tax){
        //Calculate it from products total price
        $this->total_price_without_tax = 0;
        $this->total_tax = 0;
        foreach ($this->products as $product) {
            $this->total_price_without_tax += $product->total_price - $product->total_tax;
            $this->total_tax += $product->total_tax;
        }
//        }
        //calculate Taxes
//        $this->tax_igst_amount = 0;
//        $this->tax_cgst_amount = 0;
//        $this->tax_sgst_amount = 0;
//        //iGST
//        if($this->tax_igst){
//            $this->tax_igst_amount = ($this->total_price_without_tax * $this->tax_igst) / 100;
//        }
//        
//        //cGST
//        if($this->tax_cgst){
//            $this->tax_cgst_amount = ($this->total_price_without_tax * $this->tax_cgst) / 100;
//        }
//        
//        //sGST
//        if($this->tax_sgst){
//            $this->tax_sgst_amount = ($this->total_price_without_tax * $this->tax_sgst) / 100;
//        }
//        $this->total_tax = $this->tax_igst_amount + $this->tax_cgst_amount + $this->tax_sgst_amount;
        $this->total_price = $this->total_tax + $this->total_price_without_tax;

        //iGST

        $this->tax_igst_amount = $this->total_tax;


        //cGST

        $this->tax_cgst_amount = $this->total_tax / 2;


        //sGST

        $this->tax_sgst_amount = $this->total_tax / 2;



        //finally save it
        $this->save();
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
            $tracking_url = str_replace("@", $this->tracking_number, $tracking_url);
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
                        $message->attach($this->invoice->getLocalPath(), ['as' => "invoice-" . $this->id . ".pdf"]);
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

    public function contextDateCheck() {
        //If dont want to execute validation : use in Entity Relation data sync from mobile
        //Run validation in any case
//        if (!$this->execute_validation) {
//            return;
//        }
        if($this->skipValidation()){
            return;
        }
        
        //check for mr reference date should be today only
        if ($this->context_date != '') {
            $date = date("d.m.Y");
            $match_date = date('d.m.Y', strtotime($this->context_date));
            if ($date != $match_date) {
                throw new \ValidationException(['context_date' => 'M.R. Date should be today only.']);
                //Today
            } 
//            elseif (strtotime("-1 day", $date) == $match_date) {
//
//                //Yesterday
//            } elseif (strtotime("+1 day", $date) == $match_date) {
//
//                //Tomorrow
//            } else {
//
//                //Sometime
//            }
        }
    }
    
    private function skipValidation(){
        //user Modal
        $user = BackendAuth::getUser();
        
//        if($user->isAdmin()){
//            return TRUE;
//        }
        //If dont want to execute validation : use in Entity Relation data sync from mobile
        
        //Skip validation if status is not new!
        if($this->status != Status::STATUS_NEW && $user->isAdmin()){
            return TRUE;
        }
        
        //Skip validation if execute_validation is false and user is admin
        if (!$this->execute_validation && $user->isAdmin()) {
            return TRUE;
        }
        
        
        
        return false;
    }

    public function uniqueReferenceNumberCheck() {
//        return true; // Not required to check, running default
        //If dont want to execute validation : use in Entity Relation data sync from mobile
        //Run validation in any case
//        if (!$this->execute_validation) {
//            return;
//        }
        if($this->skipValidation()){
            return;
        }
        //Check for numeric only
        if (!ctype_digit($this->reference_number)) {
            throw new \ValidationException(['reference_number' => 'M.R. Number must be in digit only [0-9].']);
        }

        //Check MR Number uniqueness through out project
        if ($this->id) {
            $invalid = Purchase::where('reference_number', $this->reference_number)
//                               ->where('project_id', $this->project_id)
                            ->where('id', '<>', $this->id)->count();
        } else {
            $invalid = Purchase::where('reference_number', $this->reference_number)
//                               ->where('project_id', $this->project_id)
                    ->count();
        }
        if ($invalid) {
            throw new \ValidationException(['reference_number' => 'M.R. Number must be unique for a project.']);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        //Check MR Number perent in assing MR books based on Inventry Default Settings
        if ($oimsSetting->check_with_project_book) {

            $project_book = $this->getProjectBookByReferenceNumber();
//        dd($project_book);
            if (!$project_book) {
                throw new \ValidationException(['reference_number' => 'M.R. Number must be matched with Book Issued.']);
            }
        }


        return true;
    }

    public function filterFields($fields, $context = null) {
//        dd($context);
        if ($this->quote) {
            $fields->user_id->value = $this->quote->user_id;
        }
        //user Modal
        $user = BackendAuth::getUser();

        //If MR Number entered then dont allow for edit
        $referenceNumber = isset($fields->reference_number) ? $fields->reference_number->value : false;
        if ($referenceNumber && $referenceNumber != '' && !$user->isAdmin()) {
            $fields->reference_number->disabled = true;
        }

        //If Date is entered then don't allow for edit 
//        $contextDate = isset($fields->context_date) ? $fields->context_date->value : false;
//        
//        //User is not admin and have not permission for back date entry
//        if(!$user->isAdmin() OR !$user->hasAccess('olabs.oims.record_back_date_entry')){
//            if ($contextDate && date('Y-m-d H:i:s', strtotime($contextDate)) < date('Y-m-d 00:00:00', strtotime('today'))) {
//                $fields->context_date->disabled = true;
//            }
//            $fields->context_date->default = 'today';
//        }


        //Payment checks
        if ($fields->payment_method && isset($fields->{'paid_detail[payment_from]'})) {
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

            if ($fields->payment_method->value == PaymentReceivable::PAYMENT_METHOD_CHEQUE) {
                $fields->{'paid_detail[cheque_number]'}->hidden = false;
                $fields->{'paid_detail[cheque_date]'}->hidden = false;
                $fields->{'paid_detail[cheque_account]'}->hidden = false;
            } else if ($fields->payment_method->value == PaymentReceivable::PAYMENT_METHOD_BANK_TRANSFER) {
                $fields->{'paid_detail[payment_from]'}->hidden = false;
                $fields->{'paid_detail[payment_to]'}->hidden = false;
                $fields->{'paid_detail[transaction_id]'}->hidden = false;
            } else if ($fields->payment_method->value == PaymentReceivable::PAYMENT_METHOD_DEMAND_DRAFT) {
                $fields->{'paid_detail[dd_number]'}->hidden = false;
                $fields->{'paid_detail[issuing_bank]'}->hidden = false;
                $fields->{'paid_detail[issue_date]'}->hidden = false;
            }
        }
        
        //Hide comment if form context is preview
        if($context == 'preview'){
            $fields->vehicle->comment = '';
        }
        
        //Vehicle checks
        if ($fields->vehicle) {
            $fields->{'vehicle_meta[unit]'}->hidden = true;
            $fields->{'vehicle_meta[length]'}->hidden = true;
            $fields->{'vehicle_meta[width]'}->hidden = true;
            $fields->{'vehicle_meta[height]'}->hidden = true;
            if ($fields->vehicle->value > 0) {
                $fields->{'vehicle_meta[unit]'}->hidden = false;
                $fields->{'vehicle_meta[length]'}->hidden = false;
                $fields->{'vehicle_meta[width]'}->hidden = false;
                $fields->{'vehicle_meta[height]'}->hidden = false;
                
                $fields->{'vehicle_meta[unit]'}->value = $fields->{'vehicle_meta[unit]'}->value != "" ? $fields->{'vehicle_meta[unit]'}->value : $this->vehicle->unit;
                $fields->{'vehicle_meta[length]'}->value = $fields->{'vehicle_meta[length]'}->value != "" ? $fields->{'vehicle_meta[length]'}->value : $this->vehicle->length;
                $fields->{'vehicle_meta[width]'}->value = $fields->{'vehicle_meta[width]'}->value != "" ? $fields->{'vehicle_meta[width]'}->value : $this->vehicle->width;
                $fields->{'vehicle_meta[height]'}->value = $fields->{'vehicle_meta[height]'}->value != "" ? $fields->{'vehicle_meta[height]'}->value : $this->vehicle->height;
            }
        }
    }
    
    public function getUnitOptions() {
        $list = Unit::select(
                        DB::raw("name, slug")
                )->where('status', '1')->lists('name', 'slug');
        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $list;
    }
    
    public function getEntityRelation(){
        $model = \Olabs\Social\Models\EntityRelations::where('target_type','mr_entry')
                ->where('target_id',$this->id)->first();
        return $model;
        
    }
    
    public function getVehicleCapacity(){
//        return false;
        if(!$this->vehicle){
            return false;
        }
        //dd($this->vehicle_meta);
        
        $lenght = $this->vehicle_meta['length']  > 0 ? $this->vehicle_meta['length']  : 0;
        $width = $this->vehicle_meta['width']  > 0 ? $this->vehicle_meta['width']  : 0;
        $height = $this->vehicle_meta['height']  > 0 ? $this->vehicle_meta['height']  : 0;
        
        $volumn = $lenght * $width * $height;
        
        return $this->vehicle->getConversions($volumn);
        
    }
    
}
