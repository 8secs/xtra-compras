<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 18/11/16
 * Time: 13:05
 */

namespace istheweb\shop\traits;


use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Lang;
use Redirect;
use Illuminate\Support\Facades\Session;
use Istheweb\Shop\Facades\Checkout;
use Istheweb\Shop\Models\Currency;
use Istheweb\Shop\Models\OrderStatus;
use Istheweb\Shop\Models\Shop;
use Istheweb\Shop\Models\StripePayment;
use October\Rain\Support\Facades\Flash;
use Stripe\Stripe;

trait StripeTrait
{

    public function createStripePayment(){
        $shop = Shop::instance();
        $api_key = $shop->get('stripe_api_id');

        \Stripe\Stripe::setApiKey($api_key);
        $token = post('stripeToken');

        $amount = $this->getAmountBasket();
        $currency = Currency::find($this->shop->currency);

        // Create a Customer
        $customer = \Stripe\Customer::create(array(
                "source"    => $token,
                'email'     => $this->order->customer->email,
                "description" => $this->order->customer->name)
        );

        try {
            $charge = \Stripe\Charge::create(
                array(
                    "amount" => $amount, // Amount in cents
                    "currency" => $currency->isocode,
                    "customer" => $customer->id,
                    "description" => "Compra realizada: " . $customer->email,
                    "metadata" =>
                        array(
                            "order_id" => $this->order->id,
                            'invoice' => $this->order->invoice)
                )
            );
            if($charge->status === 'succeeded'){

                $payment = new StripePayment();
                $payment->charge_id = $charge->id;
                $payment->customer_id = $charge->customer;
                $payment->order_id = $this->order->id;
                $payment->state = $charge->status;
                $payment->save();

                $status_approved = OrderStatus::where('state', '=', 'approved')->first();
                $this->order->order_status()->associate($status_approved);

                $this->send();

                $this->order->invoice = date('Y'). '-'.$this->getOrdersYearCount();
                $this->order->save();
                //$this->order = $order;

                Cart::instance('shopping')->destroy();
                Checkout::destroy();
                Session::forget('checkout');

                Session::put('order', $this->order->id);

                Flash::success(Lang::get('istheweb.shop::lang.labels.compra_ok_msg'));
                return [
                   'error'      => 0,
                    'msg'       => Lang::get('istheweb.shop::lang.labels.compra_ok_msg')
                ];
            }else{
                $status_cancelled = OrderStatus::where('state', '=', 'cancel')->first();
                $this->order->order_status()->associate($status_cancelled);
                $this->order->save();
                Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
                return Redirect::to('checkout');

            }
        } catch(\Stripe\Error\Card $e) {

            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $msg = 'Status is:' . $e->getHttpStatus() . "\n";
            $msg .= 'Type is:' . $err['type'] . "\n";
            $msg .= 'Code is:' . $err['code'] . "\n";
            $msg .= 'Param is:' . $err['param'] . "\n";
            $msg .= 'Message is:' . $err['message'] . "\n";

            $status_cancelled = OrderStatus::where('state', '=', 'cancel')->first();

            $this->order->order_status()->associate($status_cancelled);
            $this->order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            Flash::error($msg);
            return Redirect::to('checkout');
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $this->order->order_status()->associate($status_cancelled);
            $this->order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            Flash::error($e->getCode() . " - " . $e->getMessage());
            return Redirect::to('checkout');
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $this->order->order_status()->associate($status_cancelled);
            $this->order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            Flash::error($e->getCode() . " - " . $e->getMessage());
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $this->order->order_status()->associate($status_cancelled);
            $this->order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            Flash::error($e->getCode() . " - " . $e->getMessage());
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $this->order->order_status()->associate($status_cancelled);
            $this->order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            Flash::error($e->getCode() . " - " . $e->getMessage());
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $this->order->order_status()->associate($status_cancelled);
            $this->order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            Flash::error($e->getCode() . " - " . $e->getMessage());
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $this->order->order_status()->associate($status_cancelled);
            $this->order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            Flash::error($e->getCode() . " - " . $e->getMessage());
        }
    }
}