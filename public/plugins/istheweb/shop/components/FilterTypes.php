<?php namespace Istheweb\Shop\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use Istheweb\Shop\Models\Filter;
use Istheweb\Shop\Models\FilterType;

class FilterTypes extends ComponentBase
{

    public $filter_types;

    public $color_filters;

    public $size_filters;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    public function componentDetails()
    {
        return [
            'name'        => 'istheweb.shop::lang.components.filter_types.name',
            'description' => 'istheweb.shop::lang.components.filter_types.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'orderBy'  => [
                'title'       => 'istheweb.shop::lang.labels.orderBy',
                'description' => 'istheweb.shop::lang.descriptions.orderBy',
                'type'        => 'dropdown',
                'default'     => 'id',
            ],
            'sort'     => [
                'title'       => 'istheweb.shop::lang.labels.sort',
                'description' => 'istheweb.shop::lang.descriptions.sort',
                'type'        => 'dropdown',
                'default'     => 'desc',
            ],
            'categoryPage' => [
                'title'       => 'istheweb.shop::lang.category.label',
                'description' => 'istheweb.shop::lang.lang.category.description',
                'type'        => 'dropdown',
                'default'     => 'categories',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions (){
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $filter_types = FilterType::published()
            ->with('filters')
            ->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
            ->get();
        $this->filter_types = $this->page['filter_types'] = $filter_types;

        $color_types = $this->getFilterType('color');
        $this->color_filters = $this->page['color_filters'] = $color_types;

        $size_types = $this->getFilterType('size');
        $this->size_filters = $this->page['size_filters'] = $size_types;

    }

    public function getFilterType($type){
        return FilterType::published()
            ->applyType($type)
            ->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
            ->get();
    }

    public function getOrderByOptions()
    {
        $schema = Schema::getColumnListing('istheweb_shop_filter_types');
        foreach ($schema as $column) {
            $options[$column] = ucwords(str_replace('_', ' ', $column));
        }
        return $options;
    }

    public function getSortOptions()
    {
        return [
            'desc' => Lang::get('istheweb.shop::lang.labels.descending'),
            'asc'  => Lang::get('istheweb.shop::lang.labels.ascending'),
        ];
    }

}