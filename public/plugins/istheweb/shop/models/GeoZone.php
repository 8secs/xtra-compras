<?php namespace Istheweb\Shop\Models;

use RainLab\Location\Models\State;
use RainLab\Location\Models\Country;

/**
 * GeoZone Model
 */
class GeoZone extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_geo_zones';

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'taxRates' => 'Istheweb\Shop\Models\TaxRate',
        'shippings' => 'Istheweb\Shop\Models\Shipping',
    ];
    public $belongsTo = [];
    public $belongsToMany = [
        'countries' => [
            'RainLab\Location\Models\Country',
            'table' => 'istheweb_shop_geo_zones_countries',
        ],
        'states' => [
            'RainLab\Location\Models\State',
            'table' => 'istheweb_shop_geo_zones_states',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function afterDelete()
    {
        if($this->countries()) $this->countries()->detach();
        if($this->states()) $this->states()->detach();
    }

    public function getCountriesOptions(){
        return Country::where('is_enabled', 1)->get();
    }

    public function getStatesOptions()
    {
        return State::where($this->countries())->lists('name', 'id', 'code');

    }

}