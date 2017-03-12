<?php namespace Istheweb\Shop\Models;

use RainLab\Translate\Models\Message;
use System\Models\MailTemplate;
use Illuminate\Support\Facades\Lang;

/**
 * OrderStatus Model
 */
class OrderStatus extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_order_statuses';

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
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getEmailTemplateOptions()
    {
        return MailTemplate::listAllTemplates();
    }

    public function getSendEmailAttribute($attribute)
    {
        if($attribute == 1){
            $attribute = Lang::get('istheweb.shop::lang.labels.yes');
        }else{
            $attribute = Lang::get('istheweb.shop::lang.labels.no');
        }
        return $attribute;
    }

    public function getAttachInvoiceAttribute($attribute)
    {
        if($attribute == 1){
            $attribute = Lang::get('istheweb.shop::lang.labels.yes');
        }else{
            $attribute = Lang::get('istheweb.shop::lang.labels.no');
        }
        return $attribute;
    }
}