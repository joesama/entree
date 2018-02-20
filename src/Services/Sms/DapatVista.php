<?php 
namespace Threef\Entree\Services\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class For Dapat Vista SMS Api
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
class DapatVista
{

    /**
     * Base URI for Putra Geo Info
     *
     * @var string
     */ 
	protected $base_uri = 'http://mtsms.15888.my/sendsms.aspx';

    /**
     * Putra Geo Info
     *
     * @var string
     */ 
	protected $token = '';

    /**
     * Response From Putra Geo Info
     *
     * @var string
     */ 
	protected $response = [];

    /**
     * Response Content From Putra Geo Info
     *
     * @var string
     */ 
	protected $content = [];


	// Init constructor
	public function __construct()
	{
		$this->client = new Client(['base_uri' => $this->base_uri]);
	}

	/**
	 * Manage Query Parameter
	 *
	 * @return Array
	 * @author johari@3fresources.com
	 **/
	protected function sanitizeParameter($params = [])
	{

		$parameters = collect([]);

		foreach($params as $key => $param):
			$parameters->put($key,urlencode($param));
		endforeach;
		
		return '?'.http_build_query($parameters->toArray());

	}

	/**
	 * Sent Request To Dapat Vista SMS
	 *
	 * @return JSON 
	 * @author johari@3fresources.com
	 * @param String $path Path of request, String $mode Mode of request, Array $param Query Parameter
	 **/
	public function request($params = [],$mode = 'GET')
	{
		
		try{

			$this->response = $this->client->request($mode, $this->sanitizeParameter($params));

			if($this->response->getStatusCode() != 200):
				return  $this->response->getStatusCode();
			else:
				return collect([$this->response->getStatusCode() => json_decode($this->response->getBody()->getContents()) ])->toJson();
			endif;

		}
		catch (RequestException $e)
        {
            return response()->json([
				'description' => $e->getMessage(),
				'status' => 404
				]);
        }

	}

	/**
	 * Return Status For Request
	 *
	 * @return String
	 * @author 
	 **/
	protected function status()
	{
		return $this->response->getStatusCode();
	}


} // END class DapatVista