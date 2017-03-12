<?php namespace Istheweb\Shop\Models;


/**
 * TaxRate Model
 */
class TaxRate extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_tax_rates';

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
        'geo_zone' => 'Istheweb\Shop\Models\GeoZone'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}