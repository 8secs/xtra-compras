<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 23/01/17
 * Time: 19:25
 */

namespace istheweb\ispdf\updates;

use File;
use Istheweb\IsPdf\Models\Layout;
use Seeder;
use System\Models\File as FileModel;

class SeedPdfLayoutsTable extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $this->createLayout();

        $file = $this->findBackgroundImage();

        if ( ! is_object($file)) {
            $this->createBackgroundImage();
        }

        $this->copyBackgroundImageToStorage();
    }

    /**
     * @return void
     */
    protected function createLayout()
    {
        Layout::create([
            'name' => 'Invoice',
            'code' => 'istheweb::invoice',
            'content_html' => File::get(__DIR__ . '/layouts/invoice.htm'),
            'content_css' => File::get(__DIR__ . '/layouts/style_invoice.css'),
        ]);
    }

    /**
     * @return mixed
     */
    protected function findBackgroundImage()
    {
        return FileModel::where([
            'field' => 'background_img',
            'attachment_id' => 1,
            'attachment_type' => Layout::class,
        ])->first();
    }

    /**
     * @return void
     */
    protected function createBackgroundImage()
    {
        FileModel::create([
            'disk_name' => '55428b6d4425d031778535.jpg',
            'file_name' => 'invoice.jpg',
            'file_size' => '47454',
            'content_type' => 'image/jpeg',
            'field' => 'background_img',
            'attachment_id' => 1,
            'attachment_type' => Layout::class,
        ]);
    }

    /**
     * @return void
     */
    protected function copyBackgroundImageToStorage()
    {
        $storage_dir = storage_path('app/uploads/public/554/28b/6d4');
        $file = $storage_dir . '/55428b6d4425d031778535.jpg';

        if ( ! File::exists($storage_dir)) {
            File::makeDirectory($storage_dir, 0755, true);
        }

        if ( ! File::exists($file)) {
            File::copy('plugins/istheweb/ispdf/assets/images/invoice.jpg', $file);
        }
    }
}