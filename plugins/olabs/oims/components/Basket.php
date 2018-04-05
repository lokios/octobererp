<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Session;
use Cms\Classes\Page;
use Redirect;


class Basket extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Basket',
            'description' => 'All operation from add to basket to finish order'
        ];
    }

    public function defineProperties()
    {
        return [
            'idElementTotalCartPrice' => [
                'title'       => 'ID Element Total Cart Price',
                'description' => 'This Element will be refresh after ajax call - add product, etc..  (start with #)',
                'default'     => '#jkshop-total-basket',
                'type'        => 'string'
            ],
            'idElementWrapperBasketComponent' => [
                'title'       => 'ID Element Wrapper Basket Component',
                'description' => 'This Element will be refresh after ajax call - change quantity, etc..  (start with #)',
                'default'     => '#jkshop-basket-component-wrapper',
                'type'        => 'string'
            ],
            'productPage' => [
                'title'       => 'Product page',
                'description' => 'Product detail page',
                'type'        => 'dropdown',
                'default'     => 'product',
                'group'       => 'Links',
            ],
        ];
    }
    
    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }       
    
    public function onRun()
    {
        $this->onRunBasket();
        $this->page["basket"] = $this->getSessionBasket();
        $this->page["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
    }
    
    public function onRunBasket()
    {
        $data = [];
        $data["basket"] = $this->getSessionBasket();
        $data["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
        
        return [
            $this->property("idElementWrapperBasketComponent") => $this->renderPartial('::basket-0', $data)
        ]; 
    }    
    
    public function onRunBasketShippingPayment()
    {
        $data = [];
        $data["basket"] = $this->getSessionBasket();
        $data["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
        
        return [
            $this->property("idElementWrapperBasketComponent") => $this->renderPartial('::basket-1-shipping-payment', $data)
        ];         
    }    
    
    public function onRunBasketAddress() {
        // update basket
        $shipping_id = post("shipping_id", null);
        if ($shipping_id != null) {
            $basket = $this->getSessionBasket();
            $basket["shipping_id"] = post("shipping_id");
            $basket["payment_method_id"] = post("payment_method_id");
            $basket = $this->setSessionBasket($basket);
        }
        
        // render
        $data = [];
        $data["basket"] = $this->getSessionBasket();
        $data["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
        
        return [
            $this->property("idElementWrapperBasketComponent") => $this->renderPartial('@basket-2-address', $data)
        ];         
    }
    
    public function onRunBasketSummary() {
        // update basket
        $tstPost = post("ds_first_name", null);
        if ($tstPost != null) {
            $basket = $this->getSessionBasket();
            $basket["ds_first_name"] = post("ds_first_name");
            $basket["ds_last_name"] = post("ds_last_name");
            $basket["ds_address"] = post("ds_address");
            $basket["ds_address_2"] = post("ds_address_2");
            $basket["ds_postcode"] = post("ds_postcode");
            $basket["ds_city"] = post("ds_city");
            $basket["ds_county"] = post("ds_county");
            $basket["ds_country"] = post("ds_country");
            
            $basket["is_first_name"] = post("is_first_name");
            $basket["is_last_name"] = post("is_last_name");
            $basket["is_address"] = post("is_address");
            $basket["is_address_2"] = post("is_address_2");
            $basket["is_postcode"] = post("is_postcode");
            $basket["is_city"] = post("is_city");
            $basket["is_county"] = post("is_county");
            $basket["is_country"] = post("is_country");            
            
            $basket["contact_email"] = post("contact_email");
            $basket["contact_phone"] = post("contact_phone");
            $basket["note"] = post("note");

            $basket = $this->setSessionBasket($basket);
        }
        
        // render
        $data = [];
        $data["basket"] = $this->getSessionBasket();
        $data["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
        
        return [
            $this->property("idElementWrapperBasketComponent") => $this->renderPartial('@basket-3-summary', $data)
        ];          
    }
    
    /**
     * Create order, sent email, redirect to paypall, etc..
     * 
     */
    public function onCompleteOrder() {
        
        $jkshopSetting = \Olabs\Oims\Models\Settings::instance();
        
        // create order
        $basket = $this->getSessionBasket();
        $order = new \Olabs\Oims\Models\Order();
        $order->createFromBasket($basket);
        $order->save();
        $order = \Olabs\Oims\Models\Order::find($order->id);
        
        // clear basket
        Session::forget('jkshop-basket');
        
        // Redirect to PaymentGateway
        if ($order->paymentGateway) {
            $url = $this->controller->pageUrl($order->paymentGateway->payment_page, [ 'slug' => $order->id] );
            return Redirect::to($url);
        }
        else {
            return Redirect::to("404");
        }
    } 

    /**
     * Helper Ajax layer form getSessionBasket
     * 
     * @return type
     */
    public function onGetSessionBasket() {

        return [
            "basket" => $this->getSessionBasket()
        ];
    }

    /**
     * Get Basket from session
     * 
     * @return basket data as array
     */
    public function getSessionBasket() {
        
        $jkshopSetting = \Olabs\Oims\Models\Settings::instance();
        
        $defaultEmptyBasket = [
            "products" => []
        ];
        
        $basketJson = Session::get('jkshop-basket', json_encode($defaultEmptyBasket));
        $basket = json_decode($basketJson, true);
        
        
        // ---------------------------------------------------------------------
        // Coupon - check main valid and get model
        // ---------------------------------------------------------------------
        if (isset($basket["coupon_code"])) {
            // check if is coupon valid for this basket
            $couponIsValid = false;
            $coupon = \Olabs\Oims\Models\Coupon::where("code", $basket["coupon_code"])->first();
            $outWrongCode = 0;
            if ($coupon != null) {
                $couponIsValid = $coupon->isValid($outWrongCode);
            }

            if ($couponIsValid) {
                // if yes compute sale
                $basket["coupon_wrong_code"] = $outWrongCode;
                $basket["coupon_model"] = $coupon;
            }
            else {
                // if no remove it and setup wrong to 1
                $basket["coupon_wrong_code"] = $outWrongCode;
                $basket["coupon_code"] = "";
                $basket["coupon_model"] = null;
            }
        }
        else {
            $basket["coupon_wrong_code"] = 0;
            $basket["coupon_code"] = "";
            $basket["coupon_model"] = null;
        }
        // ---------------------------------------------------------------------        
        
        // ---------------------------------------------------------------------
        // get all products obj
        // - check qty vs stock
        // ---------------------------------------------------------------------
        $wTotalPrice = 0;
        $basket["additional_shipping_fees"] = 0;
        foreach ($basket["products"] as $id => $productJson) {
            $product = \Olabs\Oims\Models\Product::find($productJson["product_id"]);
            $product->setUrl($this->property('productPage'), $this->controller);
            
            // check qty vs stoch
            $basket["products"][$id]["basket_quantity"] = $product->orderProduct($basket["products"][$id]["basket_quantity"], false);
            
            $basket["products"][$id]["product"] = $product;
            
            // get Final Price
            $options_data = json_decode($basket["products"][$id]["options_data"], true);
            $outCurrentDiscount = 0;
            $finalPrice = $product->getFinalPrice($options_data, $basket["coupon_model"], $outCurrentDiscount);
            
            // Final Tax
            if ($product->tax != null) {
                $productFinalTax = $product->tax->getTaxFromPriceWithTax($finalPrice);
            }
            else {
                $productFinalTax = 0;
            }
            
            
            // total price 1x
            $basket["products"][$id]["price_without_tax"] = ($finalPrice - $productFinalTax);
            $basket["products"][$id]["tax"] =  $productFinalTax;
            $basket["products"][$id]["price"] = $finalPrice;
            $basket["products"][$id]["current_discount"] = $outCurrentDiscount;
            
            // total price (price * qty)
            $basket["products"][$id]["total_price_without_tax"] = ($finalPrice - $productFinalTax) * $basket["products"][$id]["basket_quantity"];
            $basket["products"][$id]["total_tax"] =  $productFinalTax * $basket["products"][$id]["basket_quantity"];
            $basket["products"][$id]["total_price"] = $finalPrice * $basket["products"][$id]["basket_quantity"];
            $wTotalPrice += $basket["products"][$id]["total_price"];
            
            if ($product->additional_shipping_fees > 0)  {
                $basket["additional_shipping_fees"] += $product->additional_shipping_fees;
            }
        }
        
        // ---------------------------------------------------------------------
        
        // ---------------------------------------------------------------------
        // Coupon - global coupon only
        // ---------------------------------------------------------------------
        $basket["total_global_discount"] = 0;
        if ($basket["coupon_model"] != null) {
            $outWrongCode = 0;
            if ($basket["coupon_model"]->isValidGlobal($wTotalPrice, $outWrongCode)) {
                // global coupon change final price
                $basket["total_global_discount"] = $basket["coupon_model"]->getFinalDiscount($wTotalPrice);
            }
            $basket["coupon_wrong_code"] = $outWrongCode;
        }
        // ---------------------------------------------------------------------        

        // ---------------------------------------------------------------------
        // re-compute all total values, max values
        // ---------------------------------------------------------------------
        $basket["total_price_without_tax"] = 0;
        $basket["total_tax"] = 0;
        $basket["total_price"] = 0;
        $basket["total_weight"] = 0;
        
        $basket["max_product_width"] = 0;
        $basket["max_product_height"] = 0;
        $basket["max_product_depth"] = 0;
        
        foreach ($basket["products"] as $id => $productJson) {
            $basket["total_price_without_tax"] += $productJson["total_price_without_tax"];
            $basket["total_tax"] += $productJson["total_tax"];
            $basket["total_price"] += $productJson["total_price"];
            
            $basket["total_weight"] += $productJson["product"]->package_weight;
            
            if ($productJson["product"]->package_width > $basket["max_product_width"]) { $basket["max_product_width"] = $productJson["product"]->package_width; }
            if ($productJson["product"]->package_height > $basket["max_product_height"]) { $basket["max_product_height"] = $productJson["product"]->package_height; }
            if ($productJson["product"]->package_depth > $basket["max_product_depth"]) { $basket["max_product_depth"] = $productJson["product"]->package_depth; }
        }
        
        // use global discnount
        if (($basket["total_global_discount"] > 0) && ($basket["total_price"] > 0)) {
            $basket["total_global_discount"] = round($basket["total_global_discount"],2);
            $wPertangeChange = (($basket["total_price"]-$basket["total_global_discount"])/$basket["total_price"]);
            $basket["total_price"] -= $basket["total_global_discount"];
            $basket["total_tax"] *= $wPertangeChange;
            $basket["total_price_without_tax"] *= $wPertangeChange;
        }
        
        // round 2 places
        $basket["total_price_without_tax"] = round($basket["total_price_without_tax"], 2);
        $basket["total_tax"] = round($basket["total_tax"], 2);
        $basket["total_price"] = round($basket["total_price"], 2);
        
        // add formated price
        $basket["total_price_without_tax_formatted"] = $jkshopSetting->getPriceFormatted($basket["total_price_without_tax"]);
        $basket["total_tax_formatted"] = $jkshopSetting->getPriceFormatted($basket["total_tax"]);
        $basket["total_price_formatted"] = $jkshopSetting->getPriceFormatted($basket["total_price"]);
        // ---------------------------------------------------------------------

        
        // ---------------------------------------------------------------------
        // Shipping
        // ---------------------------------------------------------------------
        $shipping_options = \Olabs\Oims\Models\Carrier::where("active",1)->get();
        // filter for this order
        foreach ($shipping_options as $key => $shipping) {
            if ($shipping->isAvaliableForThisOrder($basket) == false ) {
                unset($shipping_options[$key]);
            }
        }
        $basket["shipping_options"] = $shipping_options;
        
        if (isset($basket["shipping_id"])) {
            $basket["shipping"] = \Olabs\Oims\Models\Carrier::find($basket["shipping_id"]);
            $shippingCurrentPrice = $basket["shipping"]->getCurrentPrice($basket);
            $shippingCurrentPriceWithTax = $basket["shipping"]->getCurrentPriceWithTax($basket);
            $shippingCurrentTax = ($shippingCurrentPriceWithTax-$shippingCurrentPrice);
            
            // round 2 places
            $shippingCurrentPrice = round($shippingCurrentPrice, 2);
            $shippingCurrentPriceWithTax = round($shippingCurrentPriceWithTax, 2);
            $shippingCurrentTax = round($shippingCurrentTax, 2);            
            
            $basket["shipping_price_without_tax"] = $shippingCurrentPrice;
            $basket["shipping_tax"] = $shippingCurrentTax;
            $basket["shipping_price"] = $shippingCurrentPriceWithTax;            
            
            $basket["total_price_without_tax_with_shipping"] = $basket["total_price_without_tax"] + $shippingCurrentPrice;
            $basket["total_tax_with_shipping"] = $basket["total_tax"] + $shippingCurrentTax;
            $basket["total_price_with_shipping"] = $basket["total_price"] + $shippingCurrentPriceWithTax;
            
            // add formated price
            $basket["total_price_without_tax_with_shipping_formatted"] = $jkshopSetting->getPriceFormatted($basket["total_price_without_tax_with_shipping"]);
            $basket["total_tax_with_shipping_formatted"] = $jkshopSetting->getPriceFormatted($basket["total_tax_with_shipping"]);
            $basket["total_price_with_shipping_formatted"] = $jkshopSetting->getPriceFormatted($basket["total_price_with_shipping"]);
        }
        // ---------------------------------------------------------------------
        
        // ---------------------------------------------------------------------
        // Payment method
        // ---------------------------------------------------------------------
        //$order = new \Olabs\Oims\Models\Order();
        //$basket["payment_method_options"] = $order->getPaymentMethodOptions(true);
        $basket["payment_method_options"] = \Olabs\Oims\Models\PaymentGateway::where("active",1)->lists("gateway_title","id");
        
        if (isset($basket["payment_method_id"])) {
            //$basket["payment_method"] = $order->getPaymentMethodOptions()[$basket["payment_method_id"]];
            $basket["payment_method"] = array_get($basket["payment_method_options"], $basket["payment_method_id"]);
        }
        // ---------------------------------------------------------------------
        
        
        // ---------------------------------------------------------------------
        // User - pre fill delivery, billing, contact information
        // ---------------------------------------------------------------------
        if ((!isset($basket["ds_first_name"])) && (class_exists("\RainLab\User\Models\User"))) {
            $user = \RainLab\User\Facades\Auth::getUser();
            if (isset($user)) {
                $basket["ds_first_name"] = $user->jkshop_ds_first_name;
                $basket["ds_last_name"] = $user->jkshop_ds_last_name;
                $basket["ds_address"] = $user->jkshop_ds_address;
                $basket["ds_address_2"] = $user->jkshop_ds_address_2;
                $basket["ds_postcode"] = $user->jkshop_ds_postcode;
                $basket["ds_city"] = $user->jkshop_ds_city;
                $basket["ds_county"] = $user->jkshop_ds_county;
                $basket["ds_country"] = $user->jkshop_ds_country;

                $basket["is_first_name"] = $user->jkshop_is_first_name;
                $basket["is_last_name"] = $user->jkshop_is_last_name;
                $basket["is_address"] = $user->jkshop_is_address;
                $basket["is_address_2"] = $user->jkshop_is_address_2;
                $basket["is_postcode"] = $user->jkshop_is_postcode;
                $basket["is_city"] = $user->jkshop_is_city;
                $basket["is_county"] = $user->jkshop_is_county;
                $basket["is_country"] = $user->jkshop_is_country;            

                $basket["contact_email"] = $user->jkshop_contact_email;
                $basket["contact_phone"] = $user->jkshop_contact_phone;
            }
        }
        // ---------------------------------------------------------------------        
        
        return $basket;
    }
    
    
    /**
     * Save basket to session
     * 
     * @param type $basket
     * @return getSessionBasket()
     */
    public function setSessionBasket($basket) {
        $basketJson = json_encode($basket);
        Session::put('jkshop-basket', $basketJson);
        
        return $this->getSessionBasket();
    }
    
    /**
     * Ajax call - add to basket
     * 
     */
    public function onAddToBasket() {
        $basket = $this->getSessionBasket();
        $id = input('id');
        $product = \Olabs\Oims\Models\Product::where("active",1)->where("available_for_order",1)->find($id);
        
        // create full key for product in basket - id + options
        $fullKeyProduct = md5(json_encode(input()));
        
        
        // minimal order
        $qtyOperation = 1;
        if ($product->minimum_quantity > 1) {
            $qtyOperation = $qtyOperation * $product->minimum_quantity;
        }
        
        if (isset($product)) {
            if (array_key_exists($fullKeyProduct, $basket["products"])) {
                // add quantity
                $basket["products"][$fullKeyProduct]["basket_quantity"] = $basket["products"][$fullKeyProduct]["basket_quantity"] + $qtyOperation;
            }
            else {
                // create options info text
                $optionsText = "";
                if (input('options')!=null) {
                    foreach (input('options') as $key => $value) {

                        $valueString = $value;
                        if (is_array($value)) {
                           $valueString = join(", ", $value);
                        }

                        $property = \Olabs\Oims\Models\Property::find($key);
                        if ($property!=null) {
                            
                            // empty no
                            if ($valueString != "") {
                                if ($optionsText != "") {
                                    $optionsText .= " | ";
                                }
                                $optionsText .= $property->title.": ".$valueString;
                            }
                        }
                    }
                }
                
                // add to basket
                $basket["products"][$fullKeyProduct] = [
                    "product_id" => $product->id,
                    "basket_quantity" => $qtyOperation,
                    "options_data" => json_encode(input('options')),
                    "options_text" => $optionsText,
                ];
            }

            $basket = $this->setSessionBasket($basket);
        }
        
        
        return [
            $this->property("idElementTotalCartPrice") => $basket["total_price_formatted"]
        ];
    }
    

    /**
     * +-1 Quantity on basket product
     * 
     * @return type
     */
    public function onBasketProductChangeQunatity() {
        $basket = $this->getSessionBasket();
        $id = input('id');
        $key = input('key'); // full key - id + properties
        $qtyOperation = input('qty_operation');
        
        $product = \Olabs\Oims\Models\Product::find($id);
        
        if ($product->minimum_quantity > 1) {
            $qtyOperation = $qtyOperation * $product->minimum_quantity;
        }
        
        if (array_key_exists($key, $basket["products"])) {
            if ($qtyOperation > 0) {
                // plus
                $basket["products"][$key]["basket_quantity"] += $qtyOperation;
            }
            else {
                // minus
                $basket["products"][$key]["basket_quantity"] += $qtyOperation;
                if ($basket["products"][$key]["basket_quantity"] <= 0) {
                    unset($basket["products"][$key]);
                }
            }
        }
        $basket = $this->setSessionBasket($basket);
        
        $data = array();
        $data["basket"] = $basket;
        $data["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
       
        return [
            $this->property("idElementWrapperBasketComponent") => $this->renderPartial('::basket-0', $data),
            $this->property("idElementTotalCartPrice") => $basket["total_price_formatted"]
        ];        
        
    }
    
    
    /**
     * Add coupon into basket
     * 
     */
    public function onAddCouponCode() {
        // update basket
        $coupon_code = post("coupon_code", null);
        if ($coupon_code != null) {
            $basket = $this->getSessionBasket();
            $basket["coupon_code"] = $coupon_code;
            $basket = $this->setSessionBasket($basket);
        }
        
        $data = [];
        $data["basket"] = $this->getSessionBasket();
        $data["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
        
        return [
            $this->property("idElementWrapperBasketComponent") => $this->renderPartial('::basket-0', $data)
        ];         
    }

}