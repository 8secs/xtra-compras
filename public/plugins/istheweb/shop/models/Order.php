<?php namespace Istheweb\Shop\Models;




/**
 * Order Model
 */
class Order extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_orders';

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
    public $hasOne = [
        'paypal_payment'    => 'Istheweb\Shop\Models\PaypalPayment',
        'tpv_payment'      => 'Istheweb\Shop\Models\TpvPayment'
    ];
    public $hasMany = [

    ];
    public $belongsTo = [
        'order_status'      => 'Istheweb\Shop\Models\OrderStatus',
        'customer'          => ['Istheweb\Shop\Models\Customer'],
        'shipping_address'  => ['Istheweb\Shop\Models\Address'],
        'billing_address'   => ['Istheweb\Shop\Models\Address'],
    ];
    public $belongsToMany = [
        'products'           => [ 'Istheweb\Shop\Models\Product',
            'table'         =>  'istheweb_shop_pivots'
        ]
    ];

    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function afterDelete()
    {
        if($this->products()){
            $this->products()->detach();
        }
        $tpv_payment = TpvPayment::where('order_id', '=', $this->id)->first();
        if(isset($tpv_payment)){
            $tpv_payment->delete();
        }

        $paypal_payment = PaypalPayment::where('order_id', '=', $this->id)->first();
        if(isset($paypal_payment)){
            $paypal_payment->delete();
        }
    }


    public function getPaymentMethodOptions(){
        $shop = Shop::instance();
        $payment_methods = $shop->getPaymentMethodOptions();
        return $payment_methods;
    }

    public function getShippingAddressOptions(){

        //return json_encode("shippingAddress");
        if(!$this->customer()) $addresses = array();
        else $addresses = Customer::getAddresses($this->customer()->id);
        return $addresses;
    }

    public function getBillingAddressOptions(){
        //return json_encode("billingAddress");
        if(!$this->customer()) $addresses = array();
        else $addresses = Customer::getAddresses($this->customer()->id);
        return $addresses;
    }

    public function getCountryOptions(){
        return Country::where('is_enabled', 1)->get();
    }

    public function getStatesOptions()
    {
        return State::where($this->country())->lists('name', 'id', 'code');

    }

}