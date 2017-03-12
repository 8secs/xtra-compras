<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 2/11/16
 * Time: 9:36
 */

namespace Istheweb\Shop\Updates;


use Illuminate\Support\Facades\Schema;
use October\Rain\Database\Updates\Migration;

class UpdateFiltersTable extends Migration
{
    public function up()
    {
        Schema::table('istheweb_shop_filters', function ($table) {
            $table->string('value', 60);
        });
    }
}