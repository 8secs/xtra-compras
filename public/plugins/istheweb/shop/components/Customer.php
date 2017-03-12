<?php namespace Istheweb\Shop\Components;

use Illuminate\Support\Facades\Session;
use Istheweb\Shop\Models\Address;
use istheweb\shop\traits\StripeTrait;
use Lang;
use Auth;
use Mail;
use Event;
use Flash;
use Input;
use Checkout;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;
use RainLab\User\Components\Account;
use RainLab\User\Models\User;
use Request;
use Redirect;
use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use RainLab\User\Models\Settings as UserSettings;
use Exception;
use Istheweb\Shop\Models\Customer as CustomerModel;
use Istheweb\Shop\Models\Order;
use Istheweb\Shop\Models\Shop;
use Istheweb\Shop\Traits\OrderTrait;
use Istheweb\Shop\Traits\PayPalTrait;
use istheweb\shop\traits\WishlistTrait;


class Customer extends Account
{
    use OrderTrait, PayPalTrait, WishlistTrait;

    /**
     * List of available countries
     * @var \RainLab\Location\Models\Country
     */
    public $countries;

    /**
     * List of States of billing Address
     * @var \RainLab\Location\Models\State
     */
    public $billingStates;

    /**
     * List of States of delivery Address
     * @var \RainLab\Location\Models\State
     */
    public $deliveryStates;

    /**
     * Selected index state of billing address
     * @var integer
     */
    public $selectedBillingState;

    /**
     * Selected index state of delivery address
     * @var
     */
    public $selectedDeliveryState;

    /**
     * Billing Address
     * @var \Istheweb\Shop\Models\Address
     */
    public $billingAddress;

    /**
     * Delivery Address
     * @var \Istheweb\Shop\Models\Address
     */
    public $deliveryAddress;

    /**
     * Selected step in Checkout
     * @var int
     */
    public $selectedStep;

    /**
     * Differents addresses Billing and Delivery
     * @var bool
     */
    public $notSameAddress;

    /**
     * Tipo de dirección: billing / delivery
     * @var String
     */
    public $addressType;

    /**
     * Customer
     * @var \Istheweb\Shop\Models\Customer
     */
    public $customer;

    /**
     * @var
     */
    public $paymentMethod;

    /**
     * @var
     *
     */
    public $shopCheckoutSteps;



