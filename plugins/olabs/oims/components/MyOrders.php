<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;


class MyOrders extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'My Orders',
            'description' => 'Display list of orders'
        ];
    }

    public function defineProperties()
    {
        return [
            'pageNumber' => [
                'title'       => 'URL Page Number',
                'description' => 'URL page number',
                'default'     => '{{ :page }}',
                'type'        => 'string'
            ],          
            'perPage' => [
                'title'       => 'Orders per Page',
                'description' => 'Count of orders per page',
                'default'     => 20,
                'type'        => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'                
            ],   
            'myOrderPage' => [
                'title'       => 'My Order Detail Page',
                'description' => 'My Order Detail Page',
                'type'        => 'dropdown',
                'default'     => 'my-order-detail',
                'group'       => 'Links',
            ],             
        ];
    }
    
    public function getMyOrderPageOptions()
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
        
        // get products
        $orders = $this->loadOrders($user);

        // pagination
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $perPage = $this->property('perPage');
        $page = $this->property('pageNumber');
        $ordersPagination = new \Illuminate\Pagination\LengthAwarePaginator($orders, count($orders), $perPage, $page);
        $ordersPagination->setPath(\Request::url()."/N");
        $this->ordersPagination = $this->page['ordersPagination'] = $ordersPagination;
        
        // jkshopsetting
        $this->page['jkshopSetting'] = \Olabs\Oims\Models\Settings::instance();
    }

    protected function loadOrders($user)
    {
        $orders = \Olabs\Oims\Models\Order::
                where("user_id",$user->id)->
                orderBy("created_at","desc")->
                get();

        /*
         * Add a "url" helper attribute for linking to each post and category
         */
        $orders->each(function($order) {
            $order->setUrl($this->property('myOrderPage'), $this->controller);
        });        

        return $orders;
    }   

}