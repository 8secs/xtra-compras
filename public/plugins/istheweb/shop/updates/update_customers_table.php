<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 1/07/16
 * Time: 19:30
 */

namespace Istheweb\Shop\Updates;

use Illuminate\Support\Facades\Schema;
use October\Rain\Database\Updates\Migration;

class UpdateCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('istheweb_shop_customers', function ($table) {
            $table->string('cif', 20);
        });
    }

}