<?php 
namespace Threef\Entree\Database\Repository;

use Threef\Entree\Database\Model\Admin\BaseConfig;

/**
 * Base Config Data Processing class
 *
 * @package default
 * @author 
 **/
class BaseConfigData
{


	function __construct()
	{

		$appInfo = BaseConfig::find(1);
    	$appInfo = ($appInfo)  ? $appInfo : new BaseConfig;

		$this->model = $appInfo;
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
		return false;//'http://placehold.it/200x200';
	}

	/**
     * Default Application Logo
     *
     * @return String
     */
    protected function defaultApplicationFooter()
	{
		return 'Best browsing experience with Firefox 48 , Chrome 52 , Windows Edge and Safari 9 with resolution 1024x768. All Right Reserved © '. date('Y');
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

        \DB::beginTransaction();

        try {

        	$appInfo = $this->model;
            $appInfo->app_name = $request->get('name');
            $appInfo->app_summary = $request->get('summary');
            $appInfo->app_abbr = $request->get('abbr');
            $appInfo->exclaimation = $request->get('footer');
			$appInfo->save();

        } catch (Exception $e) {

        	\DB::rollback();
            throw $e->getMessage();
        }

        \DB::commit();


    	return $appInfo;
    }

	/**
	 * Update Logo Path
	 *
	 * @return void
	 * @author 
	 **/
	public function saveLogo($input, $path)
	{

		$appInfo = $this->model;

		\DB::beginTransaction();

		try{

			$appInfo->logo_small = $path;
			$appInfo->save();

		}catch (\Exception $e)
        {
            \DB::rollback();
            throw $e->getMessage();
        }

        \DB::commit();

	}


	/**
     * Return Application Name
     *
     * @return String
     */
    public function applicationName()
	{
		return data_get($this->model,'app_name', $this->defaultApplicationName());
	}

	/**
     * Return Application Summary
     *
     * @return String
     */
    public function applicationSummary()
	{
		return data_get($this->model,'app_summary', $this->defaultApplicationSummary());
	}

	/**
     * Return Application Logo
     *
     * @return String
     */
    public function applicationLogo()
	{
		return data_get($this->model,'logo_small', $this->defaultApplicationLogo());
	}

	/**
     * Return Application Logo
     *
     * @return String
     */
    public function applicationFooter()
	{
		return data_get($this->model,'exclaimation', $this->defaultApplicationFooter());
	}

	/**
     * Return Application Abbr
     *
     * @return String
     */
    public function applicationAbbr()
	{
		return data_get($this->model,'app_abbr');
	}


} // END class BaseConfigData 