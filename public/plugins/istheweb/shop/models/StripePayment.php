<?php namespace Istheweb\Shop\Models;


/**
 * StripePayment Model
 */
class StripePayment extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_stripe_payments';

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
        'order'         => 'Istheweb\Shop\Models\Order'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}