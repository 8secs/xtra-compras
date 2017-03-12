<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateOrderStatusesTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_order_statuses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 128)->nullable();
            $table->string('state', 20);
            $table->string('color', 10)->nullable();
            $table->tinyInteger('send_email')->nullable()->default(true);
            $table->tinyInteger('attach_invoice')->nullable()->default(false);
            $table->string('email_template')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_order_statuses');
    }

}
