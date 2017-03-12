<?php namespace Istheweb\Rating;

use Backend;
use System\Classes\PluginBase;

/**
 * Rating Plugin Information File
 */
class Plugin extends PluginBase
{

    //public $require = ['Rainlab.User'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'istheweb.rating::lang.plugin.name',
            'description' => 'istheweb.rating::lang.plugin.description',
            'author'      => 'Istheweb',
            'icon'        => 'icon-star'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Istheweb\Rating\Components\Ratings' => 'Ratings',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'istheweb.rating.some_permission' => [
                'tab' => 'Rating',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'rating' => [
                'label'       => 'Rating',
                'url'         => Backend::url('istheweb/rating/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['istheweb.rating.*'],
                'order'       => 500,
            ],
        ];
    }

}
