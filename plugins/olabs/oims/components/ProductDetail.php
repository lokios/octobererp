<?php namespace Olabs\Oims\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use URL;


class ProductDetail extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Product Detail',
            'description' => 'Display detail of product'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'URL Slug',
                'description' => 'URL Slug',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],    
            'brandPage' => [
                'title'       => 'Brand page',
                'description' => 'List of products by brand',
                'type'        => 'dropdown',
                'default'     => 'brands',
                'group'       => 'Links',
            ],           
        ];
    }
    
    public function getBrandPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }    
    
    public function onRun()
    {
        $slug = $this->property('slug');
        $product = \Olabs\Oims\Models\Product::where('slug', $slug)->where("visibility", 1)->first();
        
        if ($product == null) {
            return \Response::make($this->controller->run('404'), 404);
        }
        
        // add featured links
        $featured = $product->featured;
        $featured->each(function($featuredProduct) {
            $featuredProduct->setUrl($this->page->id, $this->controller);
        });         
        // add accessories links
        $accessories = $product->accessories;
        $accessories->each(function($accessoriesProduct) {
            $accessoriesProduct->setUrl($this->page->id, $this->controller);
        });
        
        $this->page['product'] = $product;
        $this->page['featured'] = $featured;
        $this->page['accessories'] = $accessories;
        
        // jkshopsetting
        $this->page['jkshopSetting'] = \Olabs\Oims\Models\Settings::instance();
        
        // brand url
        if ($product->brand != null) {
            $params = [
                'brand' => $product->brand->slug,
            ];
            $product->brand->url = $this->controller->pageUrl($this->property('brandPage'), $params);
        }
        else {
            //$product->brand->url = null;
        }        
        
        // meta info
        if (isset($product)) {
            $this->page->meta_title = $product->meta_title;
            $this->page->meta_description = $product->meta_description;
            $this->page->meta_keywords = $product->meta_keywords;
        }
    }
    
    /**
     * Update price, desc and title by property options
     * 
     * @return array
     */
    public function onChangePropertyOption() {
        $id = post("id");
        $options = post("options");

        $productOptionTitle = "";
        $productDetailDescription = "";
        $optionImages = [];
        
        $product = \Olabs\Oims\Models\Product::find($id);
        $productPropertyOptions = $product->getProductPropertyOptions($options);
        foreach ($productPropertyOptions as $productPropertyOption) {
            // title
            if (($productPropertyOption->pivot["title"]) && ($productPropertyOption->pivot["title"] != "")) {
                if ($productOptionTitle) {
                    $productOptionTitle .= ", ".$productPropertyOption->pivot["title"];
                }
                else {
                    $productOptionTitle = $productPropertyOption->pivot["title"];
                }
            }

            // desc
            if (($productPropertyOption->pivot["description"]) && ($productPropertyOption->pivot["description"] != "")) {
                $productDetailDescription .= $productPropertyOption->pivot["description"];
            }
            
            // image
            if (($productPropertyOption->pivot["image"]) && ($productPropertyOption->pivot["image"] != "")) {
                $optionImages[] = URL::to("storage/app/media".$productPropertyOption->pivot["image"]);
            }
        }        

        
        
        $rtnData = [];
        
        // title
        $rtnData["#product-option-title"] = $productOptionTitle;
        
        // desc
        $rtnData["#product-option-description"] = $productDetailDescription;
        
        // price
        $rtnData["#product-price"] = $product->getFinalPriceFormated($options);
        
        // property images
        $rtnData["product-option-images"] = $optionImages;
        
        // refresh main image
        if (count($optionImages) > 0) {
            $rtnData["product-main-image"] = $optionImages[0];
        }
        else {
            $rtnData["product-main-image"] = $product->getMainImagePath();
        }
        
        return $rtnData;
        
//        return [
//            "#" => "1",
//        ];
        
    }

}