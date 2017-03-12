<?php namespace Istheweb\IsPdf\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use Istheweb\IsPdf\Classes\PDF;

/**
 * Template Model
 */
class Template extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_ispdf_templates';

    /**
     * @var array
     */
    public $belongsTo = [
        'layout' => Layout::class,
    ];

    /**
     * @var array
     */
    public $rules = [
        'title' => 'required|max:100',
        'code' => 'required|max:50|unique:istheweb_ispdf_pdf_templates',
        'content_html' => 'required',
    ];

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'code', 'content_html', 'layout'];

    /**
     * @var array
     */
    public $attributeNames = [
        'title' => 'istheweb.ispdf::lang.templates.title',
        'code' => 'istheweb.ispdf::lang.templates.code',
        'content_html' => 'istheweb.ispdf::lang.templates.content_html'
    ];

    /**
     * @return mixed
     */
    public function getHtmlAttribute()
    {
        return PDF::loadTemplate($this->code)->getDompdf()->output_html();
    }

    /**
     * Find template by code
     *
     * @param $code
     * @return mixed
     */
    public static function byCode($code)
    {
        return static::whereCode($code)->firstOrFail();
    }

}