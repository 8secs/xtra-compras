<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 19/11/16
 * Time: 12:35
 */

namespace Istheweb\Shop\Updates;


use Illuminate\Support\Facades\Schema;
use October\Rain\Database\Updates\Migration;

class UpdateCurrencyTable extends Migration
{
    public function up()
    {
        Schema::table('istheweb_shop_currencies', function ($table) {
            $table->string('three-code', 3)->nullable();
        });
    }

}