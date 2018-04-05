<?php namespace Olabs\Oims\Models;

use Model;
use URL;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;


/**
 * Category Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\NestedTree;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_categories';

    
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'title' => 'required|between:2,64',
        'slug' => [
            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_oims_categories',
        ],        
    ];
    
    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'title', 
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description'
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
        'description',
        'active',
        'show_in_menu',
            
        // meta info
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'sales' => [
            'Olabs\Oims\Models\CategoryUserSale',
            'delete' => true,
        ]
    ];
    public $belongsTo = [
        'parent' => [
            'Olabs\Oims\Models\Category', 
            'key' => 'parent_id'
        ],
    ];
    public $belongsToMany = [
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'thumbnails' => 'System\Models\File'
    ];

    
    
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
        // All shows
        $categories = \Olabs\Oims\Models\Category::where("active",1)->where("show_in_menu",1)->where("nest_depth",0)->get();

        $items = array();
        foreach ($categories as $rootCategory) {
            self::recursiveMenuItems($item, $url, $rootCategory, $items);
            $result['items'] = $items;
        }
        // --------------------------------------------------------------------

        return $result;        
        
    }
    
    /**
     * Generate URL for categories
     * 
     * @param type $element
     * @param type $url
     */
    private static function recursiveGenerateUrl(&$element, &$url) {
        $url = "/".$element->slug . $url;
        if ($element->parent != null) {
            self::recursiveGenerateUrl($element->parent, $url);
        }
    }

    /**
     * Generate URL for categories
     * 
     * @param type $pageUrl
     * @param type $currentUrl
     * @param type $element
     * @param type $items
     */
    private static function recursiveMenuItems($menuItem, $currentUrl, $element, &$items) {
        
        // add self
        $url = "";
        //self::recursiveGenerateUrl($element, $url);
        
        // create URL
        if ($menuItem->cmsPage) {
            $url = CmsPage::url($menuItem->cmsPage, ["category" => $element->slug]);
        } else {
            $url = URL::to("/shop/".$element->slug);
        }
        
        $newId = count($items);
        $items[$newId] = [
            'url' => $url,
            'isActive' => ($currentUrl == $url),
            'title' => $element->title,
            'mtime' => $element->updated_at,
        ];        
        
        // add childern
        $subitems = array();
        foreach ($element->children as $elementChild) {
            self::recursiveMenuItems($menuItem, $currentUrl, $elementChild, $subitems);
        }
        $items[$newId]["items"] = $subitems;
    }
    
    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param string $paramName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $paramName, $controller)
    {
        $params = [
            $paramName => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }    
}