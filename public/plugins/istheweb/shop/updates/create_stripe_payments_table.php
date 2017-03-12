<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStripePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_shop_stripe_payments', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('charge_id',  30);
            $table->string('customer_id', 50);
            $table->integer('order_id')->unsigned();
            $table->string('state')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_stripe_payments');
    }
}
