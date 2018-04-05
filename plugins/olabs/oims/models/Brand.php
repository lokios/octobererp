<?php namespace Olabs\Oims\Models;

use Model;
use URL;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;

/**
 * Brand Model
 */
class Brand extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_brands';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'title' => 'required|between:2,64',       
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
        'short_description',
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
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'logo' => 'System\Models\File'
    ];
    public $attachMany = [];

    
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
        $brands = \Olabs\Oims\Models\Brand::where("active",1)->where("show_in_menu",1)->orderBy("title", "asc")->get();
        
        
        

        $items = array();
        foreach ($brands as $brand) {
            
            // create URL
            if ($item->cmsPage) {
                $urlPage = CmsPage::url($item->cmsPage, ["brand" => $brand->slug]);
            } else {
                $urlPage = URL::to("/brand/".$brand->slug);
            }        
            
            $items[] = [
                'url' => $urlPage,
                'isActive' => ($url == $urlPage),
                'title' => $brand->title,
                'mtime' => $brand->updated_at,
            ];              
        }
        $result['items'] = $items;
        // --------------------------------------------------------------------

        return $result;   
    }    
}