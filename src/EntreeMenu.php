<?php namespace Threef\Entree;

use Illuminate\Foundation\Application;

/**
  * undocumented class
  *
  * @package threef/entree
  * @author joharijumali@gmail.com
  **/
 class EntreeMenu
 {


    /**
     * The widget manager.
     *
     * @var \Orchestra\Widget\WidgetManager
     */
    protected $widget;

    /**
     * Entre Menu.
     *
     * @var \Orchestra\Widget\Handlers\Menu
     */
    protected $menu;


    public function __construct(Application $app)
    {
    	$this->widget = $app->make('orchestra.widget');

    	$this->loadMenuServices();

    }


    /**
     * Load Entree Menu
     *
     **/
    protected function loadMenuServices()
    {
    	$menu = $this->widget->make("menu.entree");

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
            ->icon('glyphicon glyphicon-home');

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


 } // END class EntreeMenu  