<?php namespace Istheweb\IsPdf\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use Istheweb\Connect\Models\CompanySettings;
use October\Rain\Exception\ApplicationException;
use Istheweb\IsPdf\Classes\PDF;

/**
 * Layouts Back-end Controller
 */
class Layouts extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var array
     */
    public $requiredPermissions = ['istheweb.ispdf.manage_layouts'];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsPdf', 'ispdf', 'layouts');
    }

    public function update($recordId, $context = null)
    {
        $company = CompanySettings::instance();
        $this->vars['company'] = $company;
        // Call the FormController behavior update() method
        return $this->asExtension('FormController')->update($recordId, $context);
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

            return PDF::loadLayout($model->code)->stream();
        } catch (ApplicationException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Renders HTML for given layout ID
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