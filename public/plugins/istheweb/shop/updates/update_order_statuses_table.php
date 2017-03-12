<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 25/05/16
 * Time: 8:45
 */

namespace Istheweb\Shop\Updates;

use Illuminate\Support\Facades\Schema;
use October\Rain\Database\Updates\Migration;

class UpdateOrderStatusesTable extends Migration
{
    public function up()
    {
        Schema::table('istheweb_shop_order_statuses', function ($table) {
            $table->string('state', 20);
        });
    }
}