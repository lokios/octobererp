<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;

class BreadcrumbsProduct extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Breadcrumbs for Product',
            'description' => 'Render Breadcrumbs for Categories'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'URL Slug Product',
                'description' => 'URL Slug for product detail page',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'category' => [
                'title'       => 'URL Slug Category',
                'description' => 'URL Slug for products category page',
                'default'     => '{{ :category }}',
                'type'        => 'string',
                'group'       => 'Links',
            ],
            'categoryPage' => [
                'title'       => 'Products Category page',
                'description' => 'List of products by category',
                'type'        => 'dropdown',
                'default'     => 'products',
                'group'       => 'Links',
            ],
        ];
    }
    
    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function onRun()
    {
        // prepair inputs
        $productSlug = $this->property('slug');
        $product = \Olabs\Oims\Models\Product::where('slug', $productSlug)->first();
        
        // load parents and add URL
        $children = [];
        if ($product != null) {
            $children = $product->categories;
            foreach ($children as $child) {
                $child->setUrl($this->property('categoryPage'), $this->paramName('category'), $this->controller);
            }
        }
        
        // set to view
        $this->page['product'] = $product;
        $this->page['children'] = $children;
    }    

}