<?php 

namespace Threef\Entree\Http\Middleware;

use Orchestra\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['ms'];

    public function handle( $request, \Closure $next )
    {

        event('threef.system.trail',[$request->getUri(),$request->getMethod()]);

        $sessionLang = 'lang' . str_replace('.', '' , app(\Threef\Entree\Entity\IpOrigin::class)->ipOrigin());

        if(!\Session::has($sessionLang))
        {
            \Session::put($sessionLang, $request->getPreferredLanguage($this->languages));
        }

        app()->setLocale(\Session::get($sessionLang));

        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->shouldPassThrough($request) ||
            $this->tokensMatch($request)
        ) {
            return $this->addCookieToResponse($request, $next($request));
        }

        // redirect the user back to the last page and show error
        return Redirect::back()->withError('Sorry, we could not verify your request. Please try again.');
    }


}
