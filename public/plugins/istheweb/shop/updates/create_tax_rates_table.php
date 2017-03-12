<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTaxRatesTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_tax_rates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('geo_zone_id')->unsigned();
            $table->string('name');
            $table->decimal('rate', 15, 4);
            $table->char('type', 1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_tax_rates');
    }

}
