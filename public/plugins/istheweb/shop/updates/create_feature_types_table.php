<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Carbon\Carbon;

class CreateFeatureTypesTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_feature_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            //$table->string('value')->nullable();
            $table->date('published_at')->default(Carbon::now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_feature_types');
    }

}
