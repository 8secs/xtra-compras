<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 23/05/16
 * Time: 12:40
 */

namespace Istheweb\Shop\Classes;


use Illuminate\Support\Facades\Session;

class CheckoutManager
{
    use \October\Rain\Support\Traits\Singleton;


    public function content()
    {
        $checkout = $this->getContent();
        return (empty($checkout)) ? NULL : $checkout;
    }

    protected function getInstance(){
       return 'checkout';
    }

    protected function getContent()
    {
        $content = (Session::has($this->getInstance())) ? Session::get($this->getInstance()) : new CheckoutCollection;
        return $content;
    }

    public function has($key){
        $checkout = $this->getContent();
        return $checkout->has($key);
    }

    public function get($key){
        $checkout = $this->getContent();
        return $checkout->get($key);
    }

    public function add($key, $value){
        $checkout = $this->getContent();
        $checkout->put($key, $value);
        Session::put($this->getInstance(), $checkout);
    }

    public function remove($key){
        $checkout = $this->getContent();
        $checkout->forget($key);
        Session::forget($key);
    }

    public function destroy(){
        $checkout = $this->getContent();
        $checkout = $checkout->splice(0);
        Session::put($this->getInstance(), $checkout);
    }
}