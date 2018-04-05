<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Redirect;

class CustomPaymentStripeCheckout extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Custom Payment Stripe Checkout',
            'description' => 'Custom payment gateway stripe implementation use one page checkout.'
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
            'stripe_publishable_key' => [
                'title'       => 'Publishable Key',
                'description' => 'For testing you can use: "pk_test_6pRNASCoBOKtIshFeQd4XMUh"',
                'type'        => 'string'
            ],
            'stripe_secret_key' => [
                'title'       => 'Secret Key',
                'description' => 'For testing you can use: "sk_test_BQokikJOvBiI2HlWgH4olfQ2"',
                'type'        => 'string'
            ],
            'stripe_return_url' => [
                'title'       => 'Success URL',
                'description' => 'Use full url where will be your customer redirect after paid "http://www.example.com/paypal-success"',
                'type'        => 'string'
            ],
            
        ];
    }
    
    public function onRun()
    {
        $order = \Olabs\Oims\Models\Order::findOrderBySlugForPaymentGateway($this->param("slug"));
        if ($order == null) { return \Response::make($this->controller->run('404'), 404); }
        
        $this->page["order"] = $order;
        
        // paypal details
        $this->page["stripe_publishable_key"] = $this->property('stripe_publishable_key');
        $this->page["stripe_secret_key"] = $this->property('stripe_secret_key');
        $this->page["stripe_currency_code"] = $order->paymentGateway->gateway_currency;
        $this->page["stripe_return_url"] = $this->property('stripe_return_url');
    }
    
    public function onSubmitPayForm() {
        $stripe = [
          'secret_key'      => $this->property('stripe_secret_key'),
          'publishable_key' => $this->property('stripe_publishable_key')
        ];
        \Stripe\Stripe::setApiKey($stripe['secret_key']);
        
        
        // save IN to events
        $eventLog = new \System\Models\EventLog();
        $data = array();
        $data["name"] = "Stripe Response";
        $data["post"] = post();
        $eventLog->message = json_encode($data);
        $eventLog->save();

        // get order
        $order = \Olabs\Oims\Models\Order::find($this->param("slug"));

        if ($order != null) {
            $token  = post('stripeToken');
            $customer = \Stripe\Customer::create(array(
                'email' => $order->contact_email,
                'card'  => $token
            ));
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount'   => ($order->total_price + $order->shipping_price)*100,
                'currency' => $order->paymentGateway->gateway_currency
            ));

            // check response
            $order->orderstatus = $order->paymentGateway->orderStatusAfter;
            $order->paid_date = \Carbon\Carbon::now();
            $order->paid_detail = $charge;
            $order->save();

            return Redirect::to($this->property('stripe_return_url'));   //Redirect::to("/");
        }        
        
    }
}