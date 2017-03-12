<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 24/05/16
 * Time: 14:13
 */

namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateOrdersTable extends Migration
{


    public function up()
    {
        Schema::table('istheweb_shop_orders', function ($table) {
            //$table->string('payment_method', 20);
            //$table->text('comment')->nullable();
            $table->string('invoice')->nullable()->after('billing_address_id');
            $table->decimal('tax', 15, 4)->nullable()->after('invoice');
            $table->decimal('shipping', 15, 2)->nullable()->after('tax');
            $table->decimal('subtotal', 15, 2)->nullable()->after('shipping');
            $table->decimal('total', 15, 2)->nullable()->after('subtotal');
            $table->text('comment')->nullable()->after('total');
        });
    }
}