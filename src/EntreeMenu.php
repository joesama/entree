<?php

namespace Joesama\Entree;

use Illuminate\Foundation\Application;
use Orchestra\Contracts\Authorization\Factory;

/**
  * undocumented class.
  *
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

     public function __construct(Application $app, Factory $acl)
     {
         $this->widget = $app->make('orchestra.widget');
         $this->acl = $app->make('orchestra.acl');
         $this->memory = $app->make('orchestra.memory')->make();

         $this->loadMenuServices();
     }

     /**
      * Load Entree Menu.
      *
      **/
     protected function loadMenuServices()
     {
         $menu = $this->widget->make('menu.entree');
         $this->acl = $this->acl->make('entree', $this->memory);

         $this->generateMenuService($menu);

         $this->menu = $menu;
     }

     /**
      * Generate Entree Menu.
      *
      **/
     protected function generateMenuService($menu)
     {
         $menu->add('home')
            ->title(trans('joesama/entree::title.home'))
            ->link(handles('joesama/entree::home'))
            ->icon('fa fa-home');

         $menu->add('config', '>')
            ->title(trans('joesama/entree::title.config.title'))
            ->icon('fa fa-cogs');

         $menu->add('menu', '^:config')
            ->title(trans('joesama/entree::title.config.menu'))
            ->link(handles('joesama/entree::menu'))
            ->icon('fa fa-link');

         $menu->add('base', '^:config')
            ->title(trans('joesama/entree::title.config.base'))
            ->link(handles('joesama/entree::base'))
            ->icon('fa fa-info');

         /*

         @TODO : Report Menu

         $menu->add('report','^:config')
             ->title(trans('joesama/entree::report.menu.report'))
             ->link(handles('joesama/entree::menu'))
             ->icon('fa fa-bar-chart');

         $menu->add('reportlist','^:config.report')
             ->title(trans('joesama/entree::report.menu.report-list'))
             ->link(handles('joesama/entree::report/list'))
             ->icon('fa fa-chevron-circle-right');

         $menu->add('reportgroup','^:config.report')
             ->title(trans('joesama/entree::report.menu.report-group'))
             ->link(handles('joesama/entree::report/category'))
             ->icon('fa fa-chevron-circle-right');

         $menu->add('reportaccess','^:config.report')
             ->title(trans('joesama/entree::report.menu.report-assign'))
             ->link(handles('joesama/entree::report/access'))
             ->icon('fa fa-chevron-circle-right');

         **/

         $menu->add('user', '^:config')
            ->title(trans('joesama/entree::entree.user.manage'))
            ->icon('fa fa-user');

         $menu->add('user-list', '^:config.user')
            ->title(trans('joesama/entree::entree.user.list'))
            ->link(handles('joesama/entree::user'))
            ->icon('fa fa-chevron-circle-right');

         $menu->add('user-new', '^:config.user')
            ->title(trans('joesama/entree::entree.user.new'))
            ->link(handles('joesama/entree::user/new'))
            ->icon('fa fa-chevron-circle-right');

         $menu->add('audit', '>:config')
            ->title(trans('joesama/entree::entree.audit.title'))
            ->icon('fa fa-paperclip');

         $menu->add('audit.access', '^:audit')
            ->title(trans('joesama/entree::entree.audit.access'))
            ->link(handles('joesama/entree::audit/access'))
            ->icon('fa fa-universal-access');

         $menu->add('notify', '>:audit')
            ->title(trans('joesama/entree::entree.notify.title'))
            ->icon('fa fa-newspaper-o');

         $menu->add('announcement', '^:notify')
            ->title(trans('joesama/entree::entree.notify.manage'))
            ->link(handles('joesama/entree::notify/announcement'))
            ->icon('fa fa-navicon');

         event('entree.menu:ready', [$menu]);
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
