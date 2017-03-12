<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 17/05/16
 * Time: 10:06
 */

namespace Istheweb\Shop\Traits;

use Backend\Models\BrandSetting;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Flash;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use Renatio\DynamicPDF\Classes\PDF;
use Renatio\DynamicPDF\Models\Template;
use Istheweb\Shop\Facades\Checkout;
use Istheweb\Shop\Models\Address;
use Istheweb\Shop\Models\Customer;
use Istheweb\Shop\Models\Order;
use Istheweb\Shop\Models\OrderStatus;
use Istheweb\Shop\Models\PaypalPayment;


trait OrderTrait
{

    public $order;

    public function createOrder()
    {
        $content = Cart::instance('shopping')->content()->toArray();
        $total = $this->basketTotal;

        $this->formatPrices($content, $total);

        $customer = Customer::getFromUser();
        Checkout::add('recipientEmail', post('email'));

        $this->calculateTotal();

        $payment_method = Checkout::content()->get('payment_method');

        if($payment_method == 'cash') $status_payment = 'Reembolso';
        else $status_payment = trim(ucfirst($payment_method));

        $status = trim(ucwords('nuevo pedido')) . " - " . $status_payment;
        $new_order_status = OrderStatus::where('name', '=', $status)->first();

        $this->order = new Order();
        $this->order->order_status()->associate($new_order_status);
        $this->order->customer()->associate($customer);
        $this->order->payment_method = Checkout::get('payment_method');
        $this->order->billing_address_id = Checkout::get('billing_address_id');
        $this->order->shipping_address_id = Checkout::get('shipping_address_id');
        $this->order->tax = $this->basketTaxRate;
        $this->order->shipping = $this->selectedShippingRate;
        $this->order->subtotal = $this->basketSubtotal;
        $this->order->total = $this->basketTotal;
        $this->order->comment = Checkout::get('comment');
        $this->order->invoice = "";


        $this->order->save();

        Checkout::add('order_id', $this->order->id);

        foreach($this->basketItems as $item){
            $this->order->products()->attach($item->id);
        }

        switch ($payment_method) {
            case 'paypal':
                return $this->createPaypalPayment();
            case 'cash':
                $this->send();
                $this->order->invoice = date('Y'). '-'.$this->getOrdersYearCount();
                $this->order->save();

                Cart::instance('shopping')->destroy();
                Checkout::destroy();
                Session::forget('checkout');
                //Checkout::add('order_id', $this->order->id);

                Flash::success(Lang::get('istheweb.shop::lang.labels.compra_ok_msg'));
                return Redirect::to('shop/order')->with('order', $this->order->id);
            case 'tpv':
                return $this->createTpvPayment();
            case 'stripe':
                return $this->createStripePayment();
            default:
                break;
        }
    }

    public function send(){
        $customer = Customer::find(Checkout::get('customer_id'));
        $billing_address = Address::find(Checkout::get('billing_address_id'));
        $delivery_address = Address::find(Checkout::get('shipping_address_id'));

        $data = $this->getPdfMailData($customer, $billing_address, $delivery_address);
        $pdf = $this->createPdf($data);
        $pdfName = date('Y'). '-'.$this->getOrdersYearCount().'.pdf';
        Checkout::add('pdf', $pdfName);

        $this->sendMail('istheweb.shop::order.order-received', $data, $customer->email, $this->shop->email);
        $this->sendMail('istheweb.shop::order.order-received', $data, $this->shop->email, $customer->email);
    }

