<?php namespace Istheweb\Shop\Models;

use App;
use Carbon\Carbon;
use istheweb\rating\contracts\Ratingable;
use Str;
use Html;
use Lang;
use Illuminate\Support\Facades\DB;

/**
 * Product Model
 */
class Product extends Model implements Ratingable
{
    use \October\Rain\Database\Traits\Validation, \istheweb\rating\traits\Ratingable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_products';

    /**
     * @var array Validation rules
     */
    protected $rules = [
        'name' => ['required', 'between:4,255'],
        'slug' => [
            'required',
            'alpha_dash',
            'between:1,255',
            'unique:istheweb_shop_products'
        ],
        'price' => ['numeric', 'max:99999999.99'],
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * The attributes on which the project list can be ordered
     * @var array
     */
    public static $allowedSortingOptions = array(
        'name asc' => 'Title (ascending)',
        'name desc' => 'Title (descending)',
        'price asc' => 'Price (ascending)',
        'price desc' => 'Price (descending)',
        'published_at asc' => 'Published (ascending)',
        'published_at desc' => 'Published (descending)',
        'random' => 'Random'
    );

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'orders' => ['Istheweb\Shop\Models\Order',
            'table' => 'istheweb_shop_pivots',
        ],
        'features' => ['Istheweb\Shop\Models\Feature',
            'table' => 'istheweb_shop_pivots',
        ],
        'categories' => ['Istheweb\Shop\Models\Category',
            'table' => 'istheweb_shop_pivots',
        ],
        'filters' => ['Istheweb\Shop\Models\Filter',
            'table' => 'istheweb_shop_pivots',
        ],
        'coupons' => [
            'Istheweb\Shop\Models\Coupon',
            'table' => 'istheweb_shop_pivots'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'picture' => ['System\Models\File'],
    ];
    public $attachMany = [
        'pictures' => ['System\Models\File'],
    ];


    public function inStock()
    {
        if (!$this->is_stockable) {
            return true;
        }

        return $this->stock > 0;
    }

    public function outOfStock()
    {
        return !$this->inStock();
    }

    public function getSquareThumb($size, $image)
    {
        return $image->getThumb($size, $size, ['mode' => 'crop']);
    }

    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        if (array_key_exists('categories', $this->getRelations())) {
            $params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
        }

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    public function beforeSave()
    {
        $postProduct = post('Product');
        if(strlen($postProduct['published_at']) == 0) $this->published_at = Carbon::now();
    }

    public function afterDelete()
    {
        if($this->picture) $this->picture->delete();
        if($this->pictures ){
            foreach ($this->pictures as $item) {
                $item->delete();
            }
        }
        if($this->files){
            foreach ($this->files as $item) {
                $item->delete();
            }
        }

        if($this->categories()) $this->categories()->detach();
        if($this->filters()) $this->filters()->detach();
        if($this->coupons()) $this->coupons()->detach();
        if($this->orders()) $this->orders()->detach();
        if($this->features()) $this->features()->detach();
    }

    public function getCategoriesOptions()
    {
        return Category::all()->lists('name', 'id');

    }

    public function getFiltersOptions(){
        return Filter::all()->list('name', 'id');
    }

    public function getCouponsOptions(){
        return Coupon::all()->list('name', 'id');
    }

    public function getFeaturesOptions(){
        return Feature::all()->list('name', 'id');
    }

    /**
     * Lists products for the front end
     * @param  array $options Display options
     * @return self
     */
    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'       => 1,
            'perPage'    => 30,
            'sort'       => 'created_at',
            'categories' => null,
            'category'   => null,
            'filters'    => null,
            'search'     => '',
            'prices'     => [0,300],
        ], $options));

        //print_r($options);

        $searchableFields = ['name', 'slug', 'modelo', 'description'];

        /*
         * Sorting
         */

        if (!is_array($sort)) {
            $sort = [$sort];
        }
        //dd($sort);

        foreach ($sort as $_sort) {

            if (in_array($_sort, array_keys(self::$allowedSortingOptions))) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                if ($sortField == 'random') {
                    $sortField = DB::raw('RAND()');
                }
                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }

        /*
         * Categories
         */
        if ($categories !== null) {
            if (!is_array($categories)) $categories = [$categories];
            $query->whereHas('categories', function($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        /*
         * Category, including children
         */
        if ($category !== null) {
            $category = Category::find($category);
            if($category){
                $categories = $category->getAllChildrenAndSelf()->lists('id');
                $query->whereHas('categories', function($q) use ($categories) {
                    $q->whereIn('id', $categories);
                });
            }
        }

        if($filters !== null) {
            if(!is_array($filters)) $filters = [$filters];
            $query->whereHas('filters', function($q) use ($filters) {
                $q->whereIn('id', $filters);
            });
        }

        if($prices !== null){
            $query->whereBetween('price', $prices);
        }

        return $query->paginate($perPage, $page);
    }

    /**;
     * Allows filtering for specifc categories
     * @param  \Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return \Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories)
    {
        return $query->whereHas('categories', function($q) use ($categories) {
            $q->whereIn('id', $categories);
        });
    }

}