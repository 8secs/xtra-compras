<?php namespace Istheweb\IsPdf\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use October\Rain\Exception\ApplicationException;
use Istheweb\IsPdf\Classes\PDF;

/**
 * Templates Back-end Controller
 */
class Templates extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var array
     */
    public $requiredPermissions = ['istheweb.ispdf.manage_templates'];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsPdf', 'ispdf', 'templates');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function previewPdf($id)
    {
        try {
            $this->pageTitle = trans('istheweb.ispdf::lang.templates.preview_pdf');
            $model = $this->formFindModelObject($id);

            return PDF::loadTemplate($model->code)->stream();
        } catch (ApplicationException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Renders HTML for given template ID
     *
     * @param $id
     * @return mixed
     */
    public function html($id)
    {
        $model = $this->formFindModelObject($id);

        return response($model->html);
    }
}