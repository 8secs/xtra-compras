<?php namespace Istheweb\Shop\Models;

use RainLab\Location\Models\Country;
use RainLab\User\Facades\Auth;
use Str;

/**
 * Customer Model
 */
class Customer extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_customers';


    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'addresses' => 'Istheweb\Shop\Models\Address',
        'orders'    => 'Istheweb\Shop\Models\Order',
    ];
    public $belongsTo = [
        'user' => 'RainLab\User\Models\User',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    /**
     * Automatically creates a customer for a user if not one already.
     * @param  RainLab\User\Models\User $user
     * @return Istheweb\Shop\Models\Customer
     */
    public static function getFromUser($user = null)
    {

        if ($user === null)
            $user = Auth::getUser();

        if (!$user)
            return;

        if (!$user->customer) {

            $customer = Customer::where('user_id', '=', $user->id)->first();

            if(!$customer){
                $generatedUsername = explode('@', $user->email);
                $generatedUsername = array_shift($generatedUsername);
                $generatedUsername = Str::limit($generatedUsername, 24, '') . $user->id;

                $customer = new static;
                $customer->user = $user;
                $customer->username = $generatedUsername;
                $customer->save();

                /**
                 * Check if necessary!!
                 */
                $customer->addresses = static::getAddresses($customer->id);
                $user->customer = $customer;
            }else{
                $customer->addresses = static::getAddresses($customer->id);
                $user->customer = $customer;
            }
        }else{
            $customer = $user->customer;
            $customer->addresses = static::getAddresses($customer->id);

            $user->customer = $customer;
        }
        return $user->customer;
    }

    public function scopeSearchTerm($query)
    {
        return json_encode('hola mundo');
    }

    public function getAddressesOptions(){
        $address = Address::with(['country', 'state'])->where('customer_id', '=', $this->id)->get();
        return $address;
    }

    public static function getAddresses($id){
        $addresses = Address::where('customer_id', '=', $id)->get();
        return $addresses;
    }

    public static function getAddressById($id){

        return Address::where('id', '=', $id)->first();
    }

    public function getDefaultAddress(){

        return Address::where('customer_id', '=', $this->id)->first();
    }

}