<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 12/05/16
 * Time: 15:32
 */

namespace Istheweb\Shop\Traits;


use Illuminate\Support\Facades\Input;
use PayPal\Core\PayPalConstants;
use Redirect;
use October\Rain\Support\Facades\Config;
use October\Rain\Support\Facades\Flash;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Links;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\PaymentHistory;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Refund;
use PayPal\Api\RelatedResources;
use PayPal\Api\Sale;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Api\Transactions;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Core\PayPalConfigManager;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Session;
use Istheweb\Shop\Facades\Checkout;
use Istheweb\Shop\Models\Order;
use Istheweb\Shop\Models\OrderStatus;
use Istheweb\Shop\Models\PaypalPayment;

trait PayPalTrait
{

    /**
     * PayPal Api Context
     * @var \PayPal\Rest\ApiContext
     */
    protected $_apiContext;

    /**
     * List paypal sdk config vars
     * @var array
     */
    protected $sdkConfig;

    /**
     * Paypal client ID
     * @var string
     */
    protected $paypal_client_id;

    /**
     * Paypal secret ID
     * @var string
     */
    protected $paypal_secret_id;


    /**
     * @return \PayPal\Api\Address
     */
    public function address()
    {
        return new Address;
    }
    /**
     * @return \PayPal\Api\Amount
     */
    public function amount()
    {
        return new Amount;
    }
    /**
     * @return \PayPal\Api\Details
     */
    public function details()
    {
        return new Details;
    }
    /**
     * @return \PayPal\Api\Authorization
     */
    public function authorization()
    {
        return new Authorization;
    }
    /**
     * @return \PayPal\Api\Capture
     */
    public function capture()
    {
        return new Capture;
    }
    /**
     * @return \PayPal\Api\CreditCard
     */
    public function creditCard()
    {
        return new CreditCard;
    }
    /**
     * @return \PayPal\Api\CreditCardToken
     */
    public function creditCardToken()
    {
        return new CreditCardToken;
    }
    /**
     * @return \PayPal\Api\FundingInstrument
     */
    public function fundingInstrument()
    {
        return new FundingInstrument;
    }
    /**
     * @return \PayPal\Api\Item
     */
    public function item()
    {
        return new Item;
    }
    /**
     * @return \PayPal\Api\ItemList
     */
    public function itemList()
    {
        return new ItemList;
    }
    /**
     * @return \PayPal\Api\Links
     */
    public function links()
    {
        return new Links;
    }
    /**
     * @return \PayPal\Api\Payee
     */
    public function payee()
    {
        return new Payee;
    }
    /**
     * @return \PayPal\Api\Payer
     */
    public function payer()
    {
        return new Payer;
    }
    /**
     * @return \PayPal\Api\PayerInfo
     */
    public function payerInfo()
    {
        return new PayerInfo;
    }
    /**
     * @return \PayPal\Api\Payment
     */
    public function payment()
    {
        return new Payment;
    }
    /**
     * @return \PayPal\Api\PaymentExecution
     */
    public function paymentExecution()
    {
        return new PaymentExecution;
    }
    /**
     * @return \PayPal\Api\PaymentHistory
     */
    public function paymentHistory()
    {
        return new PaymentHistory;
    }
    /**
     * @return \PayPal\Api\RedirectUrls
     */
    public function redirectUrls()
    {
        return new RedirectUrls;
    }
    /**
     * @return \PayPal\Api\Refund
     */
    public function refund()
    {
        return new Refund;
    }
    /**
     * @return \PayPal\Api\RelatedResources
     */
    public function relatedResources()
    {
        return new RelatedResources;
    }
    /**
     * @return \PayPal\Api\Sale
     */
    public function sale()
    {
        return new Sale;
    }
    /**
     * @return \PayPal\Api\ShippingAddress
     */
    public function shippingAddress()
    {
        return new ShippingAddress;
    }
    /**
     * @return \PayPal\Api\Transactions
     */
    public function transactions()
    {
        return new Transactions;
    }
    /**
     * @return \PayPal\Api\Transaction
     */
    public function transaction()
    {
        return new Transaction;
    }



    /**
     * @param null $clientId
     * @param null $clientSecret
     * @param null $requestId
     * @return \PayPal\Rest\ApiContext
     */
    public function apiContext($clientId = null, $clientSecret = null, $requestId = null)
    {
        $credentials = self::OAuthTokenCredential($clientId, $clientSecret);
        return new ApiContext($credentials, $requestId);
    }
    /**
     * @param null $ClientId
     * @param null $ClientSecret
     * @return PayPal/Auth/OAuthTokenCredential
     */
    public  static function OAuthTokenCredential($ClientId = null, $ClientSecret=null)
    {
        if(isset($ClientId) && isset($ClientSecret)) {
            return new OAuthTokenCredential($ClientId, $ClientSecret);
        }
    }

