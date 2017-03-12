<?php namespace Istheweb\Shop\Models;


/**
 * Features Model
 */
class Feature extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_features';

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
        'feature_type' => 'Istheweb\Shop\Models\FeatureType',
    ];
    public $belongsToMany = [
            'products'           => [ 'Istheweb\Shop\Models\Product',
                'table'         =>  'istheweb_shop_pivots'
            ]
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

}