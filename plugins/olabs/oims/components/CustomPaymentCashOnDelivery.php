<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;

class CustomPaymentCashOnDelivery extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Custom Payment Cash On Delivery',
            'description' => 'Custom payment component cash on delivery'
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
    }    

}