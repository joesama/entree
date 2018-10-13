<?php

namespace Joesama\Entree\Http\Controller\Admin;

use Illuminate\Http\Request;
use Joesama\Entree\Http\Controller\Controller;
use Joesama\Entree\Http\Processor\Admin\BasicSetupProcessor;

class BasicSetup extends Controller
{
    public function __construct(BasicSetupProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displaying landing page.
     *
     * @return mixed
     **/
    public function appConfig()
    {
        return  $this->processor->processAppConfig($this);
    }

    /**
     * Landing Page View.
     *
     * @return view
     **/
    public function appConfigView($data)
    {
        return view('joesama/entree::entree.admin.appconfig', $data);
    }

    /**
     * Save Application Configuration Info.
     *
     * @return void
     *
     * @author
     **/
    public function saveAppConfig(Request $request)
    {
        return $this->processor->processConfigData($request);
    }

    /**
     * Upload Application Logo.
     *
     * @return void
     *
     * @author
     **/
    public function saveLogo(Request $request)
    {
        return $this->processor->uploadLogo($request);
    }

    /**
     * Upload Fav Icon.
     *
     * @return void
     *
     * @author
     **/
    public function saveFavicon(Request $request)
    {
        return $this->processor->uploadFavIcon($request);
    }
}
