<?php namespace Istheweb\Shop\Controllers;

use Backend\Models\BrandSetting;
use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use October\Rain\Exception\ApplicationException;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;
use RainLab\User\Models\User;
use Renatio\DynamicPDF\Classes\PDF;
use Renatio\DynamicPDF\Models\PDFTemplate;
use Istheweb\Shop\Models\Address;
use Istheweb\Shop\Models\Customer;
use Istheweb\Shop\Models\GeoZone;
use Istheweb\Shop\Models\Order;
use Istheweb\Shop\Models\OrderStatus;
use Istheweb\Shop\Models\Product;
use Istheweb\Shop\Models\Shipping;
use Istheweb\Shop\Models\Shop;
use RainLab\User\Models\Settings as UserSettings;
use Flash;
use Lang;
use Auth;
use Redirect;

/**
 * Orders Back-end Controller
 */
class Orders extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.Shop', 'shop', 'orders');
        $this->addJs('/plugins/istheweb/shop/assets/js/shop.orders.js');
    }

    public function onRelationManageAdd(){
        $relation_field = post('_relation_field');
        if($relation_field == 'products'){
            $this->checkProducts('add');
        }
        return Redirect::refresh();

    }

    public function onRelationButtonRemove(){
        $this->checkProducts('remove');
        //return $this->relationRefresh();
        return Redirect::refresh();
    }

    public function onRelationManageCreate(){
        $relation_field = post('_relation_field');
        if($relation_field == 'customer')  {
            $customer = post('Customer');

            $automaticActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
            $u = [
                'name'                  => $customer['name'],
                'surname'               => $customer['surname'],
                'email'                 => $customer['email'],
                'username'              => $customer['username'],
                'password'              => 'dxbwatch2016',
                'password_confirmation' => 'dxbwatch2016'
            ];

            $user = Auth::register($u, $automaticActivation);

            $cus = new Customer();
            $cus->user = $user;
            $cus->name = $customer['name'];
            $cus->surname = $customer['surname'];
            $cus->email = $customer['email'];
            $cus->username = $customer['username'];
            $cus->phone = $customer['phone'];
            $cus->cif = $customer['cif'];
            $cus->save();

            Flash::success('El cliente se ha creado correctamente');

            return Redirect::refresh();
        }
        else {
            if($relation_field == 'shipping_address' || $relation_field == 'billing_address'){
                $p_address = post('Address');
                $address = new Address();
                $address->address_1 = $p_address['address_1'];
                $address->address_2 = $p_address['address_2'];
                $address->city = $p_address['city'];
                $address->postcode = $p_address['postcode'];
                $customer = Customer::find($p_address['customer']);
                $country = Country::find($p_address['country']);
                $state = State::find($p_address['state']);
                $address->customer()->associate($customer);
                $address->country()->associate($country);
                $address->state()->associate($state);
                $address->save();

                Flash::success('La dirección se ha creado correctamente');

                return Redirect::refresh();

            }
        }
    }

    public function onRelationClickManageList()
    {
        //return post('_relation_field');
        $relation_field = post('_relation_field');
        $recordId = post('record_id');
        $sessionKey = post('_session_key');

        if($relation_field == 'customer') {
            $customer = Customer::with('user')->find($recordId);
            $address = Address::where('customer_id', $recordId)->first();;
        } else {
            $address = Address::with('customer')->find($recordId);
            $customer = $address->customer;
        }

        //return json_encode($address->customer);
        //return json_encode(count($this->params));
        if(!$this->params) {

            $order = new Order();
            $order->customer()->add($customer, $sessionKey);
            if($address){
                $order->shipping_address()->add($address, $sessionKey);
                $order->billing_address()->add($address, $sessionKey);
            }
        }else{
            $order = Order::find($this->params[0]);

            $order->customer()->associate($customer);
            if($address){
                $order->shipping_address()->associate($address);
                $order->billing_address()->associate($address);
            }
        }
        //$order->save();
    }


    public function onGeneratePdf(){

        $order = Order::with('products')->where('id', '=',$this->params)->first();
        $shop = Shop::instance();
        $customer = Customer::find($order->customer_id);

        $data = $this->getData($order, $shop, $customer);

        $pdf = $this->createPdf($data);
        $pdfName = date('Y'). '-'.$this->getOrdersYearCount();

        $order->invoice = $pdfName;
        $order->save();

        Flash::success('Se ha creado y guardado correctamente el pdf');

        return Redirect::refresh();
    }


    public function preview($id){
        $templateCode = 'istheweb-template';

        $order = Order::with('products')->where('id', '=',$id)->first();
        $shop = Shop::instance();
        $customer = Customer::find($order->customer_id);

        $data = $this->getData($order, $shop, $customer);

        try {

            return PDF::loadTemplate($templateCode, $data)->stream();
        } catch (ApplicationException $e) {
            $this->pageTitle = trans('renatio.dynamicpdf::lang.templates.preview');
            $this->vars['error'] = $e->getMessage();
        }
    }

    public function onSend()
    {
        $order = Order::with('products')->where('id', '=',$this->params)->first();
        //return json_encode($order);
        $shop = Shop::instance();
        $customer = Customer::find($order->customer_id);

        $data = $this->getData($order, $shop, $customer);
        $this->sendMail('istheweb.shop::order.order-received', $data, $customer->user->email, $shop->email);

        Flash::success('Se ha enviado a la dirección del cliente un email con su factura incluida.');

        return Redirect::refresh();
    }

    public function update_onSave($recordId){
        $order = Order::find($recordId);
        $post_order = post('Order');
        $order_status = OrderStatus::find($post_order['order_status']);
        if($order->customer) $customer = Customer::find($order->customer->id);
        $order->payment_method = $post_order['payment_method'];

        /**
         * Comprobamos que el estado del pedido.
         * Si el estado es admin, guardamos el pedido y asoociamos el estado
         */
        if($order_status['state'] != 'admin')
        {
            /**
             * Es caso que el estado es diferente a admin,
             * comprobamos si tenemos generada la factura
             */
            if(strlen($order->invoice) > 1)
            {
                /**
                 * Si  tenemos generada la factura,
                 * comprobamos que el estado guardado del pedido sea diferente del recibido por POST
                 */
                if($order->order_status->id != post('Order[order_status]'))
                {
                    /**
                     * Si son estados diferentes, vemos si tenemos que enviar el email al cliente
                     * para el nuevo estado del pedido
                     */
                    if($order_status['send_email'] == 'Si')
                    {
                        $shop = Shop::instance();

                        /**
                         * Si tenemos que adjuntar la factura
                         * con el nuevo estado del pedido
                         */
                        if($order_status['attach_invoice'] == 'Si')
                        {
                            $data = $this->getData($order, $shop, $customer);
                        }else{
                            $data = [
                                'subject'   => $order_status->name . " del sitio web " . $shop->name,
                                'site'      => $shop->name,
                                'pdfNumber' => $order->invoice
                            ];
                        }

                        $to = $customer->user->email;
                        $from = $shop->email;

                        Mail::send($order_status['email_template'], $data, function ($message) use ($data, $to, $from){
                            $message->subject($data['subject']);
                            if(isset($data['pdf'])){
                                $message->attach(storage_path().'/app/media/facturas/'.$data['pdf']);
                            }
                            $message->from($from);
                            $message->to($to);
                        });
                    }
                }

                Flash::success(Lang::get('istheweb.shop::lang.order.update_order'));
                $order->order_status()->associate($order_status);
                $order->save();
            }else{
                Flash::error(Lang::get('istheweb.shop::lang.labels.create_pdf_first'));
                return;
            }
        }else{
            Flash::success(Lang::get('istheweb.shop::lang.order.update_order'));
            $order->order_status()->associate($order_status);
            $order->save();
        }

        if(post('close')){
            return Redirect::to('backend/istheweb/shop/orders');
        }else{
            return Redirect::refresh();
        }
    }

    /**
     * Deleted checked products.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $orderId) {
                if (!$order = Order::find($orderId)) {
                    continue;
                }

                $order->delete();
            }

            Flash::success(Lang::get('istheweb.shop::lang.orders.delete_selected_success'));
        } else {
            Flash::error(Lang::get('istheweb.shop::lang.orders.delete_selected_empty'));
        }

        return $this->listRefresh();
    }

    protected function checkProducts($action)
    {
        $productIds = post('checked');
        $products = array();
        $order = Order::where('id', '=', $this->params)->first();
        if(is_array($productIds) && count($productIds) > 0) {
            foreach ($productIds as $id) {
                $product = Product::find($id);
                if ($product) {
                    array_push($products, $product);
                    if($action == 'add') $order->products()->attach($product);
                    else $order->products()->detach($product);
                }
            }
            $totales = $this->getPrices($order->products);
            $subtotal = $totales['total'];
            $iva = $totales['iva'];

            $total = $subtotal + $iva;
            $total = number_format($total, 2);
            $order->tax = number_format($iva, 2);
            $order->total = number_format($total, 2);
            $order->subtotal = number_format($subtotal,2);
            $order->save();
        }
    }

    protected function getPrices($products)
    {
        $items = array();
        $total = 0;
        $iva = 0;

        foreach($products as $item){
            $iv = ($item->price * 0.21);
            $precio = $item->price - $iv;
            $st = $precio * 1;
            $tiv = $iv * 1;
            $it['name'] = $item->name;
            $it['price'] = $precio;
            $it['subtotal'] = $st;
            $it['iva'] = $tiv;
            $it['qty'] = 1;
            $total += $st;
            $iva += $tiv;
            array_push($items, $it);
        }

        $result = array();
        $result['total'] = $total;
        $result['iva'] = $iva;
        $result['items'] = $items;

        return $result;
    }

    protected function getData($order, $shop, $customer)
    {
        $shipping_address = Address::find($order->shipping_address_id);
        $billing_address = Address::find($order->billing_address_id);
        $billingAddress = $this->getPdfAddresses($billing_address, $customer);
        $deliveryAddress = $this->getPdfAddresses($shipping_address, $customer);

        $totales = $this->getPrices($order->products);
        $subtotal = $totales['total'];
        $iva = $totales['iva'];
        $items = $totales['items'];

        $selectedShippingRate = $this->getSelectedShippingRate($subtotal);

        $t = $subtotal + $iva;
        $comision = $t * $this->getPaymentFee($order->payment_method);
        $total = $subtotal + $comision + $iva + $selectedShippingRate;

        if(strlen($order->invoice) > 1){
            $pdf = $order->invoice.'.pdf';
            $pdfNumber = $order->invoice;
        }else{
            $pdf = date('Y'). '-'.$this->getOrdersYearCount().'.pdf';
            $pdfNumber = date('Y'). '-'.$this->getOrdersYearCount();
        }

        return $data = [
                'admin' => false,
                'subject' => "Nuevo pedido",
                'email' => $customer->user->email,
                'name'  => $customer->user->name . " " . $customer->user->surname,
                'site'  => BrandSetting::get('app_name'),
                'email-site' => $shop->email,
                'cif' => $customer->cif,
                'items' => $items,
                'iva'   => number_format($iva,2),
                'shipping'     => number_format($selectedShippingRate, 2),
                'fee'   => number_format($comision, 2),
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($total,2),
                'pdf'    => $pdf,
                'pdfNumber' => $pdfNumber,
                'billingAddress' => $billingAddress,
                'shippingAddress' => $deliveryAddress
            ];
    }


    protected function getSelectedShippingRate($subtotal){
            if((float)$this->getFreeShipping() > (float)$subtotal)
            {
                $geoZone = $this->getGeoZone();
                $shipping = Shipping::where('total', '=', 0)
                    ->where('geo_zone_id', $geoZone->id)
                    ->min('cost');
                $selectedShippingRate = isset($shipping) ? $shipping : 0.00;
            }else{
                $selectedShippingRate = 0.00;
            }

        return $selectedShippingRate;
    }

    protected function getGeoZone(){
        $shop = Shop::instance();
        $shopCountry = Country::find($shop->country);
        $shopCountryId[] = $shopCountry->id;
        return GeoZone::whereHas('countries',
            function($query) use ($shopCountryId) {
                $query->whereIn('id', $shopCountryId);
            })->first();
    }

    protected function getFreeShipping(){
        $geoZone = $this->getGeoZone();
        $shipping = Shipping::where('total', '>', 0)
            ->where('geo_zone_id', $geoZone->id)
            ->first();
        if(isset($shipping)) return $shipping->total;
        else return 0;
    }

    protected function getPaymentFee($method){
        switch ($method){
            case 'cash':
                return 0.06;
            case 'paypal':
                return 0.02;
        }
    }

    protected function getOrdersYearCount()
    {
        $year = date('Y');
        //$orders = Order::whereBetween('created_at', [$year.'-1-01', $year.'-12-31'])->get();
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

    public function getPdfAddresses($address, $customer){
        return $customer->name.' '
                . $customer->surname .'<br>'
                . $address->address_1 . " "
                . $address->address_2."<br>"
                . $address->postcode. " "
                . $address->city. " - "
                . $address->state->name . " "
                . $address->country->name;
    }

    protected function sendMail($template, $data, $to, $from){
        Mail::send($template, $data, function ($message) use ($data, $to, $from){
            $message->subject($data['subject']);
            $message->attach(storage_path().'/app/media/facturas/'.$data['pdf']);
            $message->from($from);
            $message->to($to);
        });
    }
}