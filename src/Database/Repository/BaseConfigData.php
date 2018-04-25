<?php

namespace Threef\Entree\Database\Repository;

use Orchestra\Contracts\Memory\Provider;

/**
 * Base Config Data Processing class.
 *
 * @author
 **/
class BaseConfigData
{
    public function __construct(Provider $memory)
    {
        $this->memory = $memory;
        $this->locale = \App::getLocale();
    }

    /**
     * Default Application Name.
     *
     * @return string
     */
    protected function defaultApplicationAbbr()
    {
        return memorize('threef.'.$this->locale.'.abbr');
    }

    /**
     * Default Contact Info.
     *
     * @return string
     */
    protected function defaultContact()
    {
        return memorize('threef.'.$this->locale.'.contact');
    }

    /**
     * Default Application Name.
     *
     * @return string
     */
    protected function defaultApplicationName()
    {
        return memorize('threef.'.$this->locale.'.name', memorize('site.name'));
    }

    /**
     * Default Application Summary.
     *
     * @return string
     */
    protected function defaultApplicationSummary()
    {
        return memorize('threef.'.$this->locale.'.description', memorize('site.description'));
    }

    /**
     * Default Application Logo.
     *
     * @return string
     */
    protected function defaultApplicationLogo()
    {
        return memorize('threef.logo');
    }

    /**
     * Default Application Logo.
     *
     * @return string
     */
    protected function defaultApplicationFavicon()
    {
        return memorize('threef.favicon');
    }

    /**
     * Default Application Logo.
     *
     * @return string
     */
    protected function defaultApplicationFooter()
    {
        return memorize('threef.'.$this->locale.'.footer', 'Best browsing experience with Firefox 48 , Chrome 52 , Windows Edge and Safari 9 with resolution 1024x768. All Right Reserved © '.date('Y'));
    }

    /**
     * Save Base Config Info.
     *
     * @return void
     *
     * @author
     **/
    public function saveBaseConfigInfo($request)
    {
        return $this->saveData($request);
    }

    /**
     * Deactivate User.
     *
     * @param  $id users.id
     *
     * @return void
     **/
    protected function saveData($request)
    {
        $memory = $this->memory;
        $memory->put('threef.'.$this->locale.'.name', $request->get('name'));
        $memory->put('threef.'.$this->locale.'.description', $request->get('summary'));
        $memory->put('threef.favicon', $request->get('fav'));
        $memory->put('threef.logo', $request->get('logo'));
        $memory->put('threef.'.$this->locale.'.footer', $request->get('footer'));
        $memory->put('threef.'.$this->locale.'.contact', $request->get('contact'));
        $memory->put('threef.'.$this->locale.'.abbr', $request->get('abbr'));
    }

    /**
     * Update Logo Path.
     *
     * @return void
     *
     * @author
     **/
    public function saveFavicon($input, $path)
    {
        $memory = $this->memory;
        $memory->put('threef.favicon', $path);
    }

    /**
     * Update Logo Path.
     *
     * @return void
     *
     * @author
     **/
    public function saveLogo($input, $path)
    {
        $memory = $this->memory;
        $memory->put('threef.logo', $path);
    }

    /**
     * Return Application Name.
     *
     * @return string
     */
    public function applicationName()
    {
        return $this->defaultApplicationName();
    }

    /**
     * Return Application Summary.
     *
     * @return string
     */
    public function applicationSummary()
    {
        return $this->defaultApplicationSummary();
    }

    /**
     * Return Application Logo.
     *
     * @return string
     */
    public function applicationLogo()
    {
        return $this->defaultApplicationLogo();
    }

    /**
     * Return Application Logo.
     *
     * @return string
     */
    public function applicationFavicon()
    {
        return $this->defaultApplicationFavicon();
    }

    /**
     * Return Application Logo.
     *
     * @return string
     */
    public function applicationFooter()
    {
        return  $this->defaultApplicationFooter();
    }

    /**
     * Return Application Abbr.
     *
     * @return string
     */
    public function applicationAbbr()
    {
        return $this->defaultApplicationAbbr();
    }

    /**
     * Return Application Contact Info.
     *
     * @return string
     */
    public function applicationContact()
    {
        return $this->defaultContact();
    }
} // END class BaseConfigData
