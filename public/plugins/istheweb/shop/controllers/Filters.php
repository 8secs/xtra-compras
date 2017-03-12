<?php namespace Istheweb\Shop\Controllers;

use BackendMenu;
use Lang;
use Flash;
use Backend\Classes\Controller;
use Istheweb\Shop\Models\Filter;

/**
 * Filters Back-end Controller
 */
class Filters extends Controller
{
    public $requiredPermissions = ['istheweb.shop.access_filters'];

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.Shop', 'shop', 'filters');
    }

    /**
     * Deleted checked services.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $categoryId) {
                if (!$category = Filter::find($categoryId)) {
                    continue;
                }

                $category->delete();
            }

            Flash::success(Lang::get('istheweb.shop::lang.filters.delete_selected_success'));
        } else {
            Flash::error(Lang::get('istheweb.shop::lang.filters.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}