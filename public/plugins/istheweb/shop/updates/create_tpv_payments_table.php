<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTpvPaymentsTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_tpv_payments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('tpv_order', 20);
            $table->string('currency', 5);
            $table->float('total');
            $table->integer('estado')->unsigned();
            $table->string('tpv_response', 20);
            $table->string('auth_code', 20);
            $table->string('observaciones', 1000);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_tpv_payments');
    }

}
