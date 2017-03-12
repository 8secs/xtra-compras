<?php namespace Istheweb\Shop\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\URL;
use Istheweb\Shop\Models\Feature;
use Istheweb\Shop\Models\FeatureType;
use Istheweb\Shop\Models\Product as ProductModel;
use Istheweb\Shop\Models\Category as ProductCategory;
use Cms\Classes\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Lang;

class Product extends ComponentBase
{

    /**
     * @var
     */
    public $product;

    /**
     * @var
     */
    public $categoryPage;

    /**
     * @var
     */
    public $relatedProducts;

    /**
     * @var
     */
    public $featureTypes;


    /**
     *
     * @var array
     */
    public $breadcrumbs;

    public function componentDetails()
    {
        return [
            'name'        => 'istheweb.shop::lang.components.product.name',
            'description' => 'istheweb.shop::lang.components.product.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'maxItems' => [
                'title'             => 'istheweb.shop::lang.labels.maxItems',
                'description'       => 'istheweb.shop::lang.descriptions.maxItems',
                'default'           => 20,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
            ],
            'slug' => [
                'title'       => 'istheweb.shop::lang.labels.slug',
                'description' => 'istheweb.shop::lang.labels.slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'categoryPage' => [
                'title'       => 'istheweb.shop::lang.category.label',
                'description' => 'istheweb.shop::lang.category.description',
                'type'        => 'dropdown',
                'default'     => 'category',
            ],
            'orderBy'  => [
                'title'       => 'istheweb.shop::lang.labels.orderBy',
                'description' => 'istheweb.shop::lang.descriptions.orderBy',
                'type'        => 'dropdown',
                'default'     => 'id',
            ],
            'sort'     => [
                'title'       => 'istheweb.shop::lang.labels.sort',
                'description' => 'istheweb.shop::lang.descriptions.sort',
                'type'        => 'dropdown',
                'default'     => 'desc',
            ],
        ];
    }

    public function onRun()
    {
        $this->product = $this->page['product'] = $this->loadProduct();
        $this->relatedProducts = $this->page['relatedProducts'] = $this->loadRelated();
        $this->featureTypes = $this->page['featureTypes'] = $this->loadFeatureTypes();
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->breadcrumbs = $this->page['breadcrumbs'] = $this->getBreadCrumbs();

    }

    protected function loadProduct()
    {
        $slug = $this->property('slug');
        if($slug)
            $product = ProductModel::where('slug', $slug)->first();
        else
            $product = ProductModel::where('id', 1)->first();

        if ($product && $product->categories->count()) {
            $product->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }

        return $product;
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
        $currentCategory = $this->product->categories->get(0);

        if ( $currentCategory ) {
            $parent_id = $currentCategory->parent_id;
            $categoryPath []= $currentCategory;
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

                $breadCrumbs []= [
                    'link' => URL::to($this->categoryPage.'/'. $category->slug),
                    'name' => $category->name,
                    'separator' => null
                ];
            }
        }

        if($this->product && $breadCrumbs){
            $breadCrumbs []= [
                'separator' => '>',
                'name' => null,
                'link' => null
            ];
            $breadCrumbs []= [
                'link' => '#',
                'name' => $this->product->name,
                'separator' => null
            ];
        }

        return $breadCrumbs;
    }

    protected function loadRelated(){
        if($this->product && $this->product->categories->count()) {
            foreach($this->product->categories as $category){
                $product_categories[] = $category->id;
            }
            $related = ProductModel::with('picture')
                ->whereHas('categories',
                    function($query) use ($product_categories){
                        $query->whereIn('id', $product_categories);
                    })
                ->where('id', '<>', $this->product->id)
                ->take(3)
                ->get();
            return $related;
        }
    }

    protected function loadFeatures($id){
        return Feature::where('feature_type_id', '=', $id)->get();
    }

    protected function loadFeatureTypes()
    {
        if($this->product && $this->product->features->count()){
            foreach($this->product->features as $feature){
                $product_features[] = $feature->id;
            }
            $features = FeatureType::with('features')
                            ->whereHas('features', function($query) use ($product_features){
                                    $query->whereIn('id', $product_features);
                            })->get();
            return $features;
        }
    }

    public function getCategoryPageOptions(){
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getOrderByOptions()
    {
        $schema = Schema::getColumnListing('istheweb_shop_products');
        foreach ($schema as $column) {
            $options[$column] = ucwords(str_replace('_', ' ', $column));
        }
        return $options;
    }

    public function getSortOptions()
    {
        return [
            'desc' => Lang::get('istheweb.shop::lang.labels.descending'),
            'asc'  => Lang::get('istheweb.shop::lang.labels.ascending'),
        ];
    }



}