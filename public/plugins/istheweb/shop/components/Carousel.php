<?php namespace Istheweb\Shop\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Storage;

class Carousel extends ComponentBase
{

    public $images;

    public function componentDetails()
    {
        return [
            'name'        => 'istheweb.shop::lang.components.carousel.name',
            'description' => 'istheweb.shop::lang.components.carousel.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'folder' => [
                'title'       => 'istheweb.shop::lang.labels.folder',
                'description' => 'istheweb.shop::lang.descriptions.folder',
            ],
            'slideWidth' => [
                'title'       => 'istheweb.shop::lang.labels.slider_width',
                'description' => 'istheweb.shop::lang.descriptions.sliderWidth',
            ],
            'minSlides' => [
                'title'       => 'istheweb.shop::lang.labels.min_slides',
                'description' => 'istheweb.shop::lang.descriptions.minSlides',
            ],
            'maxSlides' => [
                'title'       => 'istheweb.shop::lang.labels.max_slides',
                'description' => 'istheweb.shop::lang.descriptions.maxSlides',
            ],
            'slideMargin' => [
                'title'       => 'istheweb.shop::lang.labels.slide_margin',
                'description' => 'istheweb.shop::lang.descriptions.slideMargin',
            ],
        ];
    }

    public function onRun()
    {
        $this->prepareVars();
    }

    public function prepareVars()
    {
        $this->folder = $this->page['folder'] = $this->property('folder');
        $this->slideWidth = $this->page['slideWidth'] = $this->property('slideWidth');
        $this->minSlides = $this->page['minSlides'] = $this->property('minSlides');
        $this->maxSlides = $this->page['maxSlides'] = $this->property('maxSlides');
        $this->slideMargin = $this->page['slideMargin'] = $this->property('slideMargin');

        $this->images = $this->page['images'] = $this->getImages();
        //dd($this->images);
    }


    protected function getImages(){
        $files = Storage::allFiles('media/'.$this->property('folder'));
        //dd($files);
        $images = array();
        foreach($files as $file){
            $f = 'storage/app/'.$file;
            $url = url($f);
            array_push($images, $url);
        }
        return $images;
    }
}