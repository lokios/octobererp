<?php

namespace Olabs\Oims;

use Backend;
use System\Classes\PluginBase;
use Event;
use Validator;
use App;
use Illuminate\Foundation\AliasLoader;
use Config;
use File;
use Route;
use Redirect;
use Yaml;

/**
 * Oims Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * @var array Plugin dependencies
     */
    public $require = ['RainLab.User'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'olabs.oims::lang.plugin.name',
            'description' => 'olabs.oims::lang.plugin.description',
            'author' => 'Anuj Sinha',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return [
            'Olabs\Oims\Components\ProductsByCategory' => 'myProducts',
            'Olabs\Oims\Components\ProductsByBrand' => 'myProductsByBrand',
            'Olabs\Oims\Components\ProductDetail' => 'myProductDetail',
            'Olabs\Oims\Components\ProductsList' => 'myProductsList',
            'Olabs\Oims\Components\MyOrders' => 'myOrders',
            'Olabs\Oims\Components\MyOrderDetail' => 'myOrderDetail',
            'Olabs\Oims\Components\Basket' => 'myBasket',
            'Olabs\Oims\Components\BrandDetails' => 'myBrandDetails',
            'Olabs\Oims\Components\BrandsList' => 'myBrandsList',
            'Olabs\Oims\Components\BreadcrumbsCategory' => 'myBreadcrumbsCategory',
            'Olabs\Oims\Components\BreadcrumbsProduct' => 'myBreadcrumbsProduct',
            'Olabs\Oims\Components\PaymentGateway' => 'myPaymentGateway',
            'Olabs\Oims\Components\CustomPaymentPaypalIPN' => 'myCustomPaymentPaypalIPN',
            'Olabs\Oims\Components\CustomPaymentStripeCheckout' => 'myCustomPaymentStripeCheckout',
            'Olabs\Oims\Components\CustomPaymentCashOnDelivery' => 'myCustomPaymentCashOnDelivery',
        ];
    }

//    public function register() {
//        Backend\Facades\BackendMenu::registerContextSidenavPartial('Olabs.Oims', 'oims', '@/plugins/olabs/oims/partials/_sidebar.htm');
//    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return [
            'olabs.oims.projectprogress' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_projectprogress'],
            'olabs.oims.quotes' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_quotes'],
            'olabs.oims.sales' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_sales'],
            'olabs.oims.purchases' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_purchases'],
            'olabs.oims.payment_receivables' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_payment_receivables'],
            'olabs.oims.attendances' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_attendances'],
            'olabs.oims.pc_attendances' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_pcattendances'],
            'olabs.oims.machineries' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_machineries'],
            'olabs.oims.manpowers' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_manpowers'],
            'olabs.oims.expenseonmaterials' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_expenseonmaterials'],
            'olabs.oims.expenseonpcs' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_expenseonpcs'],
            'olabs.oims.project_assets' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_project_assets'],
            
            'olabs.oims.reports' => ['tab' => 'olabs.oims::lang.plugin.oims', 'label' => 'olabs.oims::lang.plugin.access_reports'],
            'olabs.oims.workgroups' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_workgroups'],
            'olabs.oims.categories' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_categories'],
            'olabs.oims.brands' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_brands'],
            'olabs.oims.bank_accounts' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_bank_accounts'],
            'olabs.oims.orderstatuses' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_orderstatuses'],
            'olabs.oims.taxes' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_taxes'],
            'olabs.oims.units' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_units'],
            'olabs.oims.statuses' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_statuses'],
            'olabs.oims.properties' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_properties'],
            'olabs.oims.carriers' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_carriers'],
            'olabs.oims.paymentgateways' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_paymentgateways'],
            'olabs.oims.coupons' => ['tab' => 'olabs.oims::lang.plugin.oims_setup', 'label' => 'olabs.oims::lang.plugin.access_coupons'],
            'olabs.oims.projects' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_projects'],
            'olabs.oims.projectworks' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_projectworks'],
            'olabs.oims.companies' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_companies'],
            'olabs.oims.products' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_products'],
            'olabs.oims.suppliers' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_suppliers'],
            'olabs.oims.employees' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_employees'],
            'olabs.oims.customers' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_customers'],
//            'olabs.oims.approval' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_approval'],
            'olabs.oims.record_back_date_entry' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_record_back_date_entry'],
            'olabs.oims.record_approval' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_record_approval'],
            'olabs.oims.record_update' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_record_update'],
            'olabs.oims.record_ho_approval' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_record_ho_approval'],
            'olabs.oims.record_submit_for_approval' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_record_submit_for_approval'],
            'olabs.oims.access_settings' => ['tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_settings'],
            'olabs.oims.employee_types' => [ 'tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_employee_types' ],
            'olabs.oims.offrole_employees' => [ 'tab' => 'olabs.oims::lang.plugin.oims_project', 'label' => 'olabs.oims::lang.plugin.access_offrole_employees' ],
