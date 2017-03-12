<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePaypalPaymentsTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_paypal_payments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('paypal_id');
            $table->string('paypal_state')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_paypal_payments');
    }

}
