<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 8/08/16
 * Time: 20:54
 */

namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;


class UpdateProductsTable extends Migration
{
    public function up()
    {
        Schema::table('istheweb_shop_products', function ($table) {
            $table->boolean('on_sale')->default(false);
            $table->float('discount')->nullable();
        });
    }
}