//            'olabs.oims.projects' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_projects' ],
//            'olabs.oims.orders' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_orders' ],
//            'olabs.oims.products' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_products' ],
//            'olabs.oims.categories' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_categories' ],
//            'olabs.oims.brands' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_brands' ],
//            'olabs.oims.taxes' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_taxes' ],
//            'olabs.oims.carriers' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_carriers' ],
//            'olabs.oims.orderstatuses' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_orderstatuses' ],
//            'olabs.oims.properties' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_properties' ],
//            'olabs.oims.coupons' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_coupons' ],
//            'olabs.oims.paymentgateways' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_paymentgateways' ],
//            'olabs.oims.quotes' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_quotes' ],
//            'olabs.oims.sales' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_sales' ],
//            'olabs.oims.purchases' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.access_purchases' ],
//            'olabs.oims.quotes' => [ 'tab' => 'olabs.oims::lang.plugin.name', 'label' => 'olabs.oims::lang.plugin.quotes' ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation_BIN() {
        return [
            'oims' => [
                'label' => 'olabs.oims::lang.plugin.main_menu',
                'url' => Backend::url('olabs/oims/orders'),
                'icon' => 'icon-shopping-cart',
                'permissions' => ['olabs.oims.*'],
                'order' => 69,
                'sideMenu' => [
                    'orders' => [
                        'label' => 'olabs.oims::lang.orders.menu_label',
                        'icon' => 'icon-money',
                        'url' => Backend::url('olabs/oims/orders'),
                        'permissions' => ['olabs.oims.orders'],
                    ],
                    'products' => [
                        'label' => 'olabs.oims::lang.products.menu_label',
                        'icon' => 'icon-cube',
                        'url' => Backend::url('olabs/oims/products'),
                        'permissions' => ['olabs.oims.products'],
                    ],
                    'categories' => [
                        'label' => 'olabs.oims::lang.categories.menu_label',
                        'icon' => 'icon-list-alt',
                        'url' => Backend::url('olabs/oims/categories'),
                        'permissions' => ['olabs.oims.categories'],
                    ],
                    'brands' => [
                        'label' => 'olabs.oims::lang.brands.menu_label',
                        'icon' => 'icon-copyright',
                        'url' => Backend::url('olabs/oims/brands'),
                        'permissions' => ['olabs.oims.brands'],
                    ],
                    'taxes' => [
                        'label' => 'olabs.oims::lang.taxes.menu_label',
                        'icon' => 'icon-random',
                        'url' => Backend::url('olabs/oims/taxes'),
                        'permissions' => ['olabs.oims.taxes'],
                    ],
                    'carriers' => [
                        'label' => 'olabs.oims::lang.carriers.menu_label',
                        'icon' => 'icon-truck',
                        'url' => Backend::url('olabs/oims/carriers'),
                        'permissions' => ['olabs.oims.carriers'],
                    ],
                    'orderstatuses' => [
                        'label' => 'olabs.oims::lang.orderstatuses.menu_label',
                        'icon' => 'icon-tasks',
                        'url' => Backend::url('olabs/oims/orderstatuses'),
                        'permissions' => ['olabs.oims.orderstatuses'],
                    ],
                    'properties' => [
                        'label' => 'olabs.oims::lang.properties.menu_label',
                        'icon' => 'icon-cogs',
                        'url' => Backend::url('olabs/oims/properties'),
                        'permissions' => ['olabs.oims.properties'],
                    ],
                    'coupons' => [
                        'label' => 'olabs.oims::lang.coupons.menu_label',
                        'icon' => 'icon-ticket',
                        'url' => Backend::url('olabs/oims/coupons'),
                        'permissions' => ['olabs.oims.coupons'],
                    ],
                    'paymentgateways' => [
                        'label' => 'olabs.oims::lang.paymentgateways.menu_label',
                        'icon' => 'icon-ticket',
                        'url' => Backend::url('olabs/oims/paymentgateways'),
                        'permissions' => ['olabs.oims.paymentgateways'],
                    ]
                ]
            ]
        ];
    }

    public function registerSettings() {
        return [
            'settings' => [
                'label' => 'olabs.oims::lang.settings.menu_label',
                'description' => 'olabs.oims::lang.settings.description',
                'category' => 'olabs.oims::lang.settings.category',
                'icon' => 'icon-shopping-cart',
                'class' => 'Olabs\Oims\Models\Settings',
                'order' => 69,
                'keywords' => 'security shop',
                'permissions' => ['olabs.oims.access_settings']
            ]
        ];
    }

    /**
     * Main boot function
     */
    public function boot() {
        $this->bootMenuItem();
        $this->bootValidatorExtend();
        $this->bootRainlabUserExtend();
        $this->bootBackendUserExtend();
        $this->bootRainlabTranslateExtend();

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
        $alias = AliasLoader::getInstance();

        // -----------------------------------------------------------
        // DomPDF
        // -----------------------------------------------------------
        Config::set('dompdf.config_file', plugins_path() . "/olabs/oims/vendor/dompdf/dompdf/dompdf_config.inc.php");
        \App::register('Barryvdh\DomPDF\ServiceProvider');
        $alias->alias('PDF', 'Barryvdh\DomPDF\Facade');
        $this->createFontDirectory();
        // -----------------------------------------------------------
        // -----------------------------------------------------------
        // Omnipay
        // -----------------------------------------------------------
        \App::register('Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider');
        $alias->alias('Omnipay', 'Ignited\LaravelOmnipay\Facades\OmnipayFacade');
        // add extra gateways
        $factory = \Omnipay\Omnipay::getFactory();
        $factory->register("TwoCheckoutPlus");
        $factory->register("TwoCheckoutPlus_Token");
        // -----------------------------------------------------------
    }

    /**
     * Create directory for cache fonts
     */
    private function createFontDirectory() {
        $config = Config::get('dompdf.defines');

        if (!File::exists($config['DOMPDF_FONT_CACHE'])) {
            File::makeDirectory($config['DOMPDF_FONT_CACHE']);
        }
    }

    /**
     * Add menu item support
     */
    private function bootMenuItem() {
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'olabs-oims-categiries' => 'All OIMS Categories',
                'olabs-oims-brands' => 'All OIMS Brands',
                'olabs-oims-products' => 'All OIMS Products',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'olabs-oims-categiries') {
                return Models\Category::getMenuTypeInfo($type);
            }
            if ($type == 'olabs-oims-brands') {
                return Models\Brand::getMenuTypeInfo($type);
            }
            if ($type == 'olabs-oims-products') {
                return Models\Product::getMenuTypeInfo($type);
            }
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'olabs-oims-categiries') {
                return Models\Category::resolveMenuItem($item, $url, $theme);
            }
            if ($type == 'olabs-oims-brands') {
                return Models\Brand::resolveMenuItem($item, $url, $theme);
            }
            if ($type == 'olabs-oims-products') {
                return Models\Product::resolveMenuItem($item, $url, $theme);
            }
        });
    }

    /**
     * Extend validator
     */
    private function bootValidatorExtend() {
        // EAN 13 validator
        Validator::extend('ean13', function($attribute, $barcode, $parameters) {
            // https://principeorazio.wordpress.com/2012/03/23/verify-ean-13-with-php/
            // check to see if barcode is 13 digits long
            if (!preg_match("/^[0-9]{13}$/", $barcode)) {
                return false;
            }

            $digits = $barcode;

            // 1. Add the values of the digits in the 
            // even-numbered positions: 2, 4, 6, etc.
            $even_sum = $digits[1] + $digits[3] + $digits[5] +
                    $digits[7] + $digits[9] + $digits[11];

            // 2. Multiply this result by 3.
            $even_sum_three = $even_sum * 3;

            // 3. Add the values of the digits in the 
            // odd-numbered positions: 1, 3, 5, etc.
            $odd_sum = $digits[0] + $digits[2] + $digits[4] +
                    $digits[6] + $digits[8] + $digits[10];

            // 4. Sum the results of steps 2 and 3.
            $total_sum = $even_sum_three + $odd_sum;

            // 5. The check character is the smallest number which,
            // when added to the result in step 4, produces a multiple of 10.
            $next_ten = (ceil($total_sum / 10)) * 10;
            $check_digit = $next_ten - $total_sum;

            // if the check digit and the last digit of the 
            // barcode are OK return true;
            if ($check_digit == $digits[12]) {
                return true;
            }

            return false;
        });
    }

    /**
     * Extend all my class if rainlab translate exist
     * - $translatable fields are defined in class
     */
    private function bootRainlabTranslateExtend() {

//        if (class_exists("\RainLab\Translate\Behaviors\TranslatableModel")) {
//            // Product
//            Models\Product::extend(function($model) { $model->implement[] = 'RainLab.Translate.Behaviors.TranslatableModel'; });
//        }
    }

    /**
     * Extend plugin Rainlab.User
     */
    private function bootRainlabUserExtend() {

        if (class_exists("\RainLab\User\Models\User")) {

            \RainLab\User\Models\User::extend(function($model) {
                $model->addFillable([
                    "oims_ds_first_name",
                    "oims_ds_last_name",
                    "oims_ds_address",
                    "oims_ds_address_2",
                    "oims_ds_postcode",
                    "oims_ds_city",
                    "oims_ds_country",
                    "oims_ds_county",
                    // Invoice address
                    "oims_is_first_name",
                    "oims_is_last_name",
                    "oims_is_address",
                    "oims_is_address_2",
                    "oims_is_postcode",
                    "oims_is_city",
                    "oims_is_country",
                    "oims_is_county",
                    // Contact
                    "oims_contact_email",
                    "oims_contact_phone",
                ]);
            });
            \RainLab\User\Controllers\Users::extendFormFields(function($widget) {
                // Prevent extending of related form instead of the intended User form
                if (!$widget->model instanceof \RainLab\User\Models\User) {
                    return;
                }
                $configFile = __DIR__ . '/models/rainlabuser/fields.yaml';
                $config = Yaml::parse(File::get($configFile));
                $widget->addTabFields($config);
            });
        }
    }

    /**
     * Extend plugin Backend.User
     */
    private function bootBackendUserExtend() {

        if (class_exists("Backend\Models\User")) {
//            dd('hi');

            Backend\Models\User::extend(function($model) {

//    Add this function in backend user model to get the project list in add/edit
//    public function getProjectsOptions()
//    {
//        $result = [];
//        foreach (\Olabs\Oims\Models\Project::all() as $project) {
//            $result[$project->id] = [$project->name, $project->description];
//        }
//        return $result;
//    }
                $model->addFillable([
                    "first_name",
                    "last_name",
                    "address",
                    "address_2",
                    "postcode",
                    "city",
                    "country",
                    "contact_phone",
                    "contact_email",
                ]);

                $model->belongsToMany['projects'] = ['Olabs\Oims\Models\Project', 'table' => 'olabs_oims_user_projects'];



//                dd($model->belongsToMany);
//                $model->addBelongsToMany([
//                    'projects' => ['Olabs\Oims\Models\Project', 'table' => 'olabs_oims_user_projects']
//                ]);
//                $model->addFillable([
//                    "oims_ds_first_name",
//                    "oims_ds_last_name",
//                    "oims_ds_address",
//                    "oims_ds_address_2",
//                    "oims_ds_postcode",
//                    "oims_ds_city",
//                    "oims_ds_country",
//                    "oims_ds_county",
//                    // Invoice address
//                    "oims_is_first_name",
//                    "oims_is_last_name",
//                    "oims_is_address",
//                    "oims_is_address_2",
//                    "oims_is_postcode",
//                    "oims_is_city",
//                    "oims_is_country",
//                    "oims_is_county",            
//
//                    // Contact
//                    "oims_contact_email",
//                    "oims_contact_phone",
//                ]);

                $model->addDynamicMethod('hasRole', function($role) use ($model) {
                    return $model->groups()->whereCode($role)->exists();
                });

                $model->addDynamicMethod('isAdmin', function() use ($model) {
                    if ($model->is_superuser) {
                        return true;
                    }
                    return $model->groups()->whereCode(Models\BaseModel::USER_GROUP_ADMIN)->exists();
                });
            });
            Backend\Controllers\Users::extendFormFields(function($widget) {
                // Prevent extending of related form instead of the intended User form
                if (!$widget->model instanceof Backend\Models\User) {
                    return;
                }
                $configFile = __DIR__ . '/models/backenduser/fields.yaml';
                $config = Yaml::parse(File::get($configFile));
                $widget->addTabFields($config);
            });
            
            Backend\Controllers\Users::extendListColumns(function($widget) {
                // Prevent extending of related form instead of the intended User form
                if (!$widget->model instanceof Backend\Models\User) {
                    return;
                }
                $configFile = __DIR__ . '/models/backenduser/columns.yaml';
                $config = Yaml::parse(File::get($configFile));
                $widget->addColumns($config);
            });
        }
    }

    public function registerMailTemplates() {
        return [
            'olabs.oims::mail.cancel' => 'Cancel Order.',
            'olabs.oims::mail.payment-received' => 'Payment Received.',
            'olabs.oims::mail.new-order-paypal' => 'New Order - PayPal.',
            'olabs.oims::mail.new-order-cash-on-delivery' => 'New Order - Cash on Delivery.',
            'olabs.oims::mail.new-order-bank-tranfer' => 'New Order - Bank Tranfer.',
            'olabs.oims::mail.expedited-order-cash-on-delivery' => 'Expedited Order - Cash on Delivery.',
            'olabs.oims::mail.expedited-order' => 'Expedited Order.',
        ];
    }
    
    public function registerReportWidgets() {
        return [
            'Olabs\Oims\ReportWidgets\ProjectStatus' => [
                'label' => 'Project Status',
                'context' => 'dashboard'
            ],
            'Olabs\Oims\ReportWidgets\DprSummary' => [
                'label' => 'DPR Summary',
                'context' => 'dashboard'
            ],

        ];
    }

}
