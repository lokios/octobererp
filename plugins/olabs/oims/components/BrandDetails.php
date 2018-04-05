<?php

namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Olabs\Oims\Models\Brand as BrandModel;


class BrandDetails extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Brand Details',
            'description' => 'Display details of Brand',
        ];
    }

    public function defineProperties() {
        return [
            'slug' => [
                'title' => 'URL Slug',
                'description' => 'URL Slug',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ],
        ];
    }

    public function getBrandPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun() {
        $slug = $this->property('slug');
        $brand = BrandModel::
                where('slug', $slug)->
                where("active", 1)->
                first();

        $this->page['brand'] = $brand;

        // jkshopsetting
        $this->page['jkshopSetting'] = \Olabs\Oims\Models\Settings::instance();        
       
        // meta info
        if (isset($brand)) {
            $this->page->meta_title = $brand->meta_title;
            $this->page->meta_description = $brand->meta_description;
            $this->page->meta_keywords = $brand->meta_keywords;
        }
    }

}
