<?php namespace Threef\Entree\DataGrid;

use Illuminate\Http\Request;
use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\UrlGenerator;

use yajra\Datatables\Html\Builder;
use yajra\Datatables\Datatables;

/**
 * Datatables Wrapper
 *
 * @package default
 * @author 
 **/
class Grid
{
	protected $htmlBuilder;

	function __construct(        
		Repository $config,
        Factory $view,
        UrlGenerator $url) {

		$this->config = $config;
		$this->view = $view;
		$this->html = new HtmlBuilder;
		$this->url = $url;
		$token = csrf_token();
		$this->form = new FormBuilder($this->html,$this->url, $token);

		$this->htmlBuilder = new Builder($this->config , $this->view, $this->html, $this->url, $this->form );

	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function attach(Request $request, $model)
	{

		$html = $this->htmlBuilder
		    ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
		    ->addColumn(['data' => 'fullname', 'name' => 'fullname', 'title' => 'Name'])
		    ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
		    ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'])
		    ->addColumn(['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At'])
		    ->ajax(handles('entree::userdata'));

	    return $html;
	}
} // END class Grid 