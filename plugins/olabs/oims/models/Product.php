<?php namespace Olabs\Oims\Models;

use Model;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;
use Lang;
use Kocholes\BarcodeGenerator\Classes\BarcodeManager;

/**
 * Product Model
 */
class Product extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_products';
    
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    
    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];
    
    public $rules = [
        'title' => 'required|between:2,255',
        'slug' => [
//            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_oims_products',
        ],        
        'ean_13'   => 'numeric|ean13',
//        'default_category' => 'required',
        'retail_price_with_tax' => 'numeric|required',
        
    ];    
    public $customMessages = [
        'ean13' => 'EAN 13 format error'
    ];
    
    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'title', 
        'short_description', 
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];
    
    
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'slug',
        'ean_13',
        'barcode',
        'active',
        'on_sale',
//        'unit',

        'visibility',
        'available_for_order',
        'show_price',
        'condition',

        'short_description',
        'description',

        'brand',

        'pre_tax_wholesale_price',
        'pre_tax_retail_price',
        'tax',
        'retail_price_with_tax',


        'meta_title',
        'meta_keywords',
        'meta_description',            

        'default_category',

        // Shipping
        'package_width',
        'package_height',
        'package_depth',
        'package_weight',
        'additional_shipping_fees',

        // Quantities
        'quantity',
        'when_out_of_stock',
        'minimum_quantity',
        'availability_date',

        'customization',   
        
        'accessories',
        'featured',
        'categories',
        
        'individual_prices',
    ];
    
    protected $jsonable = ['customization'];
    
    protected $dates = ['availability_date'];


    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'individual_prices' => [
            'Olabs\Oims\Models\ProductUserPrice',
            'delete' => true,
        ]        
    ];
    public $belongsTo = [
        'tax' => [
            'Olabs\Oims\Models\Tax', 
            'key' => 'tax_id'
        ],
        'brand' => [
            'Olabs\Oims\Models\Brand', 
            'key' => 'brand_id'
        ],
        'default_category' => [
            'Olabs\Oims\Models\Category', 
            'key' => 'default_category_id'
        ],
        'unit_code' => [
            'Olabs\Oims\Models\Unit', 
            'key' => 'unit'
        ],
    ];
    public $belongsToMany = [
        'accessories' => [
            'Olabs\Oims\Models\Product',
            'table'    => 'olabs_oims_products_accessories',
            'key'      => 'product_id',
            'otherKey' => 'accessory_id'
        ],
        'featured' => [
            'Olabs\Oims\Models\Product',
            'table'    => 'olabs_oims_products_featured',
            'key'      => 'product_id',
            'otherKey' => 'featured_id'
        ],   
        'categories' => [
            'Olabs\Oims\Models\Category',
            'table'    => 'olabs_oims_products_categories',
            'key'      => 'product_id',
            'otherKey' => 'category_id'
        ],
        'properties' => [
            'Olabs\Oims\Models\Property',
            'table'    => 'olabs_oims_products_properties',
            'key'      => 'product_id',
            'otherKey' => 'property_id'
        ],
        'propertyOptions' => [
            'Olabs\Oims\Models\PropertyOption',
            'table'    => 'olabs_oims_products_options',
            'key'      => 'product_id',
            'otherKey' => 'option_id',
            'pivot' => ['title', 'description', 'price_difference_with_tax', 'image'],
            'pivotModel' => 'Olabs\Oims\Models\ProductPropertyOptionPivot',            
        ],        
    ];
  
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'images' => 'System\Models\File',
        'attachments' => 'System\Models\File',
    ];

    /*
     * Before save model
     * 
     */
    public function beforeSave() {
        
        // url is help property - only for run
        unset($this->url);
        // Force creation of slug
        if (empty($this->slug)) {
            unset($this->slug);
            $this->setSluggedValue('slug', 'name');
        }
        
        if(empty($this->quantity)){
            $this->quantity = 0;
        }
        
        if(empty($this->minimum_quantity)){
            $this->minimum_quantity = 0;
        }
        
        if(empty($this->retail_price_with_tax)){
            $this->retail_price_with_tax = 0;
        }
        
        if(empty($this->active)){
            $this->active = 1;
        }
    }

    
    public static function getMenuTypeInfo($type)
    {
        $result = [
            'dynamicItems' => true
        ];
        
        
        // ------------------------------------------------------------------
        // Select page with components categories
        // ------------------------------------------------------------------
        $theme = Theme::getActiveTheme();

        $pages = CmsPage::listInTheme($theme, true);
        $cmsPages = [];
        foreach ($pages as $page) {
//            if (!$page->hasComponent('blogPosts')) {
//                continue;
//            }
//
//            /*
//             * Component must use a category filter with a routing parameter
//             * eg: categoryFilter = "{{ :somevalue }}"
//             */
//            $properties = $page->getComponentProperties('blogPosts');
//            if (!isset($properties['categoryFilter']) || !preg_match('/{{\s*:/', $properties['categoryFilter'])) {
//                continue;
//            }
//
            $cmsPages[] = $page;
        }

        $result['cmsPages'] = $cmsPages;        
        // ------------------------------------------------------------------
        
        
        // dynamicItems only
        return $result;
    }
    
    public static function resolveMenuItem($item, $url, $theme)
    {
        $result['items'] = array();
        
        // --------------------------------------------------------------------
        // All 
        $products = \Olabs\Oims\Models\Product::where("active",1)->orderBy("title", "asc")->get();

        $items = array();
        foreach ($products as $product) {
            
            // create URL
            if ($item->cmsPage) {
                $urlPage = CmsPage::url($item->cmsPage, ["slug" => $product->slug]);
            } else {
                $urlPage = URL::to("/product/".$product->slug);
            }        
            
            $items[] = [
                'url' => $urlPage,
                'isActive' => ($url == $urlPage),
                'title' => $product->title,
                'mtime' => $product->updated_at,
            ];              
        }
        $result['items'] = $items;
        // --------------------------------------------------------------------

        return $result;   
    }  
    
    
    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }
    
    
    /**
     * Get Final Price
     * 
     * @param type $inPropertyOptions - property options - use for price differences
     * @return type
     */
    public function getFinalPrice($inPropertyOptions = [], $coupon = null, &$outCurrentDiscount = 0) {
        $price = $this->retail_price_with_tax;
        $indPrice = null;
        $saleOnCategoryPrice = null;
        
        // property options - price differences
        $productPropertyOptions = $this->getProductPropertyOptions($inPropertyOptions);
        foreach ($productPropertyOptions as $productPropertyOption) {
            // price
            if (($productPropertyOption->pivot["price_difference_with_tax"]) && ($productPropertyOption->pivot["price_difference_with_tax"] != "")) {
                $price = $price + $productPropertyOption->pivot["price_difference_with_tax"];
            }
        }
        $standardPrice = $price;
        
        
        
        if (class_exists("\RainLab\User\Models\User")) {
            $user = \RainLab\User\Facades\Auth::getUser();
            if (isset($user)) {
                // compute sale on category
                $categoryUserSales = CategoryUserSale::whereIn("category_id",$this->categories()->lists("id", "id"))->where("user_id", $user->id)->orderBy("sale", "desc")->first();
                if (isset($categoryUserSales)) {
                    $saleOnCategoryPrice = $this->retail_price_with_tax / 100 * (100 - $categoryUserSales->sale);
                }
                
                // compute individual price
                $indPriceObj = $this->individual_prices()->where("user_id", $user->id)->orderBy("price", "asc")->first();
                if (isset($indPriceObj)) {
                    $indPrice = $indPriceObj->price;
                }
            }
        }
        
        // use individual price?
        if (isset($indPrice)) {
            if ($price > $indPrice) { $price = $indPrice; }
        }
        
        // use sale On Category Price?
        if (isset($saleOnCategoryPrice)) {
            if ($price > $saleOnCategoryPrice) { $price = $saleOnCategoryPrice; }
        }

        
        // coupon sale
        if ($coupon!= null) {
            if ($coupon->isValidForCurrentProduct($this)) {
                $price = $price - $coupon->getFinalDiscount($price);
            }
        }
        
        
        // min 0
        if ($price < 0) {
            $price = 0;
        }
        
        // current dicsount
        $outCurrentDiscount = $standardPrice - $price; 
        
        return $price;
    }
    

    /**
     * Helper function: by the property options return active product propertry options with pivot data
     * - helper for price diferences, etc..
     * 
     * @param type $inPropertyOptions - array from post
     * @return array
     */
    public function getProductPropertyOptions($inPropertyOptions) {
        
        $productPropertyOptions = [];
        
        if (!$inPropertyOptions) { return $productPropertyOptions; }
        if (is_array($inPropertyOptions) == false) { return $productPropertyOptions; }
        
        foreach ($inPropertyOptions as $property_id => $option_title) {
            $property = \Olabs\Oims\Models\Property::find($property_id);
            // only select box + select multi
            if (($property->type != 1) && ($property->type != 2)) { continue; }
            
            // prepair options (select have one, multi select have many)
            $options = [];
            if (is_array($option_title)) {
                foreach ($option_title as $option_title_item) {
                    $options[] = \Olabs\Oims\Models\PropertyOption::where("property_id", $property_id)->where("title",$option_title_item)->first();    
                }
            }
            else {
                $options[] = \Olabs\Oims\Models\PropertyOption::where("property_id", $property_id)->where("title",$option_title)->first();
            }
            
            // get option / options
            foreach ($options as $option) {

                // get product option with pivot data
                $productOption = $this->propertyOptions()->find($option->id);
                if ($productOption) {
                    $productPropertyOptions[] = $productOption;
                }
            }
        }
        
        
        return $productPropertyOptions;
    }
    

    /**
     * Get final price formated by settings
     * 
     * @param type $inPropertyOptions - property options - use for price differences
     * @return type
     */
    public function getFinalPriceFormated($inPropertyOptions = []) {
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
        $price = $this->getFinalPrice($inPropertyOptions);
        
        $fPrice = $oimsSetting->getPriceFormatted($price);
        return $fPrice;
    }
    
    /**
     * Check if is product allow to order
     * 
     * @return boolean
     */
    public function isAllowOrder() {
        $qtyAllow = false;
        
        // check qty
        if ($this->quantity >= $this->minimum_quantity) {
            $qtyAllow = true;
        }
        else {
            if ($this->when_out_of_stock == 1) {
                $qtyAllow = true;
            }
        }
        
        // check all
        if (($qtyAllow) & ($this->active) & ($this->available_for_order)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Get label for dropdown condition
     * 
     * @return string
     */
    public function getConditionLabel() {
        switch ($this->condition) {
            case 0:
                // New is default - not show
                //return Lang::get("olabs.oims::lang.products.condition_0");
                return "";
            case 1:
                return Lang::get("olabs.oims::lang.products.condition_1");
            case 2:
                return Lang::get("olabs.oims::lang.products.condition_2");
            default:
                return "";
        }
    }
    
    
    /**
     * Check stock, update stock and return real qty for order
     * 
     * @param type $qty
     * @param type $updateRealStock = false
     * @return type
     */
    public function orderProduct($qty, $updateRealStock = false) {
        
        $stockQuantity = $this->quantity;
        
        if ($stockQuantity >= $qty) {
            // stock is ok
            $stockQuantity -= $qty;
        }
        else {
            // stock is lower
            if ($this->when_out_of_stock == 1) {
                // allow order with 0 stock
                $stockQuantity = 0;
                $this->save();
                return $qty;
            }
            elseif ($stockQuantity > 0) {
                // allow max when i have
                $qty = ((int)($stockQuantity / $this->minimum_quantity)) * $this->minimum_quantity;
                $stockQuantity = $stockQuantity - $qty;
            }
            else {
                $qty = 0;
            }
        }
        
        if ($updateRealStock) {
            $this->quantity = $stockQuantity;
            $this->save();
        }
        
        return $qty;
    }
    
    /**
     * Return Product Back
     * 
     * @param type $qty
     * @param type $updateRealStock
     */
    public function returnProductBack($qty, $updateRealStock = false) {
        $this->quantity += $qty;
        
        if ($updateRealStock) {
            $this->save();
        }
        
        return $this->quantity;
    }
    
    /**
     * Get full properties (general + advanced)
     * 
     * @return array
     */
    public function getFullProperties() {
        $properties = $this->properties;
        
        foreach ($this->propertyOptions as $propertyOption) {
            // check advanced properties
            if ($this->properties->contains($propertyOption->property) == false) {
                // add property with one option
                $properties[$propertyOption->property->id] = $propertyOption->property;
            }
        }
        
        return $properties;
    }

    /**
     * Get main image
     * 
     * @return type
     */
    public function getMainImage() {
        if (count($this->images) > 0 ) {
            return $this->images[0];
        }
        else {
            $oimsSetting = \Olabs\Oims\Models\Settings::instance();
            if ($oimsSetting->productDefaultImage != null) {
                return $oimsSetting->productDefaultImage;
            }
        }
        
        return null;
    }
    
    /**
     * Get main image path
     * 
     * @return string
     */
    public function getMainImagePath() {
        $mainImage = $this->getMainImage();
        if ($mainImage != null) {
            return $mainImage->path;
        }
        else {
            return "";
        }
    }
    
    /*
     * https://octobercms.com/plugin/kocholes-barcodegenerator
     * $format => HTML, SVG, PNG
     * $params => [
     *  width : 2,
     *  height : 30,
     *  color : black,
     *  type : Barcode types =>
     *  'C39' => 'CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9',
        'C39+' => 'CODE 39 with checksum',
        'C39E' => 'CODE 39 Extended',
        'C39E+' => 'CODE 39 Extended with checksum',
        'C93' => 'CODE 93 - USS-93',
        'S25' => '(S25) Standard 2 of 5',
        'S25+' => '(S25) Standard 2 of 5 with checksum',
        'I25' => '(I25) Interleaved 2 of 5',
        'I25+' => '(I25) Interleaved 2 of 5 with checksum',
        'C128' => 'CODE 128',
        'C128A' => 'CODE 128 A',
        'C128B' => 'CODE 128 B',
        'C128C' => 'CODE 128 C',
        'EAN2' => '(EAN 2) 2-Digits UPC-Based Extention',
        'EAN5' => '(EAN 5) 5-Digits UPC-Based Extention',
        'EAN8' => 'EAN 8',
        'EAN13' => 'EAN 13',
        'UPCA' => 'UPC-A',
        'UPCE' => 'UPC-E',
        'MSI' => 'MSI (Variation of Plessey code)',
        'MSI+' => 'MSI with checksum (modulo 11)',
        'POSTNET' => 'POSTNET',
        'PLANET' => 'PLANET',
        'RMS4CC' => '(RMS4CC) Royal Mail 4-state Customer Code - (CBC) Customer Bar Code',
        'KIX' => '(KIX) Klant index - Customer index',
        'IMB' => '(IMB) Intelligent Mail Barcode - Onecode - USPS-B-3200',
        'CODABAR' => 'CODABAR',
        'CODE11' => 'CODE 11',
        'PHARMA' => 'PHARMACODE',
        'PHARMA2T' => 'PHARMACODE TWO-TRACKS'
     * ]
     */
    public function getBarcode($format, $params = array()) {
        $manager = new BarcodeManager();
        
        if(!isset($params['data'])) {
            $params['data'] = $this->id;
        }
        if(!isset($params['type'])) {
            $params['type'] = 'C93';
        }
        
        if(!isset($params['width'])) {
            $params['width'] = 2;
        }
        if(!isset($params['height'])) {
            $params['height'] = 30;
        }
        if(!isset($params['color'])) {
            $params['color'] = $format != 'PNG' ? 'black' : [0,0,0];
        }
        return $manager->getBarcode($format,$params['data'],strtoupper($params['type']),$params['width'],$params['height'],$params['color']);
    }
    
    public function getBarCodeAttribute()
    {
         $bar_code_image = $this->getBarcode('PNG');
        if ($bar_code_image != null) {
//            <img src="data:image/png;base64,<?= $record->getBarcode('PNG');" alt="barcode" />
            return '<img src="data:image/png;base64,'.$bar_code_image.'" alt="barcode"  />';
        }
        else {
            return "";
        }

    }
}