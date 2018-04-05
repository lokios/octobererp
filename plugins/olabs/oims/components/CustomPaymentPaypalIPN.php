<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;

class CustomPaymentPaypalIPN extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Custom Payment Paypal IPN',
            'description' => 'Custom payment gateway by the IPN validation'
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
            'paypal_business' => [
                'title'       => 'Paypal Business',
                'description' => 'Your bussines account',
                'type'        => 'string'
            ],
            'paypal_return_url' => [
                'title'       => 'Return URL',
                'description' => 'Use full url where will be your customer redirect after paid "http://www.example.com/paypal-success"',
                'type'        => 'string'
            ],
            'paypal_use_sandbox' => [
                'title'       => 'Use sandbox',
                'description' => 'For testing only!',
                'type'        => 'checkbox'
            ],
        ];
    }
    
    public function onRun()
    {
        $order = \Olabs\Oims\Models\Order::findOrderBySlugForPaymentGateway($this->param("slug"));
        if ($order == null) { return \Response::make($this->controller->run('404'), 404); }
        
        $this->page["order"] = $order;
        
        // paypal details
        $this->page["paypal_business"] = $this->property('paypal_business');
        $this->page["paypal_currency_code"] = $order->paymentGateway->gateway_currency;
        $this->page["paypal_return_url"] = $this->property('paypal_return_url');
        $this->page["paypal_use_sandbox"] = $this->property('paypal_use_sandbox');
    }    

}