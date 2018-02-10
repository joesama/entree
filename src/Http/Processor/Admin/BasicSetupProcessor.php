<?php 
namespace Threef\Entree\Http\Processor\Admin;

use Threef\Entree\Database\Repository\BaseConfigData;
use Threef\Entree\Services\Upload\FileUploader;

/**
 * BasicSetupProcessor class
 *
 * @package threef/entree
 * @author joesama
 **/
class BasicSetupProcessor
{

    public function __construct(BaseConfigData $data) {
        
        $this->data = $data;
    }

	/**
	 * Process Base Setup Data
	 *
	 * @return Illuminate\Support\Collection
	 * @author 
	 **/
	public function processAppConfig($controller)
	{

		$data = collect([
			'name' => $this->data->applicationName(),
			'summary' => $this->data->applicationSummary(),
			'footer' => $this->data->applicationFooter(),
			'logo' => $this->data->applicationLogo(),
			'favicon' => $this->data->applicationFavicon(),
            'contact' => $this->data->applicationContact(),
			'abbr' => $this->data->applicationAbbr(),
		]);


		return $controller->appConfigView(compact('data'));
	}


	/**
	 * Process Application Config Data
	 *
	 * @return void
	 * @author 
	 **/
	public function processConfigData($request)
	{

		$this->data->saveBaseConfigInfo($request);

		return redirect_with_message(
            handles('threef/entree::base'),
            trans('threef/entree::respond.data.success', [ 'form' => trans('threef/entree::title.config.base') ]),
            'success');

	}


    /**
     * Upload Photo & Update Resources Photo Path 
     *
     * @return void
     * @author 
     **/
    public function uploadLogo($request)
    {
        if ($request->file('logo')->isValid()) :

            $file = new FileUploader($request->file('logo'), $this);

            $this->data->saveLogo($request,$file->destination());

            return response()->json(['path' => $file->destination()]);

        endif;
    }

    /**
     * Upload Photo & Update Resources Photo Path 
     *
     * @return void
     * @author 
     **/
    public function uploadFavIcon($request)
    {
        if ($request->file('fav')->isValid()) :

            $file = new FileUploader($request->file('fav'), $this);

            $this->data->saveFavicon($request,$file->destination());

            return response()->json(['path' => $file->destination()]);

        endif;
    }

} // END class BasicSetupProcessor 

