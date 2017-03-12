<?php namespace Istheweb\Shop;

use Backend;
use BackendMenu;
use Backend\Facades\BackendAuth;
use App;
use Event;
use Illuminate\Foundation\AliasLoader;
use Istheweb\Shop\Models\Category as ProductCategory;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UserController;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;
use Istheweb\Shop\Models\Address;
use Istheweb\Shop\Models\Customer;

/**
 * Shop Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['RainLab.Location', 'RainLab.User', 'Istheweb.IsPdf', 'Istheweb.Rating'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'istheweb.shop::lang.plugin.name',
            'description' => 'istheweb.shop::lang.plugin.description',
            'author'      => 'Andres Rangel',
            'icon'        => 'icon-shopping-cart',
        ];
    }

    public function registerNavigation()
    {
        return [
            'shop' => [
                'label'       => 'istheweb.shop::lang.plugin.name',
                'url'         => Backend::url('istheweb/shop/'. $this->startPage()),
                'icon'        => 'icon-shopping-cart',
                'permissions' => ['istheweb.shop.*'],
                'order'       => 500,

                'sideMenu'    => [

                    'products'     => [
                        'label'       => 'istheweb.shop::lang.products.menu_label',
                        'icon'        => 'icon-rocket',
                        'url'         => Backend::url('istheweb/shop/products'),
                        'permissions' => ['istheweb.shop.access_products'],
                        'group'       => 'istheweb.shop::lang.sidebar.catalog',
                        'description' => 'istheweb.shop::lang.product.description',
                    ],
                    'categories'     => [
                        'label'       => 'istheweb.shop::lang.categories.menu_label',
                        'icon'        => 'icon-cubes',
                        'url'         => Backend::url('istheweb/shop/categories'),
                        'permissions' => ['istheweb.shop.access_categories'],
                        'group'       => 'istheweb.shop::lang.sidebar.catalog',
                        'description' => 'istheweb.shop::lang.category.description',
                    ],
                    'filters'     => [
                        'label'       => 'istheweb.shop::lang.filters.menu_label',
                        'icon'        => 'icon-filter',
                        'url'         => Backend::url('istheweb/shop/filters'),
                        'permissions' => ['istheweb.shop.access_filters'],
                        'group'       => 'istheweb.shop::lang.sidebar.catalog',
                        'description' => 'istheweb.shop::lang.filter.description',
                    ],
                    'filter_types'     => [
                        'label'       => 'istheweb.shop::lang.filter_types.menu_label',
                        'icon'        => 'icon-folder',
                        'url'         => Backend::url('istheweb/shop/filtertypes'),
                        'permissions' => ['istheweb.shop.access_filtertypes'],
                        'group'       => 'istheweb.shop::lang.sidebar.catalog',
                        'description' => 'istheweb.shop::lang.filter_type.description',
                    ],
                    'features'     => [
                        'label'       => 'istheweb.shop::lang.features.menu_label',
                        'icon'        => 'icon-filter',
                        'url'         => Backend::url('istheweb/shop/features'),
                        'permissions' => ['istheweb.shop.access_features'],
                        'group'       => 'istheweb.shop::lang.sidebar.catalog',
                        'description' => 'istheweb.shop::lang.features.menu_description',
                    ],
                    'feature_types'     => [
                        'label'       => 'istheweb.shop::lang.feature_types.menu_label',
                        'icon'        => 'icon-folder',
                        'url'         => Backend::url('istheweb/shop/featuretypes'),
                        'permissions' => ['istheweb.shop.access_feature_types'],
                        'group'       => 'istheweb.shop::lang.sidebar.catalog',
                        'description' => 'istheweb.shop::lang.feature_type.description',
                    ],
                    'coupons'     => [
                        'label'       => 'istheweb.shop::lang.coupons.menu_label',
                        'icon'        => 'icon-gift',
                        'url'         => Backend::url('istheweb/shop/coupons'),
                        'permissions' => ['istheweb.shop.access_coupons'],
                        'group'       => 'istheweb.shop::lang.sidebar.marketing',
                        'description' => 'istheweb.shop::lang.coupon.description',
                    ],
                    'currencies'     => [
                        'label'       => 'istheweb.shop::lang.currencies.menu_label',
                        'icon'        => 'icon-money',
                        'url'         => Backend::url('istheweb/shop/currencies'),
                        'permissions' => ['istheweb.shop.access_currencies'],
                        'group'       => 'istheweb.shop::lang.sidebar.localisation',
                        'description' => 'istheweb.shop::lang.currency.description',
                    ],
                    'geozones'     => [
                        'label'       => 'istheweb.shop::lang.geo_zones.menu_label',
                        'icon'        => 'icon-globe',
                        'url'         => Backend::url('istheweb/shop/geozones'),
                        'permissions' => ['istheweb.shop.access_geo_zones'],
                        'group'       => 'istheweb.shop::lang.sidebar.localisation',
                        'description' => 'istheweb.shop::lang.geo_zone.description',
                    ],
                    'taxrates'     => [
                        'label'       => 'istheweb.shop::lang.tax_rates.menu_label',
                        'icon'        => 'icon-gavel',
                        'url'         => Backend::url('istheweb/shop/taxrates'),
                        'permissions' => ['istheweb.shop.access_tax_rates'],
                        'group'       => 'istheweb.shop::lang.sidebar.localisation',
                        'description' => 'istheweb.shop::lang.tax_rate.description',
                    ],
                    'shippings'     => [
                        'label'       => 'istheweb.shop::lang.shippings.menu_label',
                        'icon'        => 'icon-truck',
                        'url'         => Backend::url('istheweb/shop/shippings'),
                        'permissions' => ['istheweb.shop.access_shippings'],
                        'group'       => 'istheweb.shop::lang.sidebar.localisation',
                        'description' => 'istheweb.shop::lang.shipping.description',
                    ],
                    'orders'     => [
                        'label'       => 'istheweb.shop::lang.orders.menu_label',
                        'icon'        => 'icon-cart-arrow-down',
                        'url'         => Backend::url('istheweb/shop/orders'),
                        'permissions' => ['istheweb.shop.access_orders'],
                        'group'       => 'istheweb.shop::lang.sidebar.orders',
                        'description' => 'istheweb.shop::lang.order.description',
                    ],
                    'orderstatuses'     => [
                        'label'       => 'istheweb.shop::lang.order_statuses.menu_label',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('istheweb/shop/orderstatuses'),
                        'permissions' => ['istheweb.shop.access_order_statuses'],
                        'group'       => 'istheweb.shop::lang.sidebar.orders',
                        'description' => 'istheweb.shop::lang.order_status.description',
                    ],
                ],
            ],
        ];
    }

    public function startPage($page = 'products')
    {
        $user = BackendAuth::getUser();
        $permissions = array_reverse(array_keys($this->registerPermissions()));

        if (!isset($user->permissions['superuser']) && $user->hasAccess('istheweb.shop.*')) {
            foreach ($permissions as $access) {
                if ($user->hasAccess($access)) {
                    $page = explode('_', $access)[1];
                }
            }
        }
        //print_r($page);
        return $page;
    }

    public function registerPermissions()
    {
        return [

            'istheweb.shop.access_products'     => [
                'label' => 'istheweb.shop::lang.product.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.create_products'     => [
                'label' => 'istheweb.shop::lang.product.create_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.delete_products'     => [
                'label' => 'istheweb.shop::lang.product.delete_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_categories'     => [
                'label' => 'istheweb.shop::lang.category.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_filters'     => [
                'label' => 'istheweb.shop::lang.filter.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_filter_types'     => [
                'label' => 'istheweb.shop::lang.filter_type.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_features'     => [
                'label' => 'istheweb.shop::lang.feature.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_feature_types'     => [
                'label' => 'istheweb.shop::lang.feature_type.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_coupons'     => [
                'label' => 'istheweb.shop::lang.coupon.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_currencies'     => [
                'label' => 'istheweb.shop::lang.currency.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_tax_rates'     => [
                'label' => 'istheweb.shop::lang.tax_rates.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_shippings'     => [
                'label' => 'istheweb.shop::lang.shippings.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_geo_zones'     => [
                'label' => 'istheweb.shop::lang.geo_zones.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_orders'     => [
                'label' => 'istheweb.shop::lang.order.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_order_statuses'     => [
                'label' => 'istheweb.shop::lang.order_status.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_shop'      => [
                'label' => 'istheweb.shop::lang.shop.list_title',
                'tab'   => 'istheweb.shop::lang.plugin.name',
            ],
            'istheweb.shop.access_import_export' => [
                'tab'   => 'istheweb.shop::lang.plugin.name',
                'label' => 'istheweb.shop::lang.product.access_import_export'
            ],
        ];
    }

    public function registerComponents()
    {
        return [
            'Istheweb\Shop\Components\Products'                => 'Products',
            'Istheweb\Shop\Components\Product'                 => 'Product',
            'Istheweb\Shop\Components\Categories'              => 'Categories',
            'Istheweb\Shop\Components\FilterTypes'             => 'FilterTypes',
            'Istheweb\Shop\Components\Basket'                  => 'ShopBasket',
            'Istheweb\Shop\Components\Customer'                => 'Customer',
            'Istheweb\Shop\Components\Carousel'                => 'ClientsGallery',
        ];
    }

    public function registerSettings()
    {
        return [
            'shop' => [
                'label'       => 'istheweb.shop::lang.labels.shop',
                'description' => 'istheweb.shop::lang.labels.shop-settings',
                'category'    => 'system::lang.system.categories.system',
                'icon'        => 'icon-shopping-cart',
                'class'       => 'Istheweb\Shop\Models\Shop',
                'order'       => 500,
                'keywords'    => 'istheweb.shop::lang.shop.keywords',
                'permissions' => ['istheweb.shop.access_shop'],
            ],
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'istheweb.shop::mail.activate'              => 'istheweb.shop::lang.email.activate',
            'istheweb.shop::mail.welcome'               => 'istheweb.shop::lang.email.welcome',
            'istheweb.shop::mail.restore'               => 'istheweb.shop::lang.email.restore',
            'istheweb.shop::mail.new_user'              => 'istheweb.shop::lang.email.new_user',
            'istheweb.shop::mail.reactivate'            => 'istheweb.shop::lang.email.reactivate',
            'istheweb.shop::mail.orderconfirm'          => 'istheweb.shop::lang.email.orderconfirm',
            'istheweb.shop::mail.orderconfirm_admin'    => 'istheweb.shop::lang.email.orderconfirm_admin',
        ];
    }

    /**
     * Register snippets with the RainLab.Pages plugin.
     *
     * @return array
     * @see https://octobercms.com/plugin/rainlab-pages
     */
    public function registerPageSnippets()
    {
        return [

        ];
    }

    public function register()
    {
        // Register ServiceProviders
        App::register('\Gloudemans\Shoppingcart\ShoppingcartServiceProvider');
        // Register aliases
        $alias = AliasLoader::getInstance();
        $alias->alias('Cart', 'Gloudemans\Shoppingcart\Facades');
        $alias->alias('Checkout', 'Istheweb\Shop\Facades\Checkout');

        App::singleton('checkout.order', function() {
            return \Istheweb\Shop\Classes\CheckoutManager::instance();
        });

        BackendMenu::registerContextSidenavPartial('Istheweb.Shop', 'shop', 'plugins/istheweb/shop/partials/_sidebar.htm');
        set_exception_handler([$this, 'handleException']);
    }

    /**
     * Workaround to resolve
     * TypeError: Argument 1 passed to October\Rain\Foundation\Exception\Handler::report() must be an instance of Exception
     * This error is fixed by octobercms/library@83888f4
     * witch Fixes seg fault (infinite loop) when using remember()
     * but while it's not in dev-master branch we use this workaround function
     * @param $e Exception
     */
    public function handleException($e)
    {
        if (! $e instanceof Exception) {
            $e = new \Symfony\Component\Debug\Exception\FatalThrowableError($e);
        }

        $handler = $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler');
        $handler->report($e);

        if ($this->app->runningInConsole()) {
            $handler->renderForConsole(new ConsoleOutput, $e);
        } else {
            $handler->render($this->app['request'], $e)->send();
        }
    }

    public function boot()
    {

        /*
         * Register menu items for the RainLab.Pages plugin
        */
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'product-category'       => 'istheweb.shop::lang.menuitem.product_category',
                'all-product-categories' => 'istheweb.shop::lang.menuitem.all_product_categories'
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'product-category' || $type == 'all-product-categories') {
                return ProductCategory::getMenuTypeInfo($type);
            }
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'product-category' || $type == 'all-product-categories') {
                return ProductCategory::resolveMenuItem($item, $url, $theme);
            }
        });

        if(!App::runningInBackend()) {
            return;
        }

        Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            $controller->addCss('/plugins/istheweb/shop/assets/css/shop.css');
            //$controller->addJs('/plugins/istheweb/shop/assets/js/jquery.treeview.js');
        });

        UserModel::extend(function($model){
            $model->hasOne['customer'] = ['Istheweb\Shop\Models\Customer'];

            $model->bindEvent('model.beforeDelete', function() use ($model) {
                $model->customer && $model->customer->delete();
            });

            $model->addDynamicMethod('getCustomerAddressesOptions', function() use ($model){
                return Customer::getAddresses($model->customer->id);
            });

        });

        Country::extend(function($model){
            $model->belongsToMany['geoZone'] = ['Istheweb\Shop\Models\GeoZone'];
            $model->hasOne['address'] = ['Istheweb\Shop\Models\Address'];
        });

        State::extend(function($model){
            $model->belongsToMany['geoZone'] = ['Istheweb\Shop\Models\GeoZone'];
            $model->hasOne['address'] = ['Istheweb\Shop\Models\Address'];
        });

        UserController::extendFormFields(function($form, $model, $context){

            if(!$model instanceof UserModel)
                return;

            if(!$model->exists) return;

            if(!Customer::getFromUser($model)) return;



            $form->addTabFields([
                'customer[username]' => [
                    'label' => 'istheweb.shop::lang.labels.username',
                    'span'  => 'auto',
                    'tab'   => 'istheweb.shop::lang.labels.details',
                ],
                'customer[phone]' => [
                    'label' => 'istheweb.shop::lang.labels.phone',
                    'span'  => 'auto',
                    'tab'   => 'istheweb.shop::lang.labels.details',
                ],
                'customer[fax]' => [
                    'label' => 'istheweb.shop::lang.labels.fax',
                    'span'  => 'auto',
                    'tab'   => 'istheweb.shop::lang.labels.details',
                ],
                'customer[addresses]' => [
                    'label'     => 'Addresses',
                    'span'      => 'auto',
                    'type'      => 'dropdown',
                    'options'   => 'getCustomerAddressesOptions',
                    'tab'       => 'istheweb.shop::lang.labels.details',
                ],
            ]);
        });
    }
}