    public function componentDetails()
    {
        return [
            'name'        => 'istheweb.shop::lang.components.customer.name',
            'description' => 'istheweb.shop::lang.components.customer.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'redirect' => [
                'title'       => 'istheweb.shop::lang.customer.redirect_to',
                'description' => 'istheweb.shop::lang.customer.redirect_to_desc',
                'type'        => 'dropdown',
                'default'     => ''
            ],
            'paramCode' => [
                'title'       => 'istheweb.shop::lang.customer.code_param',
                'description' => 'istheweb.shop::lang.customer.code_param_desc',
                'type'        => 'string',
                'default'     => 'code'
            ]
        ];
    }

    public function init(){
        $shop = Shop::instance();
        $this->shopCheckoutSteps = $shop->checkoutSteps;
    }

    public function onRun()
    {

        parent::onRun();

        //print_r(Session::get('checkout'));

        $this->registerWishlistInfo();

        $this->getCountries();
        //Checkout::add('selectedStep', 2);
        $this->customer();
        //dd(Checkout::content());

        if(Checkout::has('billing_address_id')){
            $this->billingAddress = Address::find(Checkout::get('billing_address_id'));
            $this->selectedBillingState = $this->billingAddress->state_id;
            $this->getCountryStates($this->billingAddress->country_id, 'billing');

        }

        if(Checkout::has('shipping_address_id')){
            $this->deliveryAddress = Address::find(Checkout::get('shipping_address_id'));
            $this->selectedDeliveryState = $this->deliveryAddress->state_id;
            $this->getCountryStates($this->deliveryAddress->country_id, 'delivery');

        }

        if(Checkout::has('payment_method')){
            $this->paymentMethod = Checkout::get('payment_method');
            Checkout::add('selectedStep', $this->shopCheckoutSteps);
        }
        $this->selectedStep = Checkout::get('selectedStep');
        if(Checkout::has('not-same-address')) $this->notSameAddress = true;
    }

    public function user(){
        return parent::user();
    }


    public function customer(){
        $customer = CustomerModel::getFromUser($this->user());
        if($customer){
            if(!Checkout::has('customer_id')) {
                Checkout::add('customer_id', $customer->id);
                Checkout::add('selectedStep', 2);
            }
        }else {
            if(Checkout::has('customer_id')){
                Checkout::destroy();
            }
            Checkout::add('selectedStep', 1);
        }
        return $customer;
    }

    public function onRegisterCustomer()
    {
        $rules = [];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('checkout')->withErrors($validator);
        }

        /*
         * Register user
         */
        $requireActivation = UserSettings::get('require_activation', true);
        $automaticActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
        $userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;

        $pass = str_random(16);
        $u = [
            'name'                  => post('name'),
            'surname'               => post('surname'),
            'email'                 => post('email'),
            'username'              => post('email'),
            'password'              => $pass,
            'password_confirmation' => $pass
        ];


        try{
            $user = Auth::register($u, $automaticActivation);

            /*
             * Activation is by the user, send the email
             */
            if ($userActivation) {
                $this->sendActivationEmail($user, $pass);

                Flash::success(Lang::get('rainlab.user::lang.account.activation_email_sent'));
            }

            if($user){
                /*
                 * Automatically activated or not required, log the user in
                 */
                if ($automaticActivation || !$requireActivation) {
                    Auth::login($user);
                }
                $customer = $this->createCustomer($user);

                $type = post('type');

                if($type){
                    $address = new Address();
                    $address->address_1 = post('address_1_'.$type);
                    $address->city = post('city_'.$type);
                    $address->postcode = post('postcode_'.$type);
                    $address->country_id = post('countries_'.$type);
                    $address->state_id = post('states_'.$type);

                    $customer->addresses()->save($address);

                    if($type == 'billing'){
                        Checkout::add('billing_address_id', $address->id);
                        $this->billingAddress = Address::find($address->id);
                        Checkout::add('shipping_address_id', $address->id);
                        $this->deliveryAddress = Address::find($address->id);
                    }
                }

                Checkout::add('customer_id', $customer->id);
                Checkout::add('selectedStep', 2);

                Flash::success(post('flash', Lang::get('istheweb.shop::lang.customer.success_saved')));
            }

            $redirectUrl = $this->pageUrl($this->property('redirect'))
                ?: $this->property('redirect');

            if ($redirectUrl = post('redirect', $redirectUrl)) {
                return Redirect::intended($redirectUrl);
            }

        }catch (Exception $ex){
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    /**
     * Register the user
     */
    public function onRegister()
    {
        parent::onRegister();

        $rules = [];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('checkout')->withErrors($validator);
        }

        try{
            $user = $this->user();
            if($user){

                $customer = $this->createCustomer($user);

                Checkout::add('customer_id', $customer->id);
                Checkout::add('selectedStep', 2);

            }
            /**
             * Formulario de registro con Address
             */
            $type = post('type');
            if(isset($type) && $type == 'billing'){
                $address = new Address();
                $address->address_1 = post('address_1_'.$type);
                $address->address_2 = post('address_2_'.$type);
                $address->city = post('city_'.$type);
                $address->postcode = post('postcode_'.$type);
                $address->country_id = post('countries_'.$type);
                $address->state_id = post('states_'.$type);

                $customer->addresses()->save($address);
                Checkout::add('billing_address_id', $address->id);
                $this->billingAddress = Address::find($address->id);
            }

            /*
             * Redirect to the intended page after successful sign in
             */
            $redirectUrl = $this->pageUrl($this->property('redirect'))
                ?: $this->property('redirect');

            if ($redirectUrl = post('redirect', $redirectUrl)) {
                return Redirect::intended($redirectUrl);
            }
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    protected function createCustomer($user)
    {
        $customer = new CustomerModel();
        $customer->user = $user;
        $customer->name = $user->name;
        $customer->surname = $user->surname;
        $customer->email = $user->email;
        $customer->username = $user->username;
        $customer->phone = post('phone');
        $customer->cif = post('cif');
        $customer->save();

        return $customer;
    }

    /**
     * Update the user
     */
    public function onUpdate()
    {
        if (!$user = $this->user()) {
            return;
        }

        $user->fill(post());
        $user->save();

        $customer = $this->customer();
        $customer->phone = post('phone');
        $customer->save();

        /*
         * Password has changed, reauthenticate the user
         */
        if (strlen(post('password'))) {
            Auth::login($user->reload(), true);
        }

        Flash::success(post('flash', Lang::get('istheweb.shop::lang.customer.success_saved')));

        /*
         * Redirect
         */
        if ($redirect = $this->makeRedirection()) {
            return $redirect;
        }
    }

    public function onAddress(){

        $type = post('type');

        if(!$user = $this->user()) return;

        if(!$customer = $this->customer()) return;

        $address = $this->setAddress($type, post('id'));
        $customer->addresses()->save($address);

        if($type){

            if($type == 'billing'){
                Checkout::add('billing_address_id', $address->id);
                $this->billingAddress = Address::find($address->id);

                if(!post('not-same-address')){
                    Checkout::add('shipping_address_id', $address->id);
                    $this->deliveryAddress = Address::find($address->id);
                    Checkout::add('selectedStep', 4);
                }else{
                    Checkout::add('selectedStep', 3);
                    Checkout::add('not-same-address', 1);
                }
            }
            if($type == 'delivery'){
                Checkout::add('shipping_address_id', $address->id);
                $this->deliveryAddress = Address::find($address->id);
                Checkout::add('selectedStep', 4);
            }

        }

        Flash::success(post('flash', Lang::get('istheweb.shop::lang.customer.success_saved')));

        /*
         * Redirect
         */
        if ($redirect = $this->makeRedirection()) {
            return $redirect;
        }
    }

    public function setAddress($type, $id = null){

        if(!$id){
            $address = new Address();
        }else{
            $address = Address::find($id);
        }
        $address->address_1 = post('address_1_'.$type);
        $address->address_2 = post('address_2_'.$type);
        $address->city = post('city_'.$type);
        $address->postcode = post('postcode_'.$type);
        $address->country_id = post('countries_'.$type);
        $address->state_id = post('states_'.$type);
        return $address;
    }

    public function onAddressChange(){
        $this->addressType = post('type');
        $this->getCountries();
        if($this->addressType == 'billing') {
            $this->billingAddress = CustomerModel::getAddressById(post('addresses_'.$this->addressType));
            $this->selectedBillingState = $this->billingAddress->state_id;
            $this->getCountryStates($this->billingAddress->country_id, $this->addressType);
        }
        else {
            $this->deliveryAddress = CustomerModel::getAddressById(post('addresses_'.$this->addressType));
            $this->selectedDeliveryState = $this->deliveryAddress->state_id;
            $this->getCountryStates($this->deliveryAddress->country_id, $this->addressType);
        }
    }

    public function onPaymentMethod(){

        $this->paymentMethod = post('payment_method');
        $comment = post('comment');
        Checkout::add('payment_method', $this->paymentMethod);
        Checkout::add('comment', $comment);
        Checkout::add('selectedStep', $this->shopCheckoutSteps);

        Flash::success(post('flash', Lang::get('istheweb.shop::lang.customer.success_saved')));

        if ($redirect = $this->makeRedirection()) {
            return $redirect;
        }
    }

    public function onCompleteCheckout()
    {
        if(!$user = $this->user()) return;

        if(!$customer = $this->customer()) return;

        $billingAddress = $this->setAddress('billing', post('id_billing'));
        $customer->addresses()->save($billingAddress);
        $del_address = post('address_1_delivery');
        if(isset($del_address) == false){
            $this->billingAddress = Address::find($billingAddress->id);
            $this->deliveryAddress = Address::find($billingAddress->id);
        }else{
            $deliveryAddress = $this->setAddress('delivery', post('id_delivery'));
            $customer->addresses()->save($deliveryAddress);
            $this->deliveryAddress = Address::find($deliveryAddress->id);
        }
        Checkout::add('billing_address_id', $billingAddress->id);
        Checkout::add('shipping_address_id', $this->deliveryAddress->id);
        return [
            'msg'   => 'Success',
            'data'  => post(),
            'error' => 0
        ];
    }

    public function getCountries(){
        $address = new Address();
        $this->countries = $address->getCountriesOptions();
    }

    public function getCountryStates($country_id, $addressType){
        $states = State::where('country_id', '=', $country_id)->get();
        if($addressType == 'billing') $this->billingStates = $states;
        else $this->deliveryStates = $states;
    }

    public function onCountryChange(){
        $this->addressType = post('addressType');
        $countryID = post('country_'.$this->addressType);
        $this->getCountryStates($countryID, $this->addressType);
    }

    /**
     * Trigger a subsequent activation email
     */
    public function onSendActivationEmail()
    {
        try {
            if (!$user = $this->user()) {
                throw new ApplicationException(Lang::get('istheweb.shop::lang.customer.login_first'));
            }

            if ($user->is_activated) {
                throw new ApplicationException(Lang::get('istheweb.shop::lang.customer.already_active'));
            }

            Flash::success(Lang::get('istheweb.shop::lang.customer.activation_email_sent'));

            $this->sendActivationEmail($user);

        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }

        /*
         * Redirect
         */
        if ($redirect = $this->makeRedirection()) {
            return $redirect;
        }
    }

    public function onActivate($code = null)
    {
        parent::onActivate($code);

        Checkout::add('selectedStep', 2);
    }

    /**
     * Sends the activation email to a user
     * @param  User $user
     * @return void
     */
    protected function sendActivationEmail($user, $pass = null)
    {
        $code = implode('!', [$user->id, $user->getActivationCode()]);
        $link = $this->currentPageUrl([
            $this->property('paramCode') => $code
        ]);

        //$vars = $this->notificationVars;

        $data = [
            'name' => $user->name,
            'link' => $link,
            'code' => $code,
            'vars' => $this->getNotificationVars($user, $pass)
        ];

        Mail::send('istheweb.shop::mail.activate', $data, function($message) use ($user) {
            $message->to($user->email, $user->name);
        });
    }

    protected function getNotificationVars($user, $pass)
    {
        $vars = [
            'name'  => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'login' => $user->getLogin(),
            'password' => $pass,
        ];

        return $vars;
    }

}