<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Carbon\Carbon;

class CreateCouponsTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_coupons', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 128);
            /**
             * type: F = Fix amount; P = percentage
             */
            $table->char('type', 1);
            $table->decimal('discount', 15, 4);
            $table->string('code', 10);
            $table->tinyInteger('shipping');
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('uses_total');
            $table->integer('uses_customer');
            $table->date('published_at')->default(Carbon::now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_coupons');
    }

}
