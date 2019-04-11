<?php

namespace Olabs\Oims\Models;

use Model;
use DB;
use Mail;
use App;
use Lang;
use BackendAuth;

/**
 * Quote Model
 */
class Quote extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_quotes';

    const CNAME = 'quotes';
    const QUOTE_TYPE_PETTY_CONTRACT = 'petty_contract';
    const QUOTE_TYPE_MATERIAL = 'material';
    const QUOTE_TYPE_WORK_ORDER = 'work_order';

    protected $QUOTE_TYPES = ['material' => 'Material', 'petty_contract' => 'Petty Contract', 'work_order' => 'Work Order'];

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
    public $hasOne = [];
    public $hasMany = [
        'products' => [
            'Olabs\Oims\Models\QuoteProduct',
            'key' => 'quote_id'
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
        'supplier' => [
            'Olabs\Oims\Models\Supplier',
            'key' => 'user_id'
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

//    public $attachMany = [];


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
//            1 => Lang::get("olabs.oims::lang.settings.cash_on_delivery"),
//            2 => Lang::get("olabs.oims::lang.settings.bank_transfer"),
//            3 => Lang::get("olabs.oims::lang.settings.paypal"),
//            4 => Lang::get("olabs.oims::lang.settings.stripe"),
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
//    public function afterCreate() {
//        
//    }

    public function genereateInvoice($download = false) {
        $this->onQuoteStatusChange($this->objectstatus, null);

        // Create invoice html
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
        
        
        
        $template_style = str_replace("\r\n", "", $oimsSetting->invoice_template_style);

        
        
        $template_content = str_replace("\r\n", "", $oimsSetting->invoice_template_content);
        $template_content = str_replace("\t", "", $template_content);

        $html = "";
        $html = "<html><head><style> $template_style </style></head><body>$template_content</body></html>";

       
        //Logo src
        $logo = \Backend\Models\BrandSetting::getLogo();
        $html = str_replace("{{logo_src}}", $logo, $html);

        $contextDate = empty($this->context_date) ? "" : Settings::convertToDisplayDate($this->context_date);
        $html = str_replace("{{context_date}}", $contextDate, $html);

        $orderNumber = empty($this->reference_number) ? "" : $this->reference_number;
        $html = str_replace("{{order_id}}", $orderNumber, $html);
        
        $order_label = "Order No";
        if($this->quote_type == self::QUOTE_TYPE_MATERIAL){
            $order_label = "Purchase Order No";
        }else if($this->quote_type == self::QUOTE_TYPE_PETTY_CONTRACT){
             $order_label = "Work Order No";
        }
        
        $html = str_replace("{{order_label}}", $order_label, $html);

        if ($this->user_id) {
            $supplier = Supplier::find($this->user_id);
        } else {
            $supplier = false;
        }

        $supplierName = $supplier ? $supplier->getFullNameAttribute() : "";
        $supplierFullAddress = $supplier ? $supplier->getFullAddressAttribute() : "";
        $supplierAddress = ( $supplier && !empty($supplier->address) ) ? $supplier->address : "";
        $supplierAddress2 = ( $supplier && !empty($supplier->address_2) ) ? $supplier->address_2 : "";
        $supplierCity = ( $supplier && !empty($supplier->city) ) ? $supplier->city : "";
        $supplierCountry = ( $supplier && !empty($supplier->country) ) ? $supplier->country : "";
        $supplierPostCode = ( $supplier && !empty($supplier->postcode) ) ? $supplier->postcode : "";
        $supplierContactEmail = ( $supplier && !empty($supplier->contact_email) ) ? $supplier->contact_email : "";
        $supplierContactPhone = ( $supplier && !empty($supplier->contact_phone) ) ? $supplier->contact_phone : "";
        $supplierTin = ( $supplier && !empty($supplier->tin) ) ? $supplier->tin : "";
        $supplierPan = ( $supplier && !empty($supplier->pan) ) ? $supplier->pan : "";
        $supplierGSTNumber = ( $supplier && !empty($supplier->gst_number) ) ? $supplier->gst_number : "";


        $html = str_replace("{{supplier}}", $supplierName, $html);
        $html = str_replace("{{supplier_full_address}}", $supplierFullAddress, $html);
        $html = str_replace("{{supplier_address}}", $supplierAddress, $html);
        $html = str_replace("{{supplier_address2}}", $supplierAddress2, $html);
        $html = str_replace("{{supplier_city}}", $supplierCity, $html);
        $html = str_replace("{{supplier_country}}", $supplierCountry, $html);
        $html = str_replace("{{supplier_postcode}}", $supplierPostCode, $html);
        $html = str_replace("{{supplier_contact_email}}", $supplierContactEmail, $html);
        $html = str_replace("{{supplier_contact_phone}}", $supplierContactPhone, $html);
        $html = str_replace("{{supplier_tin}}", $supplierTin, $html);
        $html = str_replace("{{supplier_pan}}", $supplierPan, $html);
        $html = str_replace("{{supplier_gst_number}}", $supplierGSTNumber, $html);
        

        $project = $this->project;
        $projectFullAddress = $project ? $project->getFullAddressAttribute() : "";
        $projectBillingAddress = $project ? $project->getFullBillingAddressAttribute() : "";
        $projectContactPerson = $project ? $project->contact_person : "";
        $projectContactPhone = $project ? $project->contact_phone : "";
        $projectContactEmail = $project ? $project->contact_email : "";
        $projectGSTNumber = $project ? $project->gst_number : "";

        $html = str_replace("{{project_name}}", $project->name, $html);
        $html = str_replace("{{project_address}}", $project->address, $html);
        $html = str_replace("{{project_address2}}", $project->address_2, $html);
        $html = str_replace("{{project_city}}", $project->city, $html);
        $html = str_replace("{{project_country}}", $project->country, $html);
        $html = str_replace("{{project_postcode}}", $project->postcode, $html);
        $html = str_replace("{{project_full_address}}", $projectFullAddress, $html);
        $html = str_replace("{{project_billing_address}}", $project->billing_address, $html);
        $html = str_replace("{{project_billing_address2}}", $project->billing_address_2, $html);
        $html = str_replace("{{project_billing_city}}", $project->billing_city, $html);
        $html = str_replace("{{project_billing_country}}", $project->billing_country, $html);
        $html = str_replace("{{project_billing_postcode}}", $project->billing_postcode, $html);
        $html = str_replace("{{project_billing_address}}", $projectBillingAddress, $html);
        $html = str_replace("{{project_contact_person}}", $projectContactPerson, $html);
        $html = str_replace("{{project_contact_phone}}", $projectContactPhone, $html);
        $html = str_replace("{{project_contact_email}}", $projectContactEmail, $html);
        $html = str_replace("{{project_gst_number}}", $projectGSTNumber, $html);

        $temp = empty($this->supplier_contact_person) ? "" : $this->supplier_contact_person;
        $html = str_replace("{{supplier_contact_person}}", $temp, $html);
        
        $temp = empty($this->challan_name) ? "" : $this->challan_name;
        $html = str_replace("{{challan_name}}", $temp, $html);
        
        
        
//        $temp = empty($this->challan_name) ? "" : $this->challan_name;
//        $html = str_replace("{{challan_name}}", $temp, $html);
        
        $temp = empty($this->subject) ? "" : $this->subject;
        $html = str_replace("{{subject}}", $temp, $html);

        $company = $project->company;
        $companyFullAddress = $company ? $company->getFullAddressAttribute() : "";
        $html = str_replace("{{company_name}}", $company->name, $html);
        $html = str_replace("{{company_address}}", $company->address, $html);
        $html = str_replace("{{company_address2}}", $company->address_2, $html);
        $html = str_replace("{{company_city}}", $company->city, $html);
        $html = str_replace("{{company_country}}", $company->country, $html);
        $html = str_replace("{{company_postcode}}", $company->postcode, $html);
        $html = str_replace("{{company_contact_person}}", $company->contact_person, $html);
        $html = str_replace("{{company_contact_phone}}", $company->contact_phone, $html);
        $html = str_replace("{{company_contact_email}}", $company->contact_email, $html);
        $html = str_replace("{{company_full_address}}", $companyFullAddress, $html);

        $temp = empty($this->note) ? "N/A" : $this->note;
        $html = str_replace("{{note}}", $temp, $html);
        
        $temp = empty($this->loading) ? "N/A" : $this->loading;
        $html = str_replace("{{loading}}", $temp, $html);
        
        $temp = empty($this->tax_method) ? "N/A" : $this->tax_method;
        $html = str_replace("{{tax_method}}", $temp, $html);
        
        $temp = empty($this->freight) ? "N/A" : $this->freight;
        $html = str_replace("{{freight}}", $temp, $html);
        
        $temp = empty($this->form_c) ? "N/A" : $this->form_c;
        $html = str_replace("{{form_c}}", $temp, $html);
        
        $temp = empty($this->guaranty) ? "N/A" : $this->guaranty;
        $html = str_replace("{{guaranty}}", $temp, $html);
        
        $temp = empty($this->delivery_time) ? "N/A" : $this->delivery_time;
        $html = str_replace("{{delivery_time}}", $temp, $html);
        
        $temp = empty($this->delivery_at) ? "N/A" : $this->delivery_at;
        $html = str_replace("{{delivery_at}}", $temp, $html);
        
        $temp = empty($this->test_certificate) ? "N/A" : $this->test_certificate;
        $html = str_replace("{{test_certificate}}", $temp, $html);
        
        $temp = empty($this->payment_terms) ? "N/A" : $this->payment_terms;
        $html = str_replace("{{payment_terms}}", $temp, $html);
        
        $temp = empty($this->terms_condition) ? "N/A" : $this->terms_condition;
        $html = str_replace("{{terms_condition}}", $temp, $html);
        
        $temp = empty($this->operational_terms) ? "N/A" : $this->operational_terms;
        $html = str_replace("{{operational_terms}}", $temp, $html);

        $html = str_replace("{{quote_id}}", $this->id, $html);

        $html = str_replace("{{first_name}}", $this->is_first_name, $html);
        $html = str_replace("{{last_name}}", $this->is_last_name, $html);
        $html = str_replace("{{address}}", $this->is_address, $html);
        $html = str_replace("{{address2}}", $this->is_address_2, $html);
        $html = str_replace("{{postcode}}", $this->is_postcode, $html);
        $html = str_replace("{{city}}", $this->is_city, $html);
        $html = str_replace("{{county}}", $this->is_county, $html);
        $html = str_replace("{{country}}", $this->is_country, $html);

        $html = str_replace("{{ds_first_name}}", $this->ds_first_name, $html);
        $html = str_replace("{{ds_last_name}}", $this->ds_last_name, $html);
        $html = str_replace("{{ds_address}}", $this->ds_address, $html);
        $html = str_replace("{{ds_address2}}", $this->ds_address_2, $html);
        $html = str_replace("{{ds_postcode}}", $this->ds_postcode, $html);
        $html = str_replace("{{ds_city}}", $this->ds_city, $html);
        $html = str_replace("{{ds_county}}", $this->ds_county, $html);
        $html = str_replace("{{ds_country}}", $this->ds_country, $html);

        $html = str_replace("{{email}}", $this->contact_email, $html);
        $html = str_replace("{{phone}}", $this->contact_phone, $html);


        if ($this->coupon != null) {
            $html = str_replace("{{coupon_code}}", $this->coupon->code, $html);
            $html = str_replace("{{coupon_value}}", $this->coupon->getValueLabel(), $html);
        } else {
            $html = str_replace("{{coupon_code}}", "", $html);
            $html = str_replace("{{coupon_value}}", "", $html);
        }


        $html = str_replace("{{total_global_discount}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_global_discount), $html);
        $html = str_replace("{{total_price_without_tax}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price_without_tax + $this->shipping_price_without_tax), $html);
        $html = str_replace("{{total_tax}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_tax + $this->shipping_tax), $html);
        $html =  str_replace("{{total_price}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price), $html); 

        $html = str_replace("{{payment_method}}", $this->getPaymentMethodLabel(), $html);

        $html = str_replace("{{date_now}}", \Carbon\Carbon::now()->toDateString(), $html);
        $html = str_replace("{{date_now_14}}", \Carbon\Carbon::now()->addDay(14)->toDateString(), $html);
        $html = str_replace("{{date_now_31}}", \Carbon\Carbon::now()->addDay(31)->toDateString(), $html);

        $html = str_replace("{{total_price}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_price), $html);
        $html = str_replace("{{total_tax}}", $oimsSetting->getPriceFormattedWithoutCurrency($this->total_tax), $html);

        // products + shipping
        $htmlProducts = "";
        $productTableRow = "";
        $taxTableRow = "";

        $products = (count($this->products)) ? $this->products : QuoteProduct::getPurchaseProducts($this->id);
        
        $productsTemplate = $oimsSetting->getTableRowContent($html, 'class', 'products_row');
//        dd($productsTemplate);
        
//        $productsTemplate = $oimsSetting->get_string_between($html, '<tr id="products_row">', '</tr>');

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

                $productTableRow .= $isProductTemplateSet ?  strtr($productsTemplate, $productFields)  : "";

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
        
        $html = str_replace($productsTemplate,$productTableRow, $html);
        

        $html = str_replace("{{products}}", $htmlProducts, $html);
        
        
        //Tax breakups
        $taxTemplate = $oimsSetting->getTableRowContent($html, 'class', 'tax_row');
        $isTaxTemplateSet = ($taxTemplate != "") ? true : false;
//        if($this->tax_igst_amount > 0){
        if($this->tax_igst > 0){
//            $label = "iGST $this->tax_igst%";
            $label = "iGST";
            $amount = $oimsSetting->getPriceFormattedWithoutCurrency($this->tax_igst_amount);
            $fields = array(
                    '{{tax_label}}' => $label,
                    '{{tax_amount}}' => $amount,
                );
            $taxTableRow .= $isTaxTemplateSet ?  strtr($taxTemplate, $fields)  : "";
        }
//        if($this->tax_cgst_amount > 0){
        if($this->tax_cgst > 0){
//            $label = "cGST $this->tax_cgst%";
            $label = "cGST";
            $amount = $oimsSetting->getPriceFormattedWithoutCurrency($this->tax_cgst_amount);
            $fields = array(
                    '{{tax_label}}' => $label,
                    '{{tax_amount}}' => $amount,
                );
            $taxTableRow .= $isTaxTemplateSet ?  strtr($taxTemplate, $fields)  : "";
        }
//        if($this->tax_sgst_amount > 0){
        if($this->tax_sgst > 0){
//            $label = "sGST $this->tax_sgst%";
            $label = "sGST";
            $amount = $oimsSetting->getPriceFormattedWithoutCurrency($this->tax_sgst_amount);
            $fields = array(
                    '{{tax_label}}' => $label,
                    '{{tax_amount}}' => $amount,
                );
            $taxTableRow .= $isTaxTemplateSet ?  strtr($taxTemplate, $fields)  : "";
        }
        
        $html = str_replace($taxTemplate,$taxTableRow, $html);

        // Generate invoice
        $fileName = 'invoice_' . $this->id . '_' . time();
        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
//        $invoiceTempFile = temp_path() . "/invoice-" . $this->id . ".pdf";
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
//        $pdf->define('isHtml5ParserEnabled', true);
        $pdf->setPaper('A4', 'portrait'); //landscape
        $pdf->save($invoiceTempFile);

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
        $oldModel = self::find($this->id);
        
        //Reference Number is empty then set form default
        $this->reference_number = $this->reference_number != ''? $this->reference_number : $this->generateReferenceNumber();
        
        // check quote status change
        if (isset($oldModel)) {
            if (($oldModel->objectstatus == null) && ($this->objectstatus != null)) {
                $this->onQuoteStatusChange($this->objectstatus, null);
            } else if (($oldModel->objectstatus != null) && ($this->objectstatus != null)) {
                if ($oldModel->objectstatus->id != $this->objectstatus->id) {
                    $this->onQuoteStatusChange($this->objectstatus, $oldModel->objectstatus);
                }
            }
        }
    }

    public function beforeCreate() {

        if ($this->status == '') {
            $this->status = Status::STATUS_NEW;
        }
        
        //Reference Number is empty then set form default
        $this->reference_number = $this->reference_number != ''? $this->reference_number : $this->generateReferenceNumber();

        $user = BackendAuth::getUser();
        if ($this->created_by == '') {
            $this->created_by = $user->id;
        }
        if ($this->updated_by == '') {
            $this->updated_by = $user->id;
        }
    }
    
    //Recalcualte Taxes and final amount
    public function recalculateAmounts(){
        
//        $total_price_without_tax = $this->total_price_without_tax;
        
//        if(!$this->total_price_without_tax){
            //Calculate it from products total price
            $this->total_price_without_tax = 0;
            $this->total_tax = 0;
            foreach($this->products as $product){
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
     * After quote status change - send email
     * 
     * @param type $newQuoteStatus
     * @param type $prevQuoteStatus
     */
    private function onQuoteStatusChange($newQuoteStatus, $prevQuoteStatus) {

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        if (isset($newQuoteStatus)) {
            // prepair data
            $data = [];
            $data["first_name"] = $this->is_first_name;
            $data["last_name"] = $this->is_last_name;
            $data["quote_id"] = $this->id;
            $tracking_url = ($this->carrier) ? $this->carrier->tracking_url : "";
            $tracking_url = str_replace("@", $this->tracking_number, $tracking_url);
            $data["tracking_url"] = ($this->tracking_number != null && $this->tracking_number != "") ? $tracking_url : "";

            // send email
            if ($newQuoteStatus->mail_template != null) {
                Mail::send($newQuoteStatus->mail_template->code, $data, function($message) use ($oimsSetting, $newQuoteStatus) {

                    $message->to($this->contact_email);

                    if ($oimsSetting->copy_all_quote_emails_to != "") {
                        $message->bcc($oimsSetting->copy_all_quote_emails_to);
                    }

                    // attach invoice?
                    if (($newQuoteStatus->attach_invoice_pdf_to_email) && ($this->invoice != null)) {
                        $message->attach($this->invoice->getLocalPath(), ['as' => "invoice-" . $this->id . ".pdf"]);
                    }
                });
            }

            // extended_inventory_management - after change quote status
            if ($oimsSetting->extended_inventory_management) {

                // qty decrease
                if ($newQuoteStatus->qty_decrease) {
                    foreach ($this->products_json as $key => $producJson) {
                        $product = \Olabs\Oims\Models\Product::find($producJson["product_id"]);
                        if ($product) {
                            $qty = $producJson["quantity"];
                            $product->quoteProduct($qty, true);
                        }
                    }
                }

                // qty increase back
                if ($newQuoteStatus->qty_increase_back) {
                    // !!! ONLY if have previous status with qty_decrease
                    if (($prevQuoteStatus != null) && ($prevQuoteStatus->qty_decrease)) {
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
     * Find quote for payment gateway or return null
     * 
     * @param type $id
     */
    public static function findQuoteBySlugForPaymentGateway($id) {
        $quote = self::find($id);

        // check if quote have user => user have to be logged in
        if ($quote->user_id) {
            $user = \RainLab\User\Facades\Auth::getUser();

            // check anonymous access
            if ($user == null) {
                return null;
            }

            // check another user
            if ($quote->user_id != $user->id) {
                return null;
            }
        }

        // check disallowed quote statuses
        if ($quote->objectstatus) {
            if ($quote->objectstatus->disallow_for_gateway) {
                return null;
            }
        }

        return $quote;
    }

    public function getQuoteTypeOptions() {

        return [null => Lang::get("olabs.oims::lang.plugin.please_select")] + $this->QUOTE_TYPES;
//        return  ;
    }

    public function getQuoteType($code) {

        if (isset($this->QUOTE_TYPES[$code])) {
            return $this->QUOTE_TYPES[$code];
        }

        return '';
    }

    public function getSupplierNameAttribute($value) {
        $name = '';

        if (isset($this->attributes['user_id']) && $this->attributes['user_id']) {
            $name = $this->supplier->id . ' | ' . $this->supplier->full_name;
        }
        return $name;
    }

    public function getQuoteNameAttribute($value) {
        $name = '';

        if (isset($this->attributes['user_id']) && $this->attributes['user_id']) {
            $name = $this->id . ' | ' . $this->supplier->full_name;
        }
        return $name;
    }

    public function scopeMatchProject($query, $model) {

        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
//        
        if (!$projectId) {
            //check with session value
            $projectId = \Session::get('expenseOnPc_ProjectId', $projectId);
        }
        //if still projectId is null then check with assign projects
        if (!$projectId) {
            $projects = $this->getProjectOptions();
            $projectId = array_keys($projects);
        }


//        if(!is_array($projects))
//        dd($projectId);
        return is_array($projectId) ? $query->whereIn('project_id', $projectId) : $query->where('project_id', $projectId); // ->orderBy('name', 'desc')
    }

    public function scopeMatchExpenseOnPc($query, $model) {

        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
//        
        if (!$projectId) {
            //check with session value
            $projectId = \Session::get('expenseOnPc_ProjectId', $projectId);
        }
        //if still projectId is null then check with assign projects
        if (!$projectId) {
            $projects = $this->getProjectOptions();
            $projectId = array_keys($projects);
        }

        //check for quote type Petty Contract
        $query->where('quote_type', self::QUOTE_TYPE_PETTY_CONTRACT);

        return is_array($projectId) ? $query->whereIn('project_id', $projectId) : $query->where('project_id', $projectId); // ->orderBy('name', 'desc')
    }

    public function scopeMatchPurchase($query, $model) {

        $projectId = (isset($model->project_id)) ? $model->project_id : 0;
//        
        if (!$projectId) {
            //check with session value
            $projectId = \Session::get('purchase_ProjectId', $projectId);
        }
        //if still projectId is null then check with assign projects
        if (!$projectId) {
            $projects = $this->getProjectOptions();
            $projectId = array_keys($projects);
        }

        //check for quote type Petty Contract
        $query->where('quote_type', self::QUOTE_TYPE_MATERIAL);

        return is_array($projectId) ? $query->whereIn('project_id', $projectId) : $query->where('project_id', $projectId); // ->orderBy('name', 'desc')
    }
    
    
    public function filterFields($fields, $context = null)
    {
        //If reference number once entered then make it readonly
        if($fields->reference_number->value != ''){
            $fields->reference_number->readOnly = True;
        }
        
    }

}
