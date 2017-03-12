<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 5/11/16
 * Time: 19:30
 */

namespace Istheweb\Rating\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateRatingsTable extends Migration
{
    public function up()
    {
        Schema::table('istheweb_rating_ratings', function(Blueprint $table) {
            $table->text('review');
        });
    }
}