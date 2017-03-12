<?php namespace Istheweb\Shop\Components;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Istheweb\Shop\Facades\Checkout;
use Istheweb\Shop\Models\Order;
use Istheweb\Shop\Traits\OrderTrait;
use istheweb\shop\traits\PayPalTrait;
use Istheweb\Shop\Traits\ShopCartTrait;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use istheweb\shop\traits\StripeTrait;
use istheweb\shop\traits\TpvTrait;

class Basket extends ComponentBase
{
    use ShopCartTrait, OrderTrait, PayPalTrait, TpvTrait, StripeTrait;

    public function componentDetails()
    {
        return [
            'name'        => 'istheweb.shop::lang.components.basket.name',
            'description' => 'istheweb.shop::lang.components.basket.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'checkoutPage' => [
                'title'       => 'Checkout Page',
                'description' => 'Name of the page to redirect to when a user clicks Proceed to Checkout.',
                'type'        => 'dropdown',
                'default'     => 'shop/checkout',
                'group'       => 'Links',
            ],
            'productPage' => [
                'title'       => 'Product Page',
                'description' => 'Name of the product page for the product titles.',
                'type'        => 'dropdown',
                'default'     => 'shop/product',
                'group'       => 'Links',
            ],
            'recipientName' => [
                'title'       => 'Recipient Name',
                'description' => 'Name of the person to receive order confirmations',
                'group'       => 'Order confirmation email',
            ],
            'recipientEmail' => [
                'title'       => 'Recipient Email',
                'description' => 'Email address to receive order confirmation emails',
                'group'       => 'Order confirmation email',
            ],
            'paypalReturnUrl' => [
                'title'       => 'Paypal Return URL',
                'description' => 'Success return URL',
                'group'       => 'Paypal Redirect URLS',
            ],
            'paypalCancelUrl' => [
                'title'       => 'Paypal Cancel URL',
                'description' => 'Cancel return URL',
                'group'       => 'Paypal Redirect URLS',
            ],
            'paypalDescription' => [
                'title'       => 'Paypal Description',
                'description' => 'Paypal default transaction description. ',
                'group'       => 'Paypal Redirect URLS',
            ],
        ];
    }

    public function getCheckoutPageOptions()
    {
        return $this->getPagesDropdown();
    }

    public function getProductPageOptions()
    {
        return $this->getPagesDropdown();
    }

    public function getPagesDropdown()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->prepareVars();
    }

    public function prepareVars()
    {
        $this->getShop();
        $this->registerBasketInfo();
        $this->setApiContext();
        $this->recipientEmail = $this->page['recipientEmail'] = $this->property('recipientEmail');
        $this->recipientName = $this->page['recipientName'] = $this->property('recipientName');
        $this->paypalReturnUrl = $this->page['paypalReturnUrl'] = $this->property('paypalReturnUrl');
        $this->paypalCancelUrl = $this->page['paypalCancelUrl'] = $this->property('paypalCancelUrl');
        $this->paypalDescription = $this->page['paypalDescription'] = $this->property('paypalDescription');

        //Session::flush();

        if(Session::has('order')){
            $this->order = Order::find(Session::get('order'));
            Session::forget('order');
            return Redirect::to('shop/order');
        }

        if(Checkout::has('paypal_payment_id')){
            if(get()){
                return $this->executePayment();
            }
        }else if(Checkout::has('tpv_payment_id')){
            if(get()) {
                $this->executeTpvPayment();
            }
        }
    }
}