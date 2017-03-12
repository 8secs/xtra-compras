<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 8/08/16
 * Time: 19:44
 */

namespace istheweb\shop\traits;

use Istheweb\Shop\Models\Product as ShopProduct;
use Gloudemans\Shoppingcart\Facades\Cart;


trait WishlistTrait
{
    /**
     * Items in Wishlist
     * @var collection
     */
    public $wishlistItems;

    public function registerWishlistInfo()
    {
        $content = Cart::instance('wishlist')->content();
        $content->each(function ($row) {
            $product = ShopProduct::with('picture')
                ->where('id', $row->product->id)
                ->first();
            $picture = $product->getRelation('picture');
            $row->slug = $row->product->slug;
            $row->picture = $picture;
        });

        $this->wishlistItems = $this->page['wishlistItems'] = $content;
        $this->wishlistCount = $this->page['wishlistCount'] = Cart::instance('wishlist')->count();
    }

    public function onAddProductToWishlist()
    {
        $id = post('id');
        $quantity = post('quantity') ?: 1;
        $product = ShopProduct::find($id);


        Cart::instance('wishlist')->associate('Product', 'Istheweb\Shop\Models')->add(
            $id,
            $product->name,
            $quantity,
            $product->price
        );

        $this->registerWishlistInfo();
    }

    public function onRemoveProductFromWishtlist()
    {
        Cart::instance('wishlist')->remove(post('rowid'));

        $this->registerWishlistInfo();
    }
}