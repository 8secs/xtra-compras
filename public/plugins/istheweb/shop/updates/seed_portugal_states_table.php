<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 17/07/16
 * Time: 8:35
 */

namespace Istheweb\Shop\Updates;

use October\Rain\Database\Updates\Seeder;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;

class SeedPortugalStatesTable extends Seeder
{
    public function run()
    {
        $pt = Country::whereCode('PT')->first();

        $pt->states()->createMany([
            ['name' => 'Aveiro', 'code' => '73'],
            ['name' => 'Azores', 'code' => '81'],
            ['name' => 'Beja', 'code' => '66'],
            ['name' => 'Braga', 'code' => '78'],
            ['name' => 'Braganza', 'code' => '75'],
            ['name' => 'Castelo Branco', 'code' => '70'],
            ['name' => 'Coimbra', 'code' => '72'],
            ['name' => 'Évora', 'code' => '68'],
            ['name' => 'Faro', 'code' => '67'],
            ['name' => 'Guarda', 'code' => '71'],
            ['name' => 'Leiria', 'code' => '63'],
            ['name' => 'Lisboa', 'code' => '62'],
            ['name' => 'Madeira', 'code' => '80'],
            ['name' => 'Oporto', 'code' => '77'],
            ['name' => 'Portalegre', 'code' => '69'],
            ['name' => 'Santarém', 'code' => '64'],
            ['name' => 'Setúbal', 'code' => '65'],
            ['name' => 'Viana do Castelo', 'code' => '79'],
            ['name' => 'Vila Real', 'code' => '76'],
            ['name' => 'Viseu', 'code' => '74'],
        ]);
    }
}