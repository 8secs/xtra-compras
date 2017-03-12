<?php namespace Istheweb\Shop\Models;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;


/**
 * Address Model
 */
class Address extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_addresses';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];
    /**
     * @var array Relations
     */
    public $hasOne = [

    ];
    public $hasMany = [

    ];
    public $belongsTo = [
        'customer'          => 'Istheweb\Shop\Models\Customer',
        'order'             => 'Istheweb\Shop\Models\Order',
        'country'           => 'RainLab\Location\Models\Country',
        'state'             => 'RainLab\Location\Models\State',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getCountryOptions(){

        //print_r(Country::where('is_enabled', 1)->get());


        return Country::where('is_enabled', 1)->lists('name', 'id', 'code');
    }

    public function getCountriesOptions(){
        return Country::where('is_enabled', 1)->get();
    }

    public function getStateOptions()
    {
        if($this->country){
            $data = State::where('country_id', '=', $this->country->id)->lists('name', 'id', 'code');
        }else{
            $spain = Country::find(9);
            $data = State::where('country_id', '=', $spain->id)->lists('name', 'id', 'code');
        }

        return $data;

    }

}