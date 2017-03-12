<?php namespace Istheweb\IsPdf;

use Backend;
use System\Classes\PluginBase;
use Istheweb\IsPdf\Classes\ServiceProvider;

/**
 * IsPdf Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'istheweb.ispdf::lang.plugin.name',
            'description' => 'istheweb.ispdf::lang.plugin.description',
            'author' => 'Istheweb',
            'icon' => 'icon-file-pdf-o',
            'homepage' => ''
        ];
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->register(ServiceProvider::class);
    }

    /**
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'ispdf' => [
                'label' => 'istheweb.ispdf::lang.menu.label',
                'url' => Backend::url('istheweb/ispdf/templates'),
                'icon' => 'icon-file-pdf-o',
                'permissions' => ['istheweb.ispdf.*'],
                'order' => 500,
                'sideMenu' => [
                    'templates' => [
                        'label' => 'istheweb.ispdf::lang.templates.templates',
                        'icon' => 'icon-file-text-o',
                        'url' => Backend::url('istheweb/ispdf/templates'),
                        'permissions' => ['istheweb.ispdf.manage_templates']
                    ],
                    'layouts' => [
                        'label' => 'istheweb.ispdf::lang.templates.layouts',
                        'icon' => 'icon-th-large',
                        'url' => Backend::url('istheweb/ispdf/layouts'),
                        'permissions' => ['istheweb.ispdf.manage_layouts']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'istheweb.ispdf.manage_templates' => [
                'tab' => 'istheweb.ispdf::lang.permissions.tab',
                'label' => 'istheweb.ispdf::lang.permissions.manage_templates'
            ],
            'istheweb.ispdf.manage_layouts' => [
                'tab' => 'istheweb.ispdf::lang.permissions.tab',
                'label' => 'istheweb.ispdf::lang.permissions.manage_layouts'
            ]
        ];
    }

}
