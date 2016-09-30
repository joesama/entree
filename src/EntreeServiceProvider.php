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
     * The application or extension group namespace.
     *
     * @var string|null
     */
    protected $routeGroup = '';

    /**
     * The fallback route prefix.
     *
     * @var string
     */
    protected $routePrefix = '/';


    /**
     * The application or extension namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Threef\Entree\Http\Controller';

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
        'Illuminate\Auth\Events\Login' => [
            'Threef\Entree\Event\Listener\EntreeUserLogin'],
        'Illuminate\Auth\Events\Logout' => [
            'Threef\Entree\Event\Listener\EntreeUserLogout'],
        'orchestra.install: user' => [
            'Threef\Entree\Event\Listener\EntreeRegisterUser'],
        'orchestra.list: users' => [
            'Threef\Entree\Event\Listener\Presenter\EntreeUserGrid'],
        'entree.user.list: action' => [
            'Threef\Entree\Event\Listener\Presenter\EntreeUserGridAction']
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
        $this->registerMenuHandler();
        $this->bindingUserValidation();
    }


    /**
     * Booting Entree Views, Language, Configuration
     **/
    protected function bootExtensionComponents()
    {
        $path = realpath(__DIR__.'/../resources');

        $this->publishOrchestraLang($path);
        $this->addLanguageComponent('threef/entree', 'threef/entree', $path.'/lang');
        $this->addConfigComponent('threef/entree', 'threef/entree', $path.'/config');
        $this->addViewComponent('threef/entree', 'threef/entree', $path.'/views');

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
     * Registering Menu Handler
     *
     **/
    protected function registerMenuHandler()
    {
        $this->app->bind('entreemenu', EntreeMenu::class);
        $this->app->bind('entreecrumbler', EntreeCrumbler::class);
    }

    /**
     * Bind Login Validation
     *
     **/
    protected function bindingUserValidation()
    {
        $this->app->when('Orchestra\Foundation\Processor\AuthenticateUser')
          ->needs('Orchestra\Foundation\Validation\AuthenticateUser')
          ->give('Threef\Entree\Http\Validation\User');
    }


} // END class Entree 