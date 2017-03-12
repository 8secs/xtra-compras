<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 11/07/16
 * Time: 9:28
 */

namespace istheweb\shop\classes;

class RedsysAPI
{

    const DS_MERCHANT_MERCHANTURL = 'DS_MERCHANT_MERCHANTURL';
    const DS_MERCHANT_URLOK = 'DS_MERCHANT_URLOK';
    const DS_MERCHANT_URLKO = 'DS_MERCHANT_URLKO';
    const DS_MERCHANT_TERMINAL =  'DS_MERCHANT_TERMINAL';
    const DS_MERCHANT_TRANSACTIONTYPE = 'DS_MERCHANT_TRANSACTIONTYPE';
    const DS_MERCHANT_MERCHANTCODE = 'DS_MERCHANT_MERCHANTCODE';
    const DS_MERCHANT_CURRENCY = 'DS_MERCHANT_CURRENCY';
    const DS_MERCHANT_ORDER = 'DS_MERCHANT_ORDER';
    const DS_MERCHANT_AMOUNT = 'DS_MERCHANT_AMOUNT';
    const DS_MERCHANT_SHA_VERSION = 'HMAC_SHA256_V1';

    const TRANSACCION_AUTORIZADA_PAGOS = 'Transacción autorizada para pagos y preautorizaciones';

    const TRANSACCION_AUTORIZADA_DEVOLUCION = 'Transacción autorizada para devoluciones y confirmaciones';

    const TARJETA_CADUCADA = 'Tarjeta caducad';

    const TARJETA_FRAUDE = 'Tarjeta en excepci&oacute;n transitoria o bajo sospecha de fraude';

    const OPERACION_NO_PERMITIDA_A_TERMINAL = 'Operaci&oacute;n no permitida para esa tarjeta o terminal';

    const DISPONIBLE_INSUFICIENTE = 'Disponible insuficiente';

    const TARJETA_NO_REGISTRADA = 'TARJETA_NO_REGISTRADA';

    const COD_CCV_NO = 'C&oacute;digo de seguridad (CVV2/CVC2) incorrecto';
    
    const TARJETA_AJENA = 'Tarjeta ajena al servicio';
    
    const ERROR_TITULAR = 'Error en la autenticaci&oacute;n del titular';
    
    const ERROR_NO_ESPECIFICADO = 'Denegaci&oacute;n sin especificar Motivo';
    
    const ERROR_FECHA_CADUCIDAD = 'Fecha de caducidad err&oacute;nea';
    
    const TARJEA_RETIRADA_FRAUDE = 'Tarjeta en excepci&oacute;n transitoria o bajo sospecha de fraude con retirada de tarjeta';
    
    const EMIRSOR_NO_DISPONIBLE = 'Emisor no disponible';
    
    const NUMERO_POSICIONES_TARJETAS = 'Número de posiciones de la tarjeta incorrecto';
    
    const TIPO_OPERACION_NO_PERMITIDA = 'Tipo de operación no permitida para esa tarjeta';
    
    const TARJETA_NO_EXISTE = 'Tarjeta no existente';
    
    const NO_INTERNATIONAL_SERVERS = 'Rechazo servidores internacionales';
    
    const TITULAR_SEGURO_SIN_CLAVE = 'Comercio con “titular seguro” y titular sin clave de compra segura';
    
    const COMERCIO_NO_OP_SEG = 'El comercio no permite op. seguras por entrada /operaciones';
    
    const CHECK_DIGIT = 'Tarjeta no cumple el check-digit';
    
    const NO_PREAUTORIZACIONES = 'El comercio no puede realizar preautorizaciones';
    
    const TARJETA_NO_PREAUTORIZACIONES = 'Esta tarjeta no permite operativa de preautorizaciones';
    
    const RESTRICCION_ENTRADAS_SIS = 'Operación detenida por superar el control de restricciones en la entrada al SIS';
    
    const USUARIO_CANCEL_TRANSACTION = 'A petición del usuario se ha cancelado el pago';
    
    const ANULACION_DIFERIDA_COMERCIO = 'Anulación de autorización en diferido realizada por el comercio';
    
    const OTRA_TRANSACCION_MISMA_TARJETA = 'Se está procesando otra transacción en SIS con la misma tarjeta';
    
    const SOLICITUD_DATOS_TARJETA = 'Operación en proceso de solicitud de datos de tarjeta';
    
    const OPERACION_REDIRIGIDA = 'Operación que ha sido redirigida al emisor a autenticar';
    
    const TRANSACCION_DENEGADA = 'Transacción denegada';

    const DS_MERCHANT_URL_SANDBOX = 'https://sis-t.redsys.es:25443/sis/realizarPago';

    const DS_MERCHANT_URL_LIVE = 'https://sis.redsys.es/sis/realizarPago';
    
    //public $ds_merchant_url_sandbox;

    //public $ds_merchant_url;

    public $ds_merchant_transaction_type;

