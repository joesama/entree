<?php namespace Threef\Entree;

use Illuminate\Support\ServiceProvider;


/**
 * Wrapper extension for threef development
 *
 * @package Threef\Entree
 * @author joharijumali@gmail.com
 **/
class Entree extends ServiceProvider
{

	/**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
    	$path = realpath(__DIR__.'/../');
    	dd($path);
    	$this->bootingExtensions($path);
    	$this->publishExtensionsComponent($path);

    	require_once "{$path}/src/routes.php";
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registeringServices();
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
    protected function registeringServices()
    {
    	$this->app->register('Maatwebsite\Excel\ExcelServiceProvider');
    }

} // END class Entree 