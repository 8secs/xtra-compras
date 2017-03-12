<?php namespace Istheweb\Shop\Controllers;

use Istheweb\Shop\Models\Shipping;
use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Lang;
use October\Rain\Support\Facades\Flash;

/**
 * Shippings Back-end Controller
 */
class Shippings extends Controller
{
    public $requiredPermissions = ['istheweb.shop.access_shippings'];

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

        BackendMenu::setContext('Istheweb.Shop', 'shop', 'shippings');
    }

    /**
     * Deleted checked services.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $categoryId) {
                if (!$category = Shipping::find($categoryId)) {
                    continue;
                }

                $category->delete();
            }

            Flash::success(Lang::get('istheweb.shop::lang.shippings.delete_selected_success'));
        } else {
            Flash::error(Lang::get('istheweb.shop::lang.shippings.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}