<?php namespace Istheweb\IsPdf\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_ispdf_templates', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('layout_id')->unsigned()->index()->nullable();
            $table->string('code', 50)->unique();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->text('content_html')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_ispdf_templates');
    }
}