    public $ds_merchant_code;

    public $ds_merchant_currency;

    public $ds_merchant_amount;

    /******  Array de DatosEntrada ******/
    public $vars_pay = array();

    /******  Set parameter ******/
    public function setParameter($key,$value){
        $this->vars_pay[$key]=$value;
    }

    /******  Get parameter ******/
    public function getParameter($key){
        return $this->vars_pay[$key];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////					FUNCIONES AUXILIARES:							  ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////


    /******  3DES Function  ******/
    protected function encrypt_3DES($message, $key){
        // Se establece un IV por defecto
        $bytes = array(0,0,0,0,0,0,0,0); //byte [] IV = {0, 0, 0, 0, 0, 0, 0, 0}
        $iv = implode(array_map("chr", $bytes)); //PHP 4 >= 4.0.2

        // Se cifra
        $ciphertext = mcrypt_encrypt(MCRYPT_3DES, $key, $message, MCRYPT_MODE_CBC, $iv); //PHP 4 >= 4.0.2
        return $ciphertext;
    }

    /******  Base64 Functions  ******/
    protected function base64_url_encode($input){
        return strtr(base64_encode($input), '+/', '-_');
    }
    protected function encodeBase64($data){
        $data = base64_encode($data);
        return $data;
    }
    protected function base64_url_decode($input){
        return base64_decode(strtr($input, '-_', '+/'));
    }
    protected function decodeBase64($data){
        $data = base64_decode($data);
        return $data;
    }

    /******  MAC Function ******/
    protected function mac256($ent,$key){
        $res = hash_hmac('sha256', $ent, $key, true);//(PHP 5 >= 5.1.2)
        return $res;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////	   FUNCIONES PARA LA GENERACIÓN DEL FORMULARIO DE PAGO:			  ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    /******  Obtener Número de pedido ******/
    protected function getOrder(){
        $numPedido = "";
        if(empty($this->vars_pay['DS_MERCHANT_ORDER'])){
            $numPedido = $this->vars_pay['Ds_Merchant_Order'];
        } else {
            $numPedido = $this->vars_pay['DS_MERCHANT_ORDER'];
        }
        return $numPedido;
    }
    /******  Convertir Array en Objeto JSON ******/
    protected function arrayToJson(){
        $json = json_encode($this->vars_pay); //(PHP 5 >= 5.2.0)
        return $json;
    }
    public function createMerchantParameters(){
        // Se transforma el array de datos en un objeto Json
        $json = $this->arrayToJson();
        // Se codifican los datos Base64
        return $this->encodeBase64($json);
    }
    public function createMerchantSignature($key){
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se genera el parámetro Ds_MerchantParameters
        $ent = $this->createMerchantParameters();
        // Se diversifica la clave con el Número de Pedido
        $key = $this->encrypt_3DES($this->getOrder(), $key);
        // MAC256 del parámetro Ds_MerchantParameters
        $res = $this->mac256($ent, $key);
        // Se codifican los datos Base64
        return $this->encodeBase64($res);
    }



    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////// FUNCIONES PARA LA RECEPCIÓN DE DATOS DE PAGO (Notif, URLOK y URLKO): ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    /******  Obtener Número de pedido ******/
    protected function getOrderNotif(){
        $numPedido = "";
        if(empty($this->vars_pay['Ds_Order'])){
            $numPedido = $this->vars_pay['DS_ORDER'];
        } else {
            $numPedido = $this->vars_pay['Ds_Order'];
        }
        return $numPedido;
    }
    protected function getOrderNotifSOAP($datos){
        $posPedidoIni = strrpos($datos, "<Ds_Order>");
        $tamPedidoIni = strlen("<Ds_Order>");
        $posPedidoFin = strrpos($datos, "</Ds_Order>");
        return substr($datos,$posPedidoIni + $tamPedidoIni,$posPedidoFin - ($posPedidoIni + $tamPedidoIni));
    }
    protected function getRequestNotifSOAP($datos){
        $posReqIni = strrpos($datos, "<Request");
        $posReqFin = strrpos($datos, "</Request>");
        $tamReqFin = strlen("</Request>");
        return substr($datos,$posReqIni,($posReqFin + $tamReqFin) - $posReqIni);
    }
    protected function getResponseNotifSOAP($datos){
        $posReqIni = strrpos($datos, "<Response");
        $posReqFin = strrpos($datos, "</Response>");
        $tamReqFin = strlen("</Response>");
        return substr($datos,$posReqIni,($posReqFin + $tamReqFin) - $posReqIni);
    }
    /******  Convertir String en Array ******/
    protected function stringToArray($datosDecod){
        $this->vars_pay = json_decode($datosDecod, true); //(PHP 5 >= 5.2.0)
    }
    public function decodeMerchantParameters($datos){
        // Se decodifican los datos Base64
        $decodec = $this->base64_url_decode($datos);
        // Los datos decodificados se pasan al array de datos
        $this->stringToArray($decodec);
        return $decodec;
    }
    public function createMerchantSignatureNotif($key, $datos){
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se decodifican los datos Base64
        $decodec = $this->base64_url_decode($datos);
        // Los datos decodificados se pasan al array de datos
        $this->stringToArray($decodec);
        // Se diversifica la clave con el Número de Pedido
        $key = $this->encrypt_3DES($this->getOrderNotif(), $key);
        // MAC256 del parámetro Ds_Parameters que envía Redsys
        $res = $this->mac256($datos, $key);
        // Se codifican los datos Base64
        return $this->base64_url_encode($res);
    }
    /******  Notificaciones SOAP ENTRADA ******/
    protected function createMerchantSignatureNotifSOAPRequest($key, $datos){
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se obtienen los datos del Request
        $datos = $this->getRequestNotifSOAP($datos);
        // Se diversifica la clave con el Número de Pedido
        $key = $this->encrypt_3DES($this->getOrderNotifSOAP($datos), $key);
        // MAC256 del parámetro Ds_Parameters que envía Redsys
        $res = $this->mac256($datos, $key);
        // Se codifican los datos Base64
        return $this->encodeBase64($res);
    }
    /******  Notificaciones SOAP SALIDA ******/
    protected function createMerchantSignatureNotifSOAPResponse($key, $datos, $numPedido){
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se obtienen los datos del Request
        $datos = $this->getResponseNotifSOAP($datos);
        // Se diversifica la clave con el Número de Pedido
        $key = $this->encrypt_3DES($numPedido, $key);
        // MAC256 del parámetro Ds_Parameters que envía Redsys
        $res = $this->mac256($datos, $key);
        // Se codifican los datos Base64
        return $this->encodeBase64($res);
    }

    public function formatTpvResponse($response){
        $res = ltrim($response, '0');
        $res = intval($res);
        return $res;
    }

    public function tpvResponse($response){
        $res = $this->formatTpvResponse($response);
        //return $res;
        if($res < 100) $res = -1;
        switch ($res) {
            case -1:
                return RedsysAPI::TRANSACCION_AUTORIZADA_PAGOS;
            case 900:
                return RedsysAPI::TRANSACCION_AUTORIZADA_DEVOLUCION;
            case 101:
                return RedsysAPI::TARJETA_CADUCADA;
            case 102:
                return RedsysAPI::TARJEA_RETIRADA_FRAUDE;
            case 104:
                return RedsysAPI::OPERACION_NO_PERMITIDA_A_TERMINAL;
            case 9104:
                return RedsysAPI::OPERACION_NO_PERMITIDA_A_TERMINAL;
            case 116:
                return RedsysAPI::DISPONIBLE_INSUFICIENTE;
            case 118:
                return RedsysAPI::TARJETA_NO_REGISTRADA;
            case 129:
                return RedsysAPI::COD_CCV_NO;
            case 180:
                return RedsysAPI::TARJETA_AJENA;
            case 184:
                return RedsysAPI::ERROR_TITULAR;
            case 190:
                return RedsysAPI::ERROR_NO_ESPECIFICADO;
            case 191:
                return RedsysAPI::ERROR_FECHA_CADUCIDAD;
            case 202:
                return RedsysAPI::TARJEA_RETIRADA_FRAUDE;
            case 912:
                return RedsysAPI::EMIRSOR_NO_DISPONIBLE;
            case 9912:
                return RedsysAPI::EMIRSOR_NO_DISPONIBLE;
            case 9064:
                return RedsysAPI::NUMERO_POSICIONES_TARJETAS;
            case 9078:
                return RedsysAPI::TIPO_OPERACION_NO_PERMITIDA;
            case 9093:
                return RedsysAPI::TARJETA_NO_EXISTE;
            case 9094:
                return RedsysAPI::NO_INTERNATIONAL_SERVERS;
            case 9104:
                return RedsysAPI::TITULAR_SEGURO_SIN_CLAVE;
            case 9218:
                return RedsysAPI::COMERCIO_NO_OP_SEG;
            case 9253:
                return RedsysAPI::CHECK_DIGIT;
            case 9256:
                return RedsysAPI::NO_PREAUTORIZACIONES;
            case 9257:
                return RedsysAPI::TARJETA_NO_PREAUTORIZACIONES;
            case 9261:
                return RedsysAPI::RESTRICCION_ENTRADAS_SIS;
            case 9915:
                return RedsysAPI::USUARIO_CANCEL_TRANSACTION;
            case 9929:
                return RedsysAPI::ANULACION_DIFERIDA_COMERCIO;
            case 9997:
                return RedsysAPI::OTRA_TRANSACCION_MISMA_TARJETA;
            case 9998:
                return RedsysAPI::SOLICITUD_DATOS_TARJETA;
            case 9999:
                return RedsysAPI::OPERACION_REDIRIGIDA;
            default:
                return RedsysAPI::TRANSACCION_DENEGADA;
        }
    }
}