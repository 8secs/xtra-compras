<?php namespace Istheweb\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Carbon\Carbon;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('istheweb_shop_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug')->index()->unique();
            $table->text('description');
            $table->string('modelo')->nullable();
            $table->decimal('price', 10, 2)->default(0)->nullable();
            $table->boolean('is_stockable')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('stock')->default(0)->nullable();
            $table->date('published_at')->default(Carbon::now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_shop_products');
    }

}
