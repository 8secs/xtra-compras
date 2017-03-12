<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 12/05/16
 * Time: 9:48
 */

namespace Istheweb\Shop\Traits;

use Auth;
use Illuminate\Support\Facades\Session;
use Istheweb\Shop\Facades\Checkout;
use Istheweb\Shop\Models\Coupon;
use Istheweb\Shop\Models\Currency;
use Istheweb\Shop\Models\Customer;
use Istheweb\Shop\Models\GeoZone;
use Istheweb\Shop\Models\Order;
use Istheweb\Shop\Models\OrderStatus;
use Istheweb\Shop\Models\Shipping;
use Istheweb\Shop\Models\Shop;
use Istheweb\Shop\Models\TaxRate;
use Istheweb\Shop\Models\Product as ShopProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Support\Facades\Flash;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;

trait ShopCartTrait
{

    /**
     * Global shop settings
     * @var shop settings
     */
    public $shop;

    /**
     * @var Country shop object for GeoZone Control
     */
    public $shopCountry;

    /**
     * @var Country of Shop Address
     */
    public $countryAddress;

    /**
     * @var State shop object for GeoZone Control
     */
    public $shopState;

    /**
     * @var State of Shop Address
     */
    public $stateAddress;

    /**
     * @var Currency shop object
     */
    public $shopCurrency;

    /**
     * Shop Geo Zone obtain from Country Shop
     *
     * @var GeoZone
     */
    public $geoZone;

    /**
     * Default tax rate of the shop
     * @var float
     */
    public $taxRateShop;

    /**
     * Default tax rate type of the shop:
     * Options:
     *      P = Percentage
     *      F = Fix Amount
     * @var char
     */
    public $taxRateTypeShop;

    /**
     * Array of shippings based on Shop GeoZone
     * @var array
     */
    public $shippings;

    /**
     * Subtotal amount needed before the free
     * shipping module becomes available
     * @var float
     */
    public $freeShipping;

    /**
     * Selected Shipping Object selected by the user
     * when Free Shipping module is not available
     * @var Shipping Object
     */
    public $selectedShippingRate;

    /**
     * Property use to know items remove from cart
     * @var int
     */

    public $items_removed = 0;

    /**
     * Items in basket
     * @var collection
     */
    public $basketItems;

    /**
     * Total amount with taxes and shipping
     * @var float
     */
    public $basketTotal;

    /**
     * Total amount before taxes and shipping
     * @var float
     */
    public $basketSubtotal;

    /**
     * Total amount basket taxes
     * @var float
     */
    public $basketTaxRate;

    /**
     * Total amount payment fees
     * @var float
     */
    public $basketPaymentFee;

    /**
     * List of payment methods available
     * @var float
     */
    public $paymentMethods;

    /**
     * List of payment methods Fees
     * @var float
     */
    public $paymentMethodFees;

    /**
     * @var int
     */
    public $basketCount = 0;

    /**
     * @var
     */
    public $coupon;

    /**
     * @var
     */
    public $couponDisccount;

    /**
     * @var
     *
     */
    public $checkoutSteps;

    /**
     * Current shop settings.
     *
     * @return void
     */
    public function getShop()
    {
        $this->shop = Shop::instance();

        $this->shopCountry = Country::find($this->shop->country);
        $this->shopState = State::find($this->shop->state);
        $this->shopCurrency = Currency::find($this->shop->currency);
        $this->paymentMethods = $this->getActivePaymentMethods();
        $this->paymentMethodFees = $this->getPaymentMethodFees();
        $this->countryAddress = Shop::get('country-address');
        $this->stateAddress = Shop::get('state-address');
        $this->checkoutSteps = Shop::get('checkoutSteps');

        $this->getGeoZone();
        $this->getTaxRateShop();
        $this->getFreeShipping();
        $this->getShippings();
    }

