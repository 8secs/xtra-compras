<?php namespace Istheweb\Shop\Models;

use Backend\Models\ExportModel;
use ApplicationException;

/**
 * ProductExport Model
 */
class ProductExport extends ExportModel
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_products';

    /**
     * @var array Relations
     */

    public $belongsToMany = [
        'product_categories' => [
            'Istheweb\Shop\Models\Category',
            'table' => 'istheweb_shop_pivots',
            'key' => 'product_id',
            'otherKey' => 'category_id'
        ],
        'product_filters' => [
            'Istheweb\Shop\Models\Filter',
            'table' => 'istheweb_shop_pivots',
            'key' => 'product_id',
            'otherKey' => 'filter_id'
        ],
        'product_features' => [
            'Istheweb\Shop\Models\Feature',
            'table' => 'istheweb_shop_pivots',
            'key' => 'product_id',
            'otherKey' => 'feature_id'
        ]
    ];

    /**
     * The accessors to append to the model's array form.
     * @var array
     */
    protected $appends = [
        'categories',
        'filters',
        'features'
    ];


    public function exportData($columns, $sessionKey = null)
    {
        $result = self::make()
            ->with([
                'product_categories',
                'product_filters',
                'product_features'
            ])
            ->get()
            ->toArray()
        ;
        //print_r($result);die();
        return $result;
    }

    public function getCategoriesAttribute()
    {
        if (!$this->product_categories) return '';
        return $this->encodeArrayValue($this->product_categories->lists('name'));
    }

    public function getFiltersAttribute()
    {
        if (!$this->product_filters) return '';
        return $this->encodeArrayValue($this->product_filters->lists('name'));
    }

    public function getFeaturesAttribute()
    {
        if(!$this->product_features) return '';
        return $this->encodeArrayValue($this->product_features->lists('name'));
    }

}