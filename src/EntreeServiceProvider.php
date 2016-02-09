<?php namespace Threef\Entree;

use Illuminate\Support\ServiceProvider;


/**
 * Wrapper extension for threef development
 *
 * @package Threef\Entree
 * @author joharijumali@gmail.com
 **/
class EntreeServiceProvider extends ServiceProvider
{

	/**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
    	$path = realpath(__DIR__.'/../');
    	$this->bootingExtensions($path);
    	$this->publishExtensionsComponent($path);
        $this->bootingEventListener();
        $this->publishOrchestraLang($path);

    	require_once "{$path}/src/routes.php";
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registeringEntreeServices();
    }


    /**
     * Booting Entree Views, Language, Configuration
     **/
    protected function bootingExtensions($path)
    {
         $this->loadViewsFrom($path.'/resources/views', 'entree');
         $this->loadTranslationsFrom($path.'/resources/lang', 'entree');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function publishOrchestraLang($path)
    {
        $this->publishes([
            $path.'/resources/lang/orchestra' => base_path('resources/lang/packages/orchestra/foundation/ms'),
            $path.'/resources/lang/app' => base_path('resources/lang/ms'),
        ]);
    }


    /**
     * Booting Event Listener
     **/
    protected function bootingEventListener()
    {
        //  Register Listener For User Related Database
        $this->bootUserEventListener();

        $this->app['events']->listen('orchestra.install.schema', 'Threef\Entree\Event\Listener\EntreeMigrator');


    }


    /**
     * User Related Event Listener
     **/
    protected function bootUserEventListener()
    {
        $this->app['events']->listen('orchestra.install.schema: users', 'Threef\Entree\Event\Listener\EntreeUser');
        $this->app['events']->listen('threef.user.profile', 'Threef\Entree\Event\Listener\EntreeUserProfile');
        $this->app['events']->listen('threef.user.login', 'Threef\Entree\Event\Listener\EntreeUserLogin');
        $this->app['events']->listen('orchestra.install: user', 'Threef\Entree\Event\Listener\EntreeRegisterUser');
        $this->app['events']->listen('orchestra.list: users', 'Threef\Entree\Event\Listener\Presenter\EntreeUserGrid');
        $this->app['events']->listen('entree.user.list: action', 'Threef\Entree\Event\Listener\Presenter\EntreeUserGridAction');
    }


    /**
     * Publish Public Component
     *
     **/
    protected function publishExtensionsComponent($path)
    {
    	$this->publishes([
	        $path.'/resources/public' => public_path('threef/entree'),
	    ], 'public');


    }


    /**
     * Registering Entree Services
     *
     * @return void
     * @author 
     **/
    protected function registeringEntreeServices()
    {
        $this->app->register('Maatwebsite\Excel\ExcelServiceProvider');
        $this->app->register('Yajra\Datatables\DatatablesServiceProvider');
    	$this->app->register('Collective\Html\HtmlServiceProvider');

        // Bind Orchestra\Model\User with Threef\Entree\User\User
        $this->app->bind('Orchestra\Model\User', 'Threef\Entree\Database\Model\User');
        $this->app->bind('Orchestra\Html\HtmlBuilder', 'Collective\Html\HtmlBuilder');
    }

} // END class Entree 