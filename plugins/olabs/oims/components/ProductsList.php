<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;


class ProductsList extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Products',
            'description' => 'Display list of products'
        ];
    }

    public function defineProperties()
    {
        return [
            'take' => [
                'title'       => 'Limit of products',
                'description' => 'Take X products only',
                'default'     => '20',
                'type'        => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'                
            ],            
            'orderBy' => [
                'title'       => 'Order By',
                'description' => 'Order By',
                'default'     => 'title',
                'type'        => 'dropdown',
                'options'     => [
                    'title' => 'Title', 
                    'retail_price_with_tax' => 'Price with Tax', 
                    'on_sale' => 'On Sale',
                    'id' => 'ID',
                    'ean_13' => 'EAN 13',
                    'barcode' => 'Barcode',
                    'quantity' => 'Quantity',
                    'slug' => 'Slug',
                    ]
            ],   
            'sort' => [
                'title'       => 'Sort',
                'description' => 'Sort ASC or DESC',
                'default'     => 'asc',
                'type'        => 'dropdown',
                'options'     => ['asc'=>'Ascending', 'desc'=>'Descending']
            ],              
            'onSaleOnly' => [
                'title'       => 'On Sale Only',
                'description' => 'On Sale Only Products',
                'default'     => true,
                'type'        => 'checkbox',
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
        // get products
        $products = $this->loadProducts();

        // pagination
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $productsPagination = new \Illuminate\Pagination\LengthAwarePaginator($products, count($products), $this->property('take'), 1);
        $productsPagination->setPath(\Request::url()."/N");
        $this->productsPagination = $this->page['productsPagination'] = $productsPagination;
        
        // jkshopsetting
        $this->page['jkshopSetting'] = \Olabs\Oims\Models\Settings::instance();
    }

    protected function loadProducts()
    {
        if ($this->property('onSaleOnly')) {
            $products = \Olabs\Oims\Models\Product::
                    where("active",1)->
                    where("on_sale",1)->
                    where("visibility", 1)->
                    take($this->property('take'))->
                    orderBy($this->property('orderBy'), $this->property('sort'))->
                    get();
            
        }
        else {
            $products = \Olabs\Oims\Models\Product::
                    where("active",1)->
                    where("visibility", 1)->
                    take($this->property('take'))->
                    orderBy($this->property('orderBy'), $this->property('sort'))->
                    get();
        }
        
        /*
         * Add a "url" helper attribute for linking to each post and category
         */
        $products->each(function($product) {
            $product->setUrl($this->property('productPage'), $this->controller);
        });        

        return $products;
    }    

}