    public function registerBasketInfo()
    {
        $content = Cart::instance('shopping')->content();
        //dd($content);
        $content->each(function ($row) {
            $product = ShopProduct::with('picture')
                ->where('id', $row->product->id)
                ->first();
            $picture = $product->getRelation('picture');
            $row->slug = $row->product->slug;
            $row->discount = $row->product->discount;
            $row->picture = $picture;
        });

        /**
         * Check shop settings for ajax calls
         * if not shop, get it.
         */
        if(!isset($this->shop)) $this->getShop();

        $this->basketItems = $this->page['basketItems'] = $content;
        $this->basketCount = $this->page['basketCount'] = Cart::instance('shopping')->count();
        $this->basketSubtotal = $this->page['basketSubtotal'] = Cart::instance('shopping')->total();

        $this->calculateTotal();
    }

    public function onAddProduct()
    {
        $id = post('id');
        $quantity = post('quantity') ?: 1;
        $product = ShopProduct::find($id);

        //Cart::instance('shopping')->destroy();
        //Checkout::destroy();

        if($product->on_sale == 1){
            $price = $product->discount;
            $options = ['before' => $product->price];
        }else{
            $price = $product->price;
            $options = [];
        }


        Cart::instance('shopping')->associate('Product', 'Istheweb\Shop\Models')->add(
            $id,
            $product->name,
            $quantity,
            $price,
            $options
        );

        $this->registerBasketInfo();
    }

    public function onUpdateCart()
    {
        $post = post();
        $content = Cart::instance('shopping')->content();

        foreach($content as $row){
            Cart::instance('shopping')->update($row->rowid,
                array('qty' => $post['qty-'.$row->rowid]));
        }
        $this->registerBasketInfo();
    }

    protected function assignQty($post, $index){
        return $post[$index];
    }

    public function onRemoveProduct()
    {
        Cart::instance('shopping')->remove(post('row_id'));

        $this->registerBasketInfo();

        return [
            'total' => $this->basketTotal ?: 0,
            'count' => $this->basketCount ?: 0,
        ];
    }

    public function onApplyCoupon()
    {
        $code = post('code');
        $this->coupon = Coupon::whereCode($code)->first();

        $this->registerBasketInfo();
    }

    public function onPaymentFee()
    {
        $method = post('method');
        Checkout::add('payment_method', $method);
        $this->registerBasketInfo();
    }

    public function onCheckout()
    {
        if (!$this->stockCheck()) {
            return $this->redirectBackWithRemovedError();
        }

        return $this->createOrder();
    }

    protected function removeCartRow($rowId)
    {
        Cart::instance('shopping')->remove($rowId);

        $this->items_removed++;
    }

    protected function formatPrices(&$items, &$total)
    {

        $countryCode = $this->shopCountry->code;
        $currencyCode = $this->shopCurrency->attributes['code'];
        $formatter = new \NumberFormatter(strtolower($countryCode).'_'.strtoupper($countryCode), \NumberFormatter::CURRENCY);

        foreach ($items as $rowId => $item) {
            $items[$rowId]['price'] = $formatter->formatCurrency($item['price'], $currencyCode);
        };

        $this->basketTotal = $formatter->formatCurrency($total, $currencyCode);
    }

    protected function processItems($items)
    {
        foreach ($items as $item) {
            $this->processItem($item);

            if ($this->items_removed > 0) {
                return false;
            }
        }

        return true;
    }

    protected function processItem($item)
    {
        // If the product doesn't exist, or it does exist but is out
        // of stock, we remove it from the cart and return early
        if (! ($p = ShopProduct::find($item->id))
            ||(isset($p) && !$p->inStock())
        ) {
            $this->removeCartRow($item->rowid);

            return;
        }

        if (!$p->is_stockable) {
            return;
        }

        $p->stock -= $item->qty;
        $p->save();
    }

