<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 17/05/16
 * Time: 19:51
 */

namespace Istheweb\Shop\Updates;


use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAddressesCoutriesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_shop_addresses_countries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('address_id')->unsigned()->nullable()->index();
            $table->integer('country_id')->unsigned()->nullable()->index();
        });

        Schema::create('istheweb_shop_addresses_states', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('address_id')->unsigned()->nullable()->index();
            $table->integer('state_id')->unsigned()->nullable()->index();

        });
    }

    public function down()
    {

        Schema::dropIfExists('istheweb_shop_addresses_countries');
        Schema::dropIfExists('istheweb_shop_addresses_states');
    }

}