    protected function getPdfMailData($customer, $billing_address, $delivery_address){
        /**
         * Forzamos precios con IVA
         * para facturar
         */
        $items = array();
        $total = 0;
        $iva = 0;

        foreach($this->basketItems as $item){
            $iv = ($item->price * 0.21);
            $precio = number_format($item->price - $iv, 2);
            $st = number_format($precio * $item->qty, 2);
            $tiv = number_format($iv * $item->qty, 2);
            $it['name'] = $item->name;
            $it['price'] = $precio;
            $it['subtotal'] = $st;
            $it['qty'] = $item->qty;
            $total += $st;
            $iva += $tiv;
            array_push($items, $it);
        }

        $subtotal = number_format($total, 2);
        $total += number_format($this->basketPaymentFee + $this->selectedShippingRate + $iva, 2);


        $billingAddress = $customer->name.' '.$customer->surname .'<br>'.$billing_address->address_1 . " " . $billing_address->address_2."<br>".$billing_address->postcode. " ". $billing_address->city. " - " . $billing_address->state->name . " " . $billing_address->country->name;
        $deliveryAddress = $customer->name.' '.$customer->surname .'<br>'.$delivery_address->address_1 . " " . $delivery_address->address_2."<br>".$delivery_address->postcode. " ". $delivery_address->city. " - " . $delivery_address->state->name . " " . $delivery_address->country->name;
        $data = [
            'admin' => false,
            'subject' => "Nuevo pedido",
            'email' => $customer->user->email,
            'name'  => $customer->user->name . " " . $customer->user->surname,
            'site'  => BrandSetting::get('app_name'),
            'email-site' => $this->shop->email,
            'cif' => $customer->cif,
            'items' => $items,
            'iva'   => $iva,
            'fee'   => number_format($this->basketPaymentFee, 2),
            'subtotal' => $subtotal,
            'total' => $total,
            'shipping'   => $this->selectedShippingRate,
            'pdf'    => date('Y'). '-'.$this->getOrdersYearCount().'.pdf',
            'pdfNumber' => date('Y'). '-'.$this->getOrdersYearCount(),
            'billingAddress' => $billingAddress,
            'shippingAddress' => $deliveryAddress
        ];
        return $data;
    }

    protected function getOrdersYearCount(){
        $year = date('Y');
        $orders = Order::where('invoice', '<>', '')->get();
        return $orders->count()+1;
    }

    protected function createPdf($data)
    {
        try
        {
            $templateCode = 'istheweb-template';
            return PDF::loadTemplate($templateCode, $data)->save('storage/app/media/facturas/'.$data['pdf']);
        } catch (Exception $e)
        {
            Flash::error($e->getMessage());
        }
    }

    protected function sendMail($template, $data, $to, $from){
        Mail::send($template, $data, function ($message) use ($data, $to, $from){
            $message->subject($data['subject']);
            $message->attach(storage_path().'/app/media/facturas/'.$data['pdf']);
            $message->from($from);
            $message->to($to);
        });
    }

    public function getAmountBasket(){
        $amount = $this->basketTotal;
        $amount = number_format($amount, 2);
        if (strpos($amount, ".") !== false) {
            $decimal = strstr($amount, ".");
            $decimal = ltrim ($decimal,'.');
            $number = strstr($amount, ".", true);

            if(strlen($decimal) == 1) $decimal = $decimal . "0";
            //if(strlen($decimal) == 1) $decimal = $decimal . "0";
            $total = $number.$decimal;
        }else{
            $total = $amount."00";
        }
        return $total;
    }

    public function updateOrder($payment = null, $state = 'cancel'){
        if($state == 'cancel'){
            //$status_cancelled = OrderStatus::where('name', '=', 'Pago Cancelado')->first();
            $status_cancelled = OrderStatus::where('state', '=', 'cancel')->first();
            $order_id = Checkout::get('order_id');
            $order = Order::find($order_id);
            $order->order_status()->associate($status_cancelled);
            $order->save();
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));

        }else if($state == 'paypal-approved'){
            $pp = PaypalPayment::where('paypal_id', '=', $payment->getId())->first();
            $pp->paypal_state = $payment->getState();
            $pp->save();
            $order = Order::find($pp->order->id);
            //$status_approved = OrderStatus::where('name', '=', 'Pago Recibido')->first();
            $status_approved = OrderStatus::where('state', '=', 'approved')->first();
            $order->order_status()->associate($status_approved);

            $this->send();

            $order->invoice = date('Y'). '-'.$this->getOrdersYearCount();
            $order->save();
            //$this->order = $order;

            Cart::instance('shopping')->destroy();
            Checkout::destroy();
            Session::forget('checkout');

            Session::put('order', $order->id);

            Flash::success(Lang::get('istheweb.shop::lang.labels.compra_ok_msg'));

            //return Redirect::to('shop/order')->with('order', $order->id);

        }
        return Redirect::to('checkout');

    }

    public function updateTpvOrder($state = 'cancel')
    {

    }
}