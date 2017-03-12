<?php namespace Istheweb\Shop\Updates;

use Istheweb\Shop\Models\Currency;
use Istheweb\Shop\Models\GeoZone;
use Istheweb\Shop\Models\Shipping;
use Istheweb\Shop\Models\Shop;
use Istheweb\Shop\Models\TaxRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use October\Rain\Database\Updates\Seeder;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;

class SeedAllTables extends Seeder
{
    public function run()
    {
        $spain = Country::where('code', 'es')->first();
        if(!$spain->is_enabled){
            $spain->is_enabled = true;
            $spain->save();
        }
        $seville = State::where('code', 'SV')->first();
        $uk = Country::where('code', 'GB')->first();

        $euro = new Currency();
        $euro->name = "Euro";
        $euro->code = 'EU';
        $euro->symbol_right = '€';
        $euro->decimal_place = '2';
        $euro->value = 0.9091;
        $euro->published_at = Carbon::now();
        $euro->save();
        $euro = Currency::where('code', 'EU')->first();

        $dolar = new Currency();
        $dolar->name = "US Dollar";
        $dolar->code = 'US';
        $dolar->symbol_left = '$';
        $dolar->decimal_place = '2';
        $dolar->value = 1;
        $dolar->published_at = Carbon::now();
        $dolar->save();

        $sp_iva = new GeoZone();
        $sp_iva->name = 'IVA de España';
        $sp_iva->description = '<p>Esto son los impuestos para España.</p>';
        $sp_iva->save();
        $sp_iva = GeoZone::find(1);
        $sp_iva->countries()->attach($spain->id);


        $uk_tax = new GeoZone();
        $uk_tax->name = 'UK VAT Zone';
        $uk_tax->description = '<p>Esto son los impuesto para el Reino Unido</p>';
        $uk_tax->save();
        $uk_tax = GeoZone::find(2);
        $uk_tax->countries()->attach($uk->id);

        $islands = new GeoZone();
        $islands->name = 'Islas españolas';
        $islands->description = '<p>Islas Canarias y Baleares</p>';
        $islands->save();
        $islands = GeoZone::find(3);
        $islands->countries()->attach($islands->id);

        $tax_rate = new TaxRate();
        $tax_rate->geo_zone = $sp_iva;
        $tax_rate->name = "IVA General 21%";
        $tax_rate->rate = 21;
        $tax_rate->type = 'P';
        $tax_rate->save();

        $tax_free = new TaxRate();
        $tax_free->geo_zone = $sp_iva;
        $tax_free->name = "Impuestos incluidos";
        $tax_free->rate = 0.00;
        $tax_free->type = 'F';
        $tax_free->save();

        $envio_gratis = new Shipping();
        $envio_gratis->name = 'Envíos gratis';
        $envio_gratis->cost = 0.00;
        $envio_gratis->total = 150.00;
        $envio_gratis->geo_zone()->associate($sp_iva);
        $envio_gratis->save();


        $precio_unico = new Shipping();
        $precio_unico->name = 'Precio único';
        $precio_unico->cost = 5.00;
        $precio_unico->total = 0.00;
        $precio_unico->geo_zone()->associate($sp_iva);
        $precio_unico->save();;

        $shipping_islands = new Shipping();
        $shipping_islands->name = 'Envíos a las Islas';
        $shipping_islands->cost = 15.00;
        $shipping_islands->total = 0.00;
        $shipping_islands->geo_zone()->associate($islands);
        $shipping_islands->save();

        Shop::set(
            [
                'name'                  => 'Tienda Yavadava',
                'owner'                 => 'Andrés Rangel',
                'address'               => '',
                'email'                 => 'info@istheweb.com',
                'phone'                 => '123456789',
                'fax'                   => '',
                'country'               => $spain->id,
                'state'                 => $seville->id,
                'currency'              => $euro->id,
                'length'                => 'centimeter',
                'weight'                => 'kilogram',
                'tax'                   => $tax_rate->id,
                'paypal_client_id'      => 'AcUNIttdGKetFnX71L4u3XLEWkwGEukYpeqa_KEc4VGrtIz5Fuzb0NcgRpZk6FrzBeDR1JLt8QNQ-u20',
                'paypal_secret_id'      => 'EGvuNI6I0obUVQOewsk9tNolalk0qY246L4tepa52t3kYiB9VUNW-PqBL_YqtFKM7m3uvnuvorqE-ceY',
                'cash_delivery'         => 1,
                'paypal'                => 1,
                'checkoutSteps'         => 3
            ]
        );
    }
}

?>