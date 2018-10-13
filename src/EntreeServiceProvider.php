<?php

namespace Joesama\Entree;

use Orchestra\Foundation\Support\Providers\ModuleServiceProvider;

/**
 * Wrapper extension for joesama development.
 *
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
    protected $namespace = 'Joesama\Entree';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'joesama.system.trail' => [
            Event\Listener\EntreeSystemAccess::class, ],
        'joesama.user.profile' => [
            Event\Listener\EntreeUserProfile::class, ],
        'joesama.user.login' => [
            Event\Listener\EntreeUserLogin::class, ],
        'Illuminate\Auth\Events\Logout' => [
            Event\Listener\EntreeUserLogout::class, ],
        'Illuminate\Auth\Events\Lockout' => [
            Event\Listener\EntreeUserAttempting::class, ],
        'orchestra.install: user' => [
            Event\Listener\EntreeRegisterUser::class, ],
        'joesama.email.user: new' => [
            Event\Listener\Notifications\NewUserEmail::class, ],
        'Illuminate\Notifications\Events\NotificationSent' => [
            'Joesama\Entree\Event\Listener\EntreeLogNotification', ],
    ];

    /**
     * The application's or extension's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'entree' => Http\Middleware\VerifyCsrfToken::class,
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
        $this->bindingCsrfVerification();
    }

    /**
     * Booting Entree Views, Language, Configuration.
     **/
    protected function bootExtensionComponents()
    {
        $path = realpath(__DIR__.'/../resources');

        $this->publishOrchestraLang($path);
        $this->publishJavascriptTransformerView($path);
        $this->addLanguageComponent('joesama/entree', 'joesama/entree', $path.'/lang');
        $this->addConfigComponent('joesama/entree', 'joesama/entree', $path.'/config');
        $this->addViewComponent('joesama/entree', 'joesama/entree', $path.'/views');
    }

    /**
     * Publishing Orchestral Lang MS.
     **/
    protected function publishOrchestraLang($path)
    {
        $this->publishes([
            $path.'/lang/orchestra' => base_path('resources/lang/packages/orchestra/foundation/ms'),
            $path.'/lang/app'       => base_path('resources/lang/ms'),
        ]);
    }

    /**
     * Publishing Javascript Transformer View.
     **/
    protected function publishJavascriptTransformerView($path)
    {
        $this->publishes([
            $path.'/views/entree/phptojs' => base_path('resources/views'),
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
     * Registering Menu Handler.
     *
     **/
    protected function registerMenuHandler()
    {
        $this->app->bind('entreemenu', EntreeMenu::class);
        $this->app->bind('entreecrumbler', EntreeCrumbler::class);
        $this->app->bind('announcer', Services\Notification\Announcement::class);
        $this->app->bind('emaillog', Database\Repository\NotificationLog::class);
    }

    /**
     * Bind Login Validation.
     *
     **/
    protected function bindingUserValidation()
    {
        $this->app->when('Orchestra\Foundation\Processors\AuthenticateUser')
          ->needs('Orchestra\Foundation\Validation\AuthenticateUser')
          ->give('Joesama\Entree\Http\Validation\User');
    }

    /**
     * Bind CSRF Token Verification.
     *
     **/
    protected function bindingCsrfVerification()
    {
        $this->app->when('Orchestra\Foundation\Http\Middleware\VerifyCsrfToken')
          ->needs('Illuminate\Foundation\Http\Middleware\VerifyCsrfToken')
          ->give('Joesama\Entree\Http\Middleware\VerifyCsrfToken');
    }
} // END class Entree
