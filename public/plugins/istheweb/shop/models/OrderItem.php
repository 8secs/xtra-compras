<?php namespace Istheweb\Shop\Models;

use Model;

/**
 * OrderItem Model
 */
class OrderItem extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_order_items';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'order'     => 'Istheweb\Shop\Models\Order',
        'variant'   => 'Istheweb\Shop\Models\Variant',
    ];
    public $belongsToMany = [

    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}