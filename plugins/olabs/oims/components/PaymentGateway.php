<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Omnipay\Omnipay;

class PaymentGateway extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Payment Gateway',
            'description' => 'Payment page with :slug on end and with PaymentGateway component'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'URL Order ID',
                'description' => 'URL Order ID',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
        ];
    }
    
    public function onRun()
    {
        $order = \Olabs\Oims\Models\Order::findOrderBySlugForPaymentGateway($this->param("slug"));
        if ($order == null) { return \Response::make($this->controller->run('404'), 404); }
        
        $this->page["order"] = $order;
        $this->page["jkshopSetting"] = \Olabs\Oims\Models\Settings::instance();
    }
    
    public function onPaymentSubmit() {
        $order = \Olabs\Oims\Models\Order::find($this->param("slug"));
        
        
        // ---------------------------------------------------------------------
        // TRY TO PAY
        // ---------------------------------------------------------------------
        $paid = false;
        
        // create gateway
        $paymentGateway = $order->paymentGateway;
        if ($paymentGateway == null) {
            return [
                "#payment-container" => '<div class="alert alert-error" role="alert"><strong>Order Payment Method Error!</strong></div>'
            ];            
        }
        $gateway = Omnipay::create($paymentGateway->gateway);
        $gateway->initialize($paymentGateway->parameters);
        
        // create credit card
        $cardParams = [
            "firstName" => $order->is_first_name,
            "lastName" => $order->is_last_name,
            "number" => post("number"),
            "expiryMonth" => post("expiryMonth"),
            "expiryYear" => post("expiryYear"),
            "cvv" => post("cvv"),
            
            "issueNumber" => $order->id,
            
            "billingAddress1" => $order->is_address,
            "billingAddress2" => $order->is_address_2,
            "billingCity" => $order->is_city,
            "billingPostcode" => $order->is_postcode,
            "billingState" => $order->is_county,
            "billingCountry" => $order->is_country,
            "billingPhone" => $order->contact_phone,
            
            "shippingAddress1" => $order->ds_address,
            "shippingAddress2" => $order->ds_address_2,
            "shippingCity" => $order->ds_city,
            "shippingPostcode" => $order->ds_postcode,
            "shippingState" => $order->ds_county,
            "shippingCountry" => $order->ds_country,
            "shippingPhone" => $order->contact_phone,

            "email" => $order->contact_email,
//            "company" => "",
        ];
        $card = new \Omnipay\Common\CreditCard($cardParams);
        
        // pay
        $response = $gateway->purchase(array(
            'amount' => ($order->total_price + $order->shipping_price), 
            'currency' => $paymentGateway->gateway_currency, 
            'card' => $card
        ))->send();
        
        $paid_detail = [
            "isSuccessful" => $response->isSuccessful(),
            "isRedirect" => $response->isRedirect(),
            "getTransactionReference" => $response->getTransactionReference(),
            "getMessage" => $response->getMessage(),
        ];
        if ($response->isSuccessful()) {
            $paid = true;
        }
        else {
            // Error save into system events
            $eventLog = new \System\Models\EventLog();
            $data = array();
            $data["name"] = "Payment Gateway Error:".$order->paymentGateway->gateway_title." order_id:".$order->id;
            $data["response"] = $paid_detail;
            $eventLog->message = json_encode($data);
            $eventLog->save();
        }
        // ---------------------------------------------------------------------
        
        
        
        if ($paid) {
            if ($paymentGateway->orderStatusAfter) {
                $order->orderstatus = $paymentGateway->orderStatusAfter;
            }
            $order->paid_date = \Carbon\Carbon::now();
            $order->paid_detail = $paid_detail;
            $order->save();
            
            return [
                "#payment-container" => '<div class="alert alert-success" role="alert"><strong>Payment received!</strong> Many thanks.</div>'
            ];
        }
        else {
            return [
                "#payment-container" => '<div class="alert alert-warning" role="alert"><strong>Sorry!</strong> There was an error processing your payment. Please try again later.</div>'
            ];
        }
    }

}