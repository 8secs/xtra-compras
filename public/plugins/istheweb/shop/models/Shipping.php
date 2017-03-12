<?php namespace Istheweb\Shop\Models;


/**
 * Shipping Model
 */
class Shipping extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_shippings';


    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    public $belongsTo = [
        'geo_zone' => 'Istheweb\Shop\Models\GeoZone'
    ];

    public $hasManyThrough = [
        /*'countries' => [
            'RainLab\Location\Models\Country',
            'through' => 'Istheweb\Shop\Models\GeoZone'
        ],
        'states' => [
            'RainLab\Location\Models\State',
            'through' => 'Istheweb\Shop\Models\GeoZone'
        ],*/
    ];

}