<?php namespace Threef\Entree;

use Illuminate\Foundation\Application;
use Orchestra\Contracts\Authorization\Factory;

/**
  * undocumented class
  *
  * @package threef/entree
  * @author joharijumali@gmail.com
  **/
 class EntreeMenu
 {


    const KEY = 'menu.entree';

    /**
     * The widget manager.
     *
     * @var \Orchestra\Widget\WidgetManager
     */
    protected $widget;

    /**
     * Entree Menu.
     *
     * @var \Orchestra\Widget\Handlers\Menu
     */
    protected $menu;

    /**
     * Entree Menu  ACL.
     *
     * @var \Orchestra\Widget\Handlers\Menu
     */
    protected $acl;


    public function __construct(Application $app,Factory $acl)
    {

        $this->widget = $app->make('orchestra.widget');
    	$this->acl = $app->make('orchestra.acl');
        $this->memory = $app->make('orchestra.memory')->make();

    	$this->loadMenuServices();

    }


    /**
     * Load Entree Menu
     *
     **/
    protected function loadMenuServices()
    {

    	$menu = $this->widget->make("menu.entree");
        $this->acl = $this->acl->make('entree',$this->memory);

    	$this->generateMenuService($menu);

    	$this->menu = $menu;

    }


    /**
     * Generate Entree Menu
     *
     **/
    protected function generateMenuService($menu)
    {
        $menu->add('home')
            ->title(trans('threef/entree::title.home'))
            ->link(handles('threef/entree::home'))
            ->icon('fa fa-home');

    	$menu->add('config','>:home')
            ->title(trans('threef/entree::title.config.title'))
            ->icon('fa fa-cogs');

        $menu->add('menu','^:config')
            ->title(trans('threef/entree::title.config.menu'))
            ->link(handles('threef/entree::menu'))
            ->icon('fa fa-link');

        $menu->add('report','^:config')
            ->title(trans('threef/entree::report.menu.report'))
            ->link(handles('threef/entree::menu'))
            ->icon('fa fa-bar-chart');

        $menu->add('reportlist','^:config.report')
            ->title(trans('threef/entree::report.menu.report-list'))
            ->link(handles('threef/entree::menu'))
            ->icon('fa fa-chevron-circle-right');

        $menu->add('reportgroup','^:config.report')
            ->title(trans('threef/entree::report.menu.report-group'))
            ->link(handles('threef/entree::menu'))
            ->icon('fa fa-chevron-circle-right');

        $menu->add('reportaccess','^:config.report')
            ->title(trans('threef/entree::report.menu.report-assign'))
            ->link(handles('threef/entree::menu'))
            ->icon('fa fa-chevron-circle-right');

        // dd($menu);

        event('entree.menu:ready',[$menu]);
    }

    /**
     * Get menu services.
     *
     * @return \Orchestra\Widget\Handlers\Menu
     */
    public function menu()
    {
        return $this->menu;
    }

    /**
     * Get menu ACL services.
     *
     * @return \Orchestra\Authorization\Authorization
     */
    public function acl()
    {
        return $this->acl;
    }    

    /**
     * Get app memory services.
     *
     * @return \Orchestra\Contracts\Memory\Provider
     */
    public function memory()
    {
    	return $this->memory;
    }


 } // END class EntreeMenu  