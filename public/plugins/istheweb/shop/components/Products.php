<?php namespace Istheweb\Shop\Components;

use Istheweb\Shop\Models\Product as ProductBase;
use Istheweb\Shop\Models\Category as ProductCategory;
use Schema;
use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;

class Products extends ComponentBase
{

    /**
     * A collection of products to display
     * @var Collection
     */
    public $products;

    /**
     * A collection of lastest products to display
     * @var Collection
     */
    public $latestProducts;

    /**
     * Parameter to use for the page number
     * @var string
     */
    public $pageParam;

    /**
     * If the post list should be filtered by a category, the model to use.
     * @var Model
     */
    public $category;

    /**
     * Message to display when there are no messages.
     * @var string
     */
    public $noProductMessage;

    /**
     * Reference to the page name for linking to products.
     * @var string
     */
    public $productPage;

    /**
     * Reference to the page name for linking to categories.
     * @var string
     */
    public $categoryPage;

    /**
     * If the post list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    /**
     *
     * @var array
     */
    public $breadCrumbs;

    public function componentDetails()
    {
        return [
            'name'        => 'istheweb.shop::lang.components.products.name',
            'description' => 'istheweb.shop::lang.components.products.description'
        ];
    }

    public function defineProperties()
    {
        return [

            'pageNumber' => [
                'title'       => 'istheweb.shop::lang.products.product_pagination',
                'description' => 'istheweb.shop::lang.products.product_pagination_description',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'categoryFilter' => [
                'title'       => 'istheweb.shop::lang.products.product_filter',
                'description' => 'istheweb.shop::lang.products.product_filter_description',
                'type'        => 'string',
                'default'     => ''
            ],
            'productsPerPage' => [
                'title'             => 'istheweb.shop::lang.products.product_per_page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'istheweb.shop::lang.products.product_per_page_validation',
                'default'           => '10',
            ],
            'noProductsMessage' => [
                'title'        => 'istheweb.shop::lang.products.product_no_products',
                'description'  => 'istheweb.shop::lang.products.product_no_products_description',
                'type'         => 'string',
                'default'      => 'No products found',
                'showExternalParam' => false
            ],
            'sortOrder' => [
                'title'       => 'istheweb.shop::lang.products.product_order',
                'description' => 'istheweb.shop::lang.products.product_order_description',
                'type'        => 'dropdown',
                'default'     => 'published_at desc'
            ],
            'categoryPage' => [
                'title'       => 'istheweb.shop::lang.category.label',
                'description' => 'istheweb.shop::lang.category.description',
                'type'        => 'dropdown',
                'default'     => 'category',
                'group'       => 'Links',
            ],
            'productPage' => [
                'title'       => 'istheweb.shop::lang.products.product_page',
                'description' => 'istheweb.shop::lang.products.product_page_description',
                'type'        => 'dropdown',
                'default'     => 'product',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions(){
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getProductPageOptions(){
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getSortOrderOptions(){
        return ProductBase::$allowedSortingOptions;
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->category = $this->page['category'] = $this->loadCategory();
        $this->products = $this->page['products'] = $this->listProducts();
        $this->latestProducts = $this->page['latestProducts'] = $this->loadLatests();
        $this->getBreadCrumbs();
        /*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->products->lastPage()) && $currentPage > 1)
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
        }
    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $this->noProductsMessage = $this->page['noProductsMessage'] = $this->property('noProductsMessage');

        /*
         * Page links
         */
        $this->productPage = $this->page['productPage'] = $this->property('productPage');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
    }

    protected function listProducts()
    {
        $category = $this->category ? $this->category->id : null;
        /*
         * List all the products, eager load their categories
         */
        $products = ProductBase::with('categories')->listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'sort'       => $this->property('sortOrder'),
            'perPage'    => $this->property('productsPerPage'),
            'category'   => $category
        ]);

        $products = $this->setUrls($products);

        return $products;
    }

    protected function loadLatests(){
        $latests = ProductBase::with('picture')
            ->orderBy('published_at')
            ->take(4)
            ->get();
        return $latests;
    }

    protected function setUrls($products){
        $products->each(function($product) {
            $product->setUrl($this->productPage, $this->controller);

            $product->categories->each(function($category) {
                $category->setUrl($this->categoryPage, $this->controller);
            });
        });
        return $products;
    }

    protected function loadCategory()
    {
        if (!$categoryId = $this->property('categoryFilter'))
            return null;

        if (!$category = ProductCategory::whereSlug($categoryId)->first())
            return null;

        return $category;
    }

    public function getCategoriesParent($parent_id, &$categoryPath = [])
    {
        if ( !$parent_id ) {
            return null;
        }
        $category = ProductCategory::where('id', intval($parent_id))->first();
        if ( is_object($category) && $category->id ) {
            $categoryPath []= $category;
            if ( intval($category->parent_id) ) $this->getCategoriesParent($category->parent_id, $categoryPath);
            return $categoryPath;
        }
        return null;
    }

    public function getBreadCrumbs()
    {
        $controller = $this->controller;
        $parent_id = null;
        $categoryPath = [];
        if ( $this->category ) {
            $parent_id = $this->category->parent_id;
            $this->category->nolink = true;
            $categoryPath []= $this->category;
        }

        $this->getCategoriesParent($parent_id, $categoryPath);
        $categoryPath = array_reverse($categoryPath);
        $breadCrumbs = [];
        if ( $categoryPath ) {

            foreach ( $categoryPath as $category ) {
                $params = [
                    'id' => $category->id,
                    'slug' => $category->slug,
                ];
                if ( $breadCrumbs ) $breadCrumbs []= [
                    'separator' => '>',
                    'name' => null,
                    'link' => null
                ];

                if ( $category->nolink )
                {
                    $breadCrumbs []= [
                        'link' => '#',
                        'name' => $category->name,
                        'separator' => null
                    ];
                }
                else
                {
                    $breadCrumbs []= [
                        'link' => $controller->pageUrl($this->categoryPage, $params),
                        'name' => $category->name,
                        'separator' => null
                    ];
                }
            }
        }
        $this->breadCrumbs = $this->page['breadCrumbs'] = $breadCrumbs;
    }

    public function onSearch()
    {
        $search = post('search');
        $category = $this->category ? $this->category->id : null;
        $products = ProductBase::with('categories')->listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'sort'       => $this->property('sortOrder'),
            'perPage'    => $this->property('productsPerPage'),
            'category'   => $category,
            'search'     => $search,
        ]);
        $products = $this->setUrls($products);
        $this->products = $this->page['products'] = $products;
    }

    public function onFilterSubmit(){
        $filters = array_keys(post());
        $category = $this->category ? $this->category->id : null;

        if(count($filters) > 0){
            $products = ProductBase::with('categories')->listFrontEnd([
                'page'       => $this->property('pageNumber'),
                'sort'       => $this->property('sortOrder'),
                'perPage'    => $this->property('productsPerPage'),
                'category'   => $category,
                'filters'    => $filters,
            ]);
        }else{
            $products = ProductBase::with('categories')->listFrontEnd([
                'page'       => $this->property('pageNumber'),
                'sort'       => $this->property('sortOrder'),
                'perPage'    => $this->property('productsPerPage'),
                'category'   => $category,
            ]);
        }
        $products = $this->setUrls($products);
        $this->products = $this->page['products'] = $products;
    }

    public function onFilterPrices(){
        $prices = post();
        $category = $this->category ? $this->category->id : null;
        $products = ProductBase::with('categories')->listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'sort'       => $this->property('sortOrder'),
            'perPage'    => $this->property('productsPerPage'),
            'category'   => $category,
            'prices'     => $prices,
        ]);
        $products = $this->setUrls($products);
        $this->products = $this->page['products'] = $products;

    }

    protected function onSortOrder()
    {
        $sort = post();
        $category = $this->category ? $this->category->id : null;
        $products = ProductBase::with('categories')->listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'sort'       => $sort,
            'perPage'    => $this->property('productsPerPage'),
            'category'   => $category,
        ]);
        $products = $this->setUrls($products);
        $this->products = $this->page['products'] = $products;
    }

}