    /**
     *
     */
    public function setApiContext()
    {

        //PayPalHttpConfig::$defaultCurlOptions[CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1;
        $this->sdkConfig  = array(
            "mode" => "sandbox",
            'service.EndPoint' => PayPalConstants::REST_SANDBOX_ENDPOINT,
            /*'service.EndPoint' => PayPalConstants::REST_LIVE_ENDPOINT,*/
            'http.ConnectionTimeOut' => 60,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'FINE'
        );

        $this->_apiContext = $this->apiContext($this->shop->paypal_client_id, $this->shop->paypal_secret_id, 'Request' . time());
        $this->_apiContext->setConfig($this->sdkConfig);
        //dd($this->_apiContext->getCredential());
    }

    /**
     * @param $total
     * @return string
     */
    public function createPaypalPayment()
    {
        $payer = $this->payer();
        $payer->setPaymentMethod('paypal');
        $itemList = $this->itemList();

        foreach($this->basketItems as $item){
            $paypal_item = $this->item();
            $paypal_item->setName($item->name);
            $paypal_item->setCurrency('EUR');
            $paypal_item->setQuantity($item->qty);
            $paypal_item->setPrice($item->price);

            $itemList->addItem($paypal_item);
        }
        $details = $this->details();
        if($this->selectedSippingRate || $this->basketTaxRate || $this->basketPaymentFee) $details->setSubtotal($this->basketSubtotal);
        if($this->selectedShippingRate) $details->setShipping($this->selectedShippingRate);
        if($this->basketTaxRate) $details->setTax($this->basketTaxRate);
        if($this->basketPaymentFee) $details->setHandlingFee($this->basketPaymentFee);

        $amount = $this->amount();
        $amount->setCurrency('EUR');
        $amount->setTotal($this->basketTotal);
        if($this->selectedSippingRate || $this->basketTaxRate || $this->basketPaymentFee) {
            $amount->setDetails($details);
        }

        $transaction = $this->transaction();
        $transaction->setAmount($amount);
        $transaction->setItemList($itemList);
        $transaction->setDescription($this->paypalDescription);

        $redirect_urls = $this->redirectUrls();
        $redirect_urls->setReturnUrl($this->shop->paypal_url_ok)
            ->setCancelUrl($this->shop->paypal_url_ko);

        $payment = $this->payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try{
            $payment->create($this->_apiContext);
        } catch (PayPalConnectionException $ex) {
            if(Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_encode($ex->getData(), true);
                return $err_data;
            } else {
                die(Lang::get('istheweb.shop::lang.labels.general_server_error'));
            }
        }

        Checkout::add('paypal_payment_id', $payment->getId());

        $pp = new PaypalPayment();
        $pp->paypal_id = $payment->getId();
        $pp->paypal_state = $payment->getState();
        $this->order->paypal_payment()->save($pp);

        $approvalUrl = $payment->getApprovalLink();
        return Redirect::to($approvalUrl);
    }

    /**
     *
     */
    public function executePayment()
    {
        $payment_id = Checkout::get('paypal_payment_id');

        if(!$payment_id) {
            Flash::error(Lang::get('istheweb.shop::lang.labels.no_payment_id'));
            return;
        }

        $payerID = get('PayerID');
        $token = get('token');
        if(empty($payerID) || empty($token)) {

            return $this->updateOrder(null, 'cancel');
        }

        if(!$this->_apiContext) $this->setApiContext();

        $payment = Payment::get($payment_id, $this->_apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);
        $result = $payment->execute($execution, $this->_apiContext);

        if ($result->getState() == 'approved') { // payment made

            return $this->updateOrder($result, 'paypal-approved');
        }

    }

    /**
     * grape payment details using the paymentId
     * @param $paymentId
     * @param null $apiContext
     * @return \PayPal\Api\Payment
     */
    public static function getById($paymentId, $apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::get($paymentId, $apiContext);
        }
        return Payment::get($paymentId);
    }
    /**
     * grape all payment details
     * @param $param
     * @param null $apiContext
     * @return \PayPal\Api\Payment
     */
    public static function getAll($param, $apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::all($param, $apiContext);
        }
        return Payment::all($param);
    }


}