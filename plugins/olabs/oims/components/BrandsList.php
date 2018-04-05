<?php

namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Olabs\Oims\Models\Brand as BrandModel;

class BrandsList extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Brands List',
            'description' => 'Display list of Brands',
        ];
    }

    public function defineProperties() {
        return [
            'pageNumber' => [
                'title'       => 'URL Page',
                'description' => 'URL Page',
                'default'     => '{{ :page }}',
                'type'        => 'string'
            ],          
            'perPage' => [
                'title'       => 'Brands per page',
                'description' => 'Count of brands per page',
                'default'     => 20,
                'type'        => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'                
            ],
            'orderBy' => [
                'title' => 'Order By',
                'description' => 'Order By',
                'default' => 'title',
                'type' => 'dropdown',
                'options' => [
                    'title' => 'Title',
                    'slug' => 'Slug',
                ]
            ],
            'sort' => [
                'title' => 'Sort',
                'description' => 'Sort ASC or DESC',
                'default' => 'asc',
                'type' => 'dropdown',
                'options' => ['asc' => 'Ascending', 'desc' => 'Descending']
            ],
            'brandPage' => [
                'title' => 'Brand page',
                'description' => 'Brand detail page',
                'type' => 'dropdown',
                'default' => 'brand',
                'group' => 'Links',
            ],
        ];
    }

    public function getBrandPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun() {
        // get brands
        $brands = $this->loadBrands();

        // pagination
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $perPage = $this->property('perPage');
        $page = $this->property('pageNumber');
        $brandsPagination = new \Illuminate\Pagination\LengthAwarePaginator($brands, count($brands), $perPage, $page);
        $brandsPagination->setPath(\Request::url()."/N");
        $this->productsPagination = $this->page['brandsPagination'] = $brandsPagination;        

        // jkshopsetting
        $this->page['jkshopSetting'] = \Olabs\Oims\Models\Settings::instance();
    }

    protected function loadBrands() {
        // All 
        $brands = BrandModel::
                where("active", 1)->
                orderBy($this->property('orderBy'), $this->property('sort'))->
                get();


        /*
         * Add a "url" helper attribute for linking to each post and category
         */
        $brands->each(function($brand) {
            $params = [
                'slug' => $brand->slug,
            ];
            $brand->url = $this->controller->pageUrl($this->property('brandPage'), $params);
        });

        return $brands;
    }

}