    protected function calculateTotal(){

        $basketTotal = 0.00;
        if($this->basketSubtotal > 0){

            if((float)$this->freeShipping > 0.00){

                if($this->coupon && $this->coupon->shipping == 1){
                    $this->selectedShippingRate = 0.00;
                }else{
                    $basketTotal += $this->getSelectedShippingRate();
                }
            }else{
                $this->selectedShippingRate = 0.00;
            }
        }else{
            $this->selectedShippingRate = 0.00;
        }

        if($this->coupon && $this->coupon->shipping == 0){
            if($this->coupon->type == 'P'){
                $this->couponDisccount = (float)$this->basketSubtotal * (float) $this->coupon->discount / 100;
            }else{
                $this->couponDisccount = (float)$this->coupon->discount;
            }
            $this->basketSubtotal = $this->basketSubtotal - $this->couponDisccount;
        }

        if($this->taxRateTypeShop == 'P')
            $this->basketTaxRate = (float)$this->basketSubtotal * (float)$this->taxRateShop;
        else
            $this->basketTaxRate = (float)$this->taxRateShop;

        $this->basketTotal = ((float)$basketTotal + (float)$this->basketSubtotal + (float)$this->basketTaxRate);

        if(Checkout::has('payment_method')){
            $method = Checkout::get('payment_method');
            $this->basketPaymentFee = $this->basketTotal * $this->getPaymentFee($method);
            $this->basketTotal = $this->basketTotal + $this->basketPaymentFee;
        }
    }

    protected function stockCheck()
    {
        $this->prepareVars();

        $content = Cart::instance('shopping')->content();

        if (!$this->processItems($content)) {
            return false;
        }

        return $content;
    }

    protected function redirectBackWithRemovedError()
    {
        $removed_many = $this->items_removed > 1;

        Flash::error(sprintf(
            "istheweb.shop::lang.labels.redirect_cart_with_errors",
            $this->items_removed,
            ($removed_many ? 'items' : 'item'),
            ($removed_many ? 'were' : 'was')
        ));

        return Redirect::back();
    }

    protected function getGeoZone(){
        $shopCountryId[] = $this->shopCountry->id;
        $this->geoZone = GeoZone::whereHas('countries',
            function($query) use ($shopCountryId) {
                $query->whereIn('id', $shopCountryId);
            })->first();
    }

    protected function getShippings(){
        $this->shippings = Shipping::where('geo_zone_id', $this->geoZone->id)
            ->where('total', '=', 0)
            ->get();
    }

    protected function getFreeShipping(){
        $shipping = Shipping::where('total', '>', 0)
            ->where('geo_zone_id', $this->geoZone->id)
            ->first();
        if(isset($shipping)) $this->freeShipping = $shipping->total;
        else $this->freeShipping = 0;
    }

    protected function getSelectedShippingRate(){

        if(!isset($this->selectedShippingRate)){

            if((float)$this->freeShipping
                > (float)$this->basketSubtotal)
            {
                $shipping = Shipping::where('total', '=', 0)
                    ->where('geo_zone_id', $this->geoZone->id)
                    ->min('cost');
                $this->selectedShippingRate = isset($shipping) ? $shipping : 0.00;
            }else{
                $this->selectedShippingRate = 0.00;
            }
        }
        return $this->selectedShippingRate;
    }

    protected function getTaxRateShop(){
        $taxRate = TaxRate::find($this->shop->tax);
        $rate = $taxRate->rate;
        $type = $taxRate->type;
        $this->taxRateTypeShop = $type;
        if($type === 'P') $this->taxRateShop = $rate / 100;
        else $this->taxRateShop = $rate;
    }

    protected function getActivePaymentMethods()
    {
        $methods = array();
        $shopMethods = $this->shop->getPaymentMethodOptions();

        foreach($shopMethods as $key => $value ){
            $m = Shop::get($key, false);
            if($m == 1){
                $methods = array_add($methods, $key, $value);
            }
        }
        return $methods;
    }

    protected function getPaymentMethodFees()
    {
        $fees = array();

        foreach($this->paymentMethods as $key => $value)
        {
            $fees = array_add($fees, $key, Shop::get($key."_fee"));
        }
        return $fees;
    }

    protected function getPaymentFee($method){
        $fee = array_get($this->paymentMethodFees, $method, 'cash');
        return isset($method) ? $fee / 100 : 0;
    }
}