<?php namespace Istheweb\Shop\Models;


/**
 * FeatureType Model
 */
class FeatureType extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_feature_types';

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
    public $hasMany = [
        'features'          => 'Istheweb\Shop\Models\Feature',
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];



}