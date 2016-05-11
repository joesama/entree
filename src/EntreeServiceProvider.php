<?php namespace Threef\Entree;

use Illuminate\Routing\Router;
use Orchestra\Foundation\Support\Providers\ModuleServiceProvider;


/**
 * Wrapper extension for threef development
 *
 * @package Threef\Entree
 * @author joharijumali@gmail.com
 **/
class EntreeServiceProvider extends ModuleServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = FALSE;

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'orchestra.install.schema: users' => [
            'Threef\Entree\Event\Listener\EntreeUser'],
        'threef.user.profile' => [
            'Threef\Entree\Event\Listener\EntreeUserProfile'],
        'threef.user.login' => [
            'Threef\Entree\Event\Listener\EntreeUserLogin'],
        'orchestra.install: user' => [
            'Threef\Entree\Event\Listener\EntreeRegisterUser'],
        'orchestra.list: users' => [
            'Threef\Entree\Event\Listener\Presenter\EntreeUserGrid'],
        'entree.user.list: action' => [
            'Threef\Entree\Event\Listener\Presenter\EntreeUserGridAction'],
        'orchestra.install.schema' => [
            'Threef\Entree\Event\Listener\EntreeMigrator']
    ];

    /**
     * The application's or extension's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        
    ];

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
    protected function bootExtensionComponents()
    {
        $path = realpath(__DIR__.'/../resources');

        $this->publishOrchestraLang($path);

        $this->addLanguageComponent('threef/entree', 'entree', $path.'/lang');
        $this->addConfigComponent('threef/entree', 'entree', $path.'/config');
        $this->addViewComponent('threef/entree', 'entree', $path.'/views');

    }

    /**
     * Publishing Orchestral Lang MS
     **/
    protected function publishOrchestraLang($path)
    {
        $this->publishes([
            $path.'/lang/orchestra' => base_path('resources/lang/packages/orchestra/foundation/ms'),
            $path.'/lang/app' => base_path('resources/lang/ms'),
        ]);
    }


    /**
     * Boot extension routing.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $path = realpath(__DIR__);

        $this->loadFrontendRoutesFrom($path.'/routes.php');
    }


    /**
     * Registering Entree Services
     *
     * @return void
     * @author 
     **/
    protected function registeringEntreeServices()
    {
        // Bind Orchestra\Model\User with Threef\Entree\User\User
        // $this->app->bind('Orchestra\Model\User', 'Threef\Entree\Database\Model\User');
        // $this->app->bind('Orchestra\Html\HtmlBuilder', 'Collective\Html\HtmlBuilder');
    }

} // END class Entree 