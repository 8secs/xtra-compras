<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateShippingsTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_shippings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('geo_zone_id')->unsigned();
            $table->string('name');
            $table->decimal('cost', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_shippings');
    }

}
