<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 17/05/16
 * Time: 13:20
 */

namespace Istheweb\Shop\Updates;


use Schema;
use October\Rain\Database\Updates\Migration;


class UpdatePivotsTable extends Migration
{
    public $models = [
        'feature',
    ];

    public function up()
    {
        Schema::table('istheweb_shop_pivots', function ($table) {
            foreach ($this->models as $model) {
                $table->integer($model . '_id')->unsigned()->nullable()->index();
            }
        });
    }
}