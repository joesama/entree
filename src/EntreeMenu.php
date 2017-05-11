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

    	$menu->add('config','>')
            ->title(trans('threef/entree::title.config.title'))
            ->icon('fa fa-cogs');

        $menu->add('menu','^:config')
            ->title(trans('threef/entree::title.config.menu'))
            ->link(handles('threef/entree::menu'))
            ->icon('fa fa-link');

        /** 

        @TODO : Report Menu

        $menu->add('report','^:config')
            ->title(trans('threef/entree::report.menu.report'))
            ->link(handles('threef/entree::menu'))
            ->icon('fa fa-bar-chart');

        $menu->add('reportlist','^:config.report')
            ->title(trans('threef/entree::report.menu.report-list'))
            ->link(handles('threef/entree::report/list'))
            ->icon('fa fa-chevron-circle-right');

        $menu->add('reportgroup','^:config.report')
            ->title(trans('threef/entree::report.menu.report-group'))
            ->link(handles('threef/entree::report/category'))
            ->icon('fa fa-chevron-circle-right');

        $menu->add('reportaccess','^:config.report')
            ->title(trans('threef/entree::report.menu.report-assign'))
            ->link(handles('threef/entree::report/access'))
            ->icon('fa fa-chevron-circle-right');

        **/

        $menu->add('roles','^:config')
            ->title(trans('threef/entree::entree.role.manage'))
            ->icon('fa fa-user');

        $menu->add('role-list','^:config.roles')
            ->title(trans('threef/entree::entree.role.list'))
            ->link(handles('threef/entree::roles'))
            ->icon('fa fa-chevron-circle-right');

        $menu->add('role-new','^:config.roles')
            ->title(trans('threef/entree::entree.role.new'))
            ->link(handles('threef/entree::roles/new'))
            ->icon('fa fa-chevron-circle-right');

        $menu->add('user','^:config')
            ->title(trans('threef/entree::entree.user.manage'))
            ->link(handles('threef/entree::user'))
            ->icon('fa fa-user');

        $menu->add('user-list','^:config.user')
            ->title(trans('threef/entree::entree.user.list'))
            ->link(handles('threef/entree::user'))
            ->icon('fa fa-chevron-circle-right');

        $menu->add('user-new','^:config.user')
            ->title(trans('threef/entree::entree.user.new'))
            ->link(handles('threef/entree::user/new'))
            ->icon('fa fa-chevron-circle-right');

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