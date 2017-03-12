<?php namespace Istheweb\Shop\Models;

use Carbon\Carbon;


/**
 * Filter Model
 */
class Filter extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_filters';

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
    public $belongsTo = [
        'filter_type' => 'Istheweb\Shop\Models\FilterType',
    ];
    public $belongsToMany = [
        'products' => ['Istheweb\Shop\Models\Product',
            'table' => 'istheweb_shop_pivots',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeSave()
    {
        $postFilter = post('Filter');
        if(strlen($postFilter['published_at']) == 0) $this->published_at = Carbon::now();
    }

    public function afterDelete()
    {
        if($this->products()) $this->products()->detach();
    }

    public function getProductsOptions()
    {
        return Product::all()->lists('name', 'id');
    }

}