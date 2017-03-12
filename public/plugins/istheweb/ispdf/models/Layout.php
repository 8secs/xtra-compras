<?php namespace Istheweb\IsPdf\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use Istheweb\IsPdf\Classes\PDF;
use System\Models\File;

/**
 * Layout Model
 */
class Layout extends Model
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_ispdf_layouts';

    /**
     * @var array
     */
    public $rules = [
        'name' => 'required|max:100',
        'code' => 'required|max:50|unique:istheweb_ispdf_pdf_layouts',
        'content_html' => 'required',
    ];

    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'content_html', 'content_css'];

    /**
     * @var array
     */
    public $attachOne = [
        'background_img' => File::class,
    ];

    /**
     * @var array
     */
    public $attributeNames = [
        'name' => 'istheweb.ispdf::lang.templates.name',
        'code' => 'istheweb.ispdf::lang.templates.code',
        'content_html' => 'istheweb.ispdf::lang.templates.content_html'
    ];

    /**
     * @return mixed
     */
    public function getHtmlAttribute()
    {
        return PDF::loadLayout($this->code)->getDompdf()->output_html();
    }

    /**
     * Find layout by code
     *
     * @param $code
     * @return mixed
     */
    public static function byCode($code)
    {
        return static::whereCode($code)->firstOrFail();
    }

}