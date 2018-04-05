<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;


class MyOrderDetail extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'My Order Detail',
            'description' => 'Display detail of my order'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title'       => 'URL Order ID',
                'description' => 'URL Order ID',
                'default'     => '{{ :id }}',
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
        // user plugin missing
        if (class_exists("\RainLab\User\Models\User") == false) {
            return \Response::make($this->controller->run('404'), 404);
        }
        
        // try to get user
        $user = \RainLab\User\Facades\Auth::getUser();
        if ($user == null) {
            return \Response::make($this->controller->run('404'), 404);
        }
        
        // try toget order
        $order = \Olabs\Oims\Models\Order::where('user_id', $user->id)->find($this->param("id"));
        if ($order == null) {
            return \Response::make($this->controller->run('404'), 404);
        }

        /*
         * Add a "url" helper attribute for linking to each post and category
         */
        foreach ($order->extend_products_json as $extendProductJson) {
            $extendProductJson["product"]->setUrl($this->property('productPage'), $this->controller);
        }

        // jkshopsetting
        $this->page['jkshopSetting'] = \Olabs\Oims\Models\Settings::instance();
        $this->page['order'] = $order;        
    }

}