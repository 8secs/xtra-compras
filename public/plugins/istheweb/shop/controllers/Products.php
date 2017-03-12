<?php namespace Istheweb\Shop\Controllers;

use Istheweb\Shop\Models\Product;
use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Lang;
use October\Rain\Support\Facades\Flash;

/**
 * Products Back-end Controller
 */
class Products extends Controller
{
    public $requiredPermissions = ['istheweb.shop.access_products'];

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ImportExportController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.Shop', 'shop', 'products');
    }

    /**
     * Deleted checked products.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $productId) {
                if (!$product = Product::find($productId)) {
                    continue;
                }

                $product->delete();
            }

            Flash::success(Lang::get('istheweb.shop::lang.products.delete_selected_success'));
        } else {
            Flash::error(Lang::get('istheweb.shop::lang.products.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}