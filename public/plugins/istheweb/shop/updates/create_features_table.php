<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Carbon\Carbon;

class CreateFeaturesTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_features', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('feature_type_id')->unsigned();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->date('published_at')->default(Carbon::now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_features');
    }

}
