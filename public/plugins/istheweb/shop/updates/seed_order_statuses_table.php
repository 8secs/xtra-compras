<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 17/05/16
 * Time: 13:23
 */

namespace Istheweb\Shop\Updates;


use October\Rain\Database\Updates\Seeder;
use Istheweb\Shop\Models\OrderStatus;

class SeedOrderStatusesTable extends Seeder
{
    public function run()
    {
        $os = new OrderStatus();
        $os->name = 'Nuevo Pedido - Reembolso';
        $os->state = 'cash';
        $os->color = '#f1c40f';
        $os->send_email = 1;
        $os->attach_invoice = 0;
        $os->email_template = 'istheweb.shop::mail.orderconfirm';
        $os->save();

        $os = new OrderStatus();
        $os->name = 'Nuevo Pedido - Paypal';
        $os->state = 'paypal';
        $os->color = '#f1c40f';
        $os->send_email = 1;
        $os->attach_invoice = 0;
        $os->email_template = 'istheweb.shop::mail.orderconfirm';
        $os->save();

        $os = new OrderStatus();
        $os->name = 'Pago Cancelado';
        $os->state = 'cancel';
        $os->color = '#c0392b';
        $os->send_email = 0;
        $os->attach_invoice = 0;
        $os->email_template = 'istheweb.shop::mail.orderconfirm';
        $os->save();

        $os = new OrderStatus();
        $os->name = 'Pago Recibido';
        $os->state = 'approved';
        $os->color = '#8e44ad';
        $os->send_email = 1;
        $os->attach_invoice = 1;
        $os->email_template = 'istheweb.shop::mail.orderconfirm';
        $os->save();
    }
}