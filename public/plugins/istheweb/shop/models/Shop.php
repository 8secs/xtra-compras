<?php namespace Istheweb\Shop\Models;

use Illuminate\Support\Facades\Lang;
use October\Rain\Database\Model as BaseModel;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;
use RainLab\Translate\Models\Locale;
use Renatio\DynamicPDF\Models\Template;

/**
 * Shop Model
 */
class Shop extends BaseModel
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_shops';

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'istheweb_shop_shop_settings';

    public $settingsFields = 'fields.yaml';

    public $attachOne = [
        'logo' => ['System\Models\File'],
    ];


    public function getCountryOptions(){
        return Country::where('is_enabled', 1)->lists('name', 'id');
    }

    public function getStateOptions(){

        return State::where('country_id', $this->country)->lists('name', 'id');
    }

    public function getLocaleOptions() {
        return Locale::all()->lists('name', 'id');
    }

    public function getCurrencyOptions(){
        return Currency::all()->lists('name', 'id');
    }

    public function getTaxOptions(){
        return TaxRate::all()->lists('name', 'id');
    }

    public function getLengthOptions() {
        return [
            'centimeter'        => Lang::get('istheweb.shop::lang.labels.centimeter'),
            'millimeter'        => Lang::get('istheweb.shop::lang.labels.millimeter'),
            'inch'              => Lang::get('istheweb.shop::lang.labels.inch'),
        ];
    }

    public function getWeightOptions(){
        return [
            'kilogram'          => Lang::get('istheweb.shop::lang.labels.kilogram'),
            'gram'              => Lang::get('istheweb.shop::lang.labels.gram'),
            'pound'             => Lang::get('istheweb.shop::lang.labels.pound'),
            'ounce'             => Lang::get('istheweb.shop::lang.labels.ounce'),
        ];
    }

    public function getPaymentMethodOptions(){
        return [
            'cash'              => Lang::get('istheweb.shop::lang.labels.cash_delivery'),
            'paypal'            => Lang::get('istheweb.shop::lang.labels.paypal'),
            'tpv'               => Lang::get('istheweb.shop::lang.labels.tarjeta'),
            'stripe'            => Lang::get('istheweb.shop::lang.labels.stripe'),
        ];
    }

    public function getInvoiceTemplatesOptions(){
        $templates = Template::all()->lists('title', 'code');
        return $templates;
    }

    public function getCheckoutStepsOptions(){
        return [
            '2'     => '2',
            '3'     => '3',
            '4'     => '4',
            '5'     => '5'
        ];
    }

}