<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 2/07/16
 * Time: 5:59
 */

namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateOrdersTableWithInvoice extends Migration
{
    public function up()
    {
        Schema::table('istheweb_shop_orders', function ($table) {
            $table->string('invoice', 20);
        });
    }
}