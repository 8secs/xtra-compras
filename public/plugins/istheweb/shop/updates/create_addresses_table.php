<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAddressesTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_addresses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('address_1', 128)->nullable();
            $table->string('address_2', 128)->nullable();
            $table->string('city', 128)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->integer('country_id')->length(11)->unsigned();
            $table->integer('state_id')->length(11)->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_addresses');
    }

}
