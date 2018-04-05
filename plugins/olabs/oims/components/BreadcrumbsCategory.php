<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;

class BreadcrumbsCategory extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Breadcrumbs for Category',
            'description' => 'Render Breadcrumbs for Categories'
        ];
    }

    public function defineProperties()
    {
        return [
            'category' => [
                'title'       => 'URL Slug Category',
                'description' => 'URL Slug Category',
                'default'     => '{{ :category }}',
                'type'        => 'string'
            ]
        ];
    }
    
    public function onRun()
    {
        // prepair inputs
        $slug = $this->property('category');
        $paramName = $this->paramName('category');
        $category = \Olabs\Oims\Models\Category::where('slug', $slug)->first();
        
        // load parents and add URL
        if ($category != null) {
            $parents = $category->parents()->get();
            foreach ($parents as $parent) {
                $parent->setUrl($this->page->baseFileName, $paramName, $this->controller);
            }
        }
        
        // set to view
        $this->page['category'] = $category;
        $this->page['parents'] = $parents;
    }

}