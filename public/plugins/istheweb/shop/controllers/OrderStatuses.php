<?php namespace Istheweb\Shop\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Istheweb\Shop\Models\OrderStatus;

/**
 * Order Statuses Back-end Controller
 */
class OrderStatuses extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.Shop', 'shop', 'orderstatuses');
    }

    public function getAttribute($attribute){

    }

    /**
     * Deleted checked Order Status.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $orderId) {
                if (!$order = OrderStatus::find($orderId)) {
                    continue;
                }

                $order->delete();
            }

            Flash::success(Lang::get('istheweb.shop::lang.order_statuses.delete_selected_success'));
        } else {
            Flash::error(Lang::get('istheweb.shop::lang.order_statuses.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}