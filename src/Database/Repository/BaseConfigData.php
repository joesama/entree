<?php 
namespace Threef\Entree\Database\Repository;

use Orchestra\Contracts\Memory\Provider;

/**
 * Base Config Data Processing class
 *
 * @package default
 * @author 
 **/
class BaseConfigData
{


	function __construct(Provider $memory)
	{
        $this->memory = $memory;
	}


    /**
     * Default Application Name
     *
     * @return String
     */
    protected function defaultApplicationAbbr()
    {
        return memorize('abbr');
    }

	/**
     * Default Application Name
     *
     * @return String
     */
    protected function defaultApplicationName()
	{
		return memorize('site.name');
	}

	/**
     * Default Application Summary
     *
     * @return String
     */
    protected function defaultApplicationSummary()
	{
		return memorize('site.description');
	}

    /**
     * Default Application Logo
     *
     * @return String
     */
    protected function defaultApplicationLogo()
    {
        return memorize('logo.apps');
    }

	/**
     * Default Application Logo
     *
     * @return String
     */
    protected function defaultApplicationFavicon()
	{
		return memorize('logo.favicon');
	}

	/**
     * Default Application Logo
     *
     * @return String
     */
    protected function defaultApplicationFooter()
	{
		return memorize('footer','Best browsing experience with Firefox 48 , Chrome 52 , Windows Edge and Safari 9 with resolution 1024x768. All Right Reserved © '. date('Y'));
	}


	/**
	 * Save Base Config Info
	 *
	 * @return void
	 * @author 
	 **/
	public function saveBaseConfigInfo($request)
	{
		return $this->saveData($request);
	}

    /**
     * Deactivate User 
     *
     * @return void
     * @param  $id users.id
     **/
    protected function saveData($request)
    {
        $memory = $this->memory;
        $memory->put('site.name', $request->get('name'));
        $memory->put('site.description', $request->get('summary'));
        $memory->put('logo.favicon', $request->get('fav'));
        $memory->put('logo.apps', $request->get('logo'));
        $memory->put('footer', $request->get('footer'));
        $memory->put('abbr', $request->get('abbr'));
    }

    /**
     * Update Logo Path
     *
     * @return void
     * @author 
     **/
    public function saveFavicon($input, $path)
    {

        $memory = $this->memory;
        $memory->put('logo.favicon', $path);

    }

	/**
	 * Update Logo Path
	 *
	 * @return void
	 * @author 
	 **/
	public function saveLogo($input, $path)
	{

		$memory = $this->memory;
        $memory->put('logo.apps', $path);

	}


	/**
     * Return Application Name
     *
     * @return String
     */
    public function applicationName()
	{
		return $this->defaultApplicationName();
	}

	/**
     * Return Application Summary
     *
     * @return String
     */
    public function applicationSummary()
	{
		return $this->defaultApplicationSummary();
	}

    /**
     * Return Application Logo
     *
     * @return String
     */
    public function applicationLogo()
    {
        return $this->defaultApplicationLogo();
    }

	/**
     * Return Application Logo
     *
     * @return String
     */
    public function applicationFavicon()
	{
		return $this->defaultApplicationFavicon();
	}

	/**
     * Return Application Logo
     *
     * @return String
     */
    public function applicationFooter()
	{
		return  $this->defaultApplicationFooter();
	}

	/**
     * Return Application Abbr
     *
     * @return String
     */
    public function applicationAbbr()
	{
		return $this->defaultApplicationAbbr();
	}


} // END class BaseConfigData 