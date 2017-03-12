<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 23/05/16
 * Time: 14:43
 */

namespace Istheweb\Shop\Facades;


use October\Rain\Support\Facade;

class Checkout extends Facade
{
    /**
     * Get the registered name of the component.
     * @return string
     */
    protected static function getFacadeAccessor() { return 'checkout.order'; }

}