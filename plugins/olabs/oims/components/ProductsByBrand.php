<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;


class ProductsByBrand extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Products By Brand',
            'description' => 'Display list of products by Brand'
        ];
    }

    public function defineProperties()
    {
        return [
            'brand' => [
                'title'       => 'URL Slug Brand',
                'description' => 'URL Slug Brand',
                'default'     => '{{ :brand }}',
                'type'        => 'string'
            ],            
            'pageNumber' => [
                'title'       => 'URL Page',
                'description' => 'URL Page',
                'default'     => '{{ :page }}',
                'type'        => 'string'
            ],          
            'perPage' => [
                'title'       => 'Products per page',
                'description' => 'Count of products per page',
                'default'     => 20,
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
        $slug = $this->property('brand');
        $brand = \Olabs\Oims\Models\Brand::where('slug', $slug)->first();
        if ($brand == null) {
            return \Response::make($this->controller->run('404'), 404);
        }
        
        // get products
        $products = $this->loadProducts();

        // pagination
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $perPage = $this->property('perPage');
        $page = $this->property('pageNumber');
        $productsPagination = new \Illuminate\Pagination\LengthAwarePaginator($products, count($products), $perPage, $page);
        $productsPagination->setPath(\Request::url()."/N");
        $this->productsPagination = $this->page['productsPagination'] = $productsPagination;
        
        // jkshopsetting
        $this->page['jkshopSetting'] = \Olabs\Oims\Models\Settings::instance();
        
        // add into page
        $this->page['brand'] = $brand;
        
        // meta info
        if (isset($brand)) {
            $this->page->meta_title = $brand->meta_title;
            $this->page->meta_description = $brand->meta_description;
            $this->page->meta_keywords = $brand->meta_keywords;        
        }
    }

    protected function loadProducts()
    {
        $slug = $this->property('brand');
        $brand = \Olabs\Oims\Models\Brand::where('slug', $slug)->first();
        //var_dump($categories);
        
        $products = \Olabs\Oims\Models\Product::
                where("active",1)->
                where("brand_id",$brand->id)->
                where("visibility", 1)->
                groupBy("id")->
                orderBy($this->property('orderBy'), $this->property('sort'))->
                get();

        //var_dump($products);
        
        /*
         * Add a "url" helper attribute for linking to each post and category
         */
        $products->each(function($product) {
            $product->setUrl($this->property('productPage'), $this->controller);
        });        

        return $products;
    }    

}