<?php namespace Istheweb\Shop\Models;


/**
 * Coupon Model
 */
class Coupon extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_coupons';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'products' => [
            'Istheweb\Shop\Models\Product',
            'table' => 'istheweb_shop_pivots',
        ],
        'categories' => ['Istheweb\Shop\Models\Category',
            'table' => 'istheweb_shop_pivots',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function afterDelete()
    {
        if($this->products()) $this->products()->detach();
        if($this->categories()) $this->categories()->detach();
    }

    public function getProductsOptions(){
        return Product::all()->list('name', 'id');
    }

    public function getCategoriesOptions()
    {
        return Category::all()->lists('name', 'id');

    }

}