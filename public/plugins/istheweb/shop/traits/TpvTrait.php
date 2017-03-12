<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 11/07/16
 * Time: 9:39
 */

namespace istheweb\shop\traits;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use October\Rain\Support\Facades\Flash;
use istheweb\shop\classes\RedsysAPI;
use Istheweb\Shop\Models\Order;
use Istheweb\Shop\Models\OrderStatus;
use Istheweb\Shop\Models\TpvPayment;
use Istheweb\Shop\Facades\Checkout;

trait TpvTrait
{

    protected $fuc;

    protected $currency;

    protected $terminal;

    protected $transaction_type;

    protected $url_ok;

    protected $url_ko;

    protected $ds_signature;
    
    public $form_params;
    
    public $form_signature;

    public function createTpvPayment(){

        $this->fuc = $this->shop->tpv_fuc;
        $this->currency = '978';
        $this->terminal = $this->shop->tpv_terminal;
        $this->transaction_type = '0';
        $this->url_ok = $this->shop->tpv_url_ok;
        $this->url_ko = $this->shop->tpv_url_ko;
        $this->ds_signature = $this->shop->tpv_signature;


        if($this->order){

            $amount = $this->basketTotal;
            $tpv_order = date('ymdHis');

            $total_tpv = $this->getAmountBasket();

            $protocol = Request::server('SERVER_PORT') == 443 ? "https://" : "http://";
            $merchant_url = $protocol . Request::server('SERVER_NAME');

            $redsys = new RedsysAPI();
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_AMOUNT,$total_tpv);
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_ORDER,strval($tpv_order));
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_MERCHANTCODE,$this->fuc);
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_CURRENCY,$this->currency);
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_TRANSACTIONTYPE,$this->transaction_type);
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_TERMINAL,$this->terminal);
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_MERCHANTURL, $merchant_url);
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_URLOK,$this->url_ok);
            $redsys->setParameter(RedsysAPI::DS_MERCHANT_URLKO,$this->url_ko);
        }

        $this->form_params = $redsys->createMerchantParameters();
        $this->form_signature = $redsys->createMerchantSignature($this->ds_signature);
        
        $tpv_payment = new TpvPayment();
        $tpv_payment->tpv_order = $tpv_order;
        $tpv_payment->currency = $this->currency;
        $tpv_payment->total = $amount;
        $tpv_payment->estado = 1;
        $tpv_payment->order()->associate($this->order);
        $tpv_payment->save();

        Checkout::add('tpv_payment_id', $tpv_payment->id);

        return $result = [
            'params'        => $this->form_params,
            'signature'     => $this->form_signature,
            'version'       => RedsysAPI::DS_MERCHANT_SHA_VERSION,
            'isTpv'         => 1
        ];

    }

    public function executeTpvPayment()
    {
        $redsys = new RedsysAPI();
        $version = get("Ds_SignatureVersion");
        $datos = get("Ds_MerchantParameters");
        $signatureRecibida = get("Ds_Signature");

        $decodec = $redsys->decodeMerchantParameters($datos);
        $this->fuc = $this->shop->tpv_fuc;
        $this->ds_signature = $this->shop->tpv_signature;
        $firma = $redsys->createMerchantSignatureNotif($this->ds_signature,$datos);

       //dd($signatureRecibida." ------------- ". $firma);

        $tpv_order = $redsys->getParameter('Ds_Order');
        $response = $redsys->getParameter('Ds_Response');
        $authCode = $redsys->getParameter('Ds_AuthorisationCode');

        $order_id = Checkout::get('order_id');
        $order = Order::find($order_id);
        $response_code = $redsys->formatTpvResponse($response);
        $tpv_payment = TpvPayment::where('order_id', '=', $order->id)->first();

        if ($firma === $signatureRecibida){
            $tpv_payment->tpv_response = $response_code;

            if($response_code < 100){

                $tpv_payment->auth_code = $authCode;
                $tpv_payment->estado = 2;

                //$status_approved = OrderStatus::find(6);
                $status_approved = OrderStatus::where('state', '=', 'approved')->first();
                $order->order_status()->associate($status_approved);
                $this->send();
                Cart::instance('shopping')->destroy();
                Checkout::destroy();
                Session::forget('checkout');
                Session::put('order', $order->id);
                Flash::success(Lang::get('istheweb.shop::lang.labels.compra_ok_msg'));
            }else{
                $tpv_payment->estado = 1;
                //$status_cancelled = OrderStatus::find(5);
                $status_cancelled = OrderStatus::where('state', '=', 'cancel')->first();
                $order->order_status()->associate($status_cancelled);
                Flash::error(Lang::get('istheweb.shop::lang.labels.compra_ko_msg'));
            }
        }else{
            $tpv_payment->estado = 1;
            //$status_cancelled = OrderStatus::find(5);
            $status_cancelled = OrderStatus::where('state', '=', 'cancel')->first();
            $order->order_status()->associate($status_cancelled);
            Flash::error(Lang::get('istheweb.shop::lang.labels.compra_no_igual_signature'));
        }
        $tpv_payment->save();
        $order->save();
        return Redirect::to('checkout');
    }
}