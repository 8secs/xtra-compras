<?php namespace Istheweb\IsPdf\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLayoutsTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_ispdf_layouts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('content_html')->nullable();
            $table->text('content_css')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_ispdf_layouts');
    }
}
