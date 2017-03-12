<?php namespace Istheweb\Rating\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_rating_ratings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('rating');
            $table->morphs('ratingable');
            $table->morphs('author');
            $table->text('review');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_rating_ratings');
    }
}
