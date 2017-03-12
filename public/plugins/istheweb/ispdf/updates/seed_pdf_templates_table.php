<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 23/01/17
 * Time: 19:20
 */

namespace istheweb\ispdf\updates;

use File;
use Istheweb\isPdf\Models\Layout;
use Istheweb\isPdf\Models\Template;
use Seeder;

class SeedPdfTemplatesTable extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        $layout = Layout::find(1);

        Template::create([
            'title' => 'Invoice',
            'description' => 'Example Invoice Template',
            'layout' => $layout,
            'code' => 'istheweb::invoice',
            'content_html' => File::get(__DIR__ . '/templates/invoice.htm'),
        ]);
    }

}