<?php 
namespace Threef\Entree\Services\DataGrid;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Threef\Entree\Services\DataGrid\Traits\DataModeller;
use JavaScript;
use String;
use Array;

/**
 * Services to generate datagrid using vue.js
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
class VueDatagrid 
{
	use DataModeller;

    /**
     * Columns To Be Previews
     */
    protected $columns;

    /**
     * Query Builder To Be Generate
     */
    protected $builder;

    /**
     * Paginate Items
     */
    protected $items = NULL;

    /**
     * Data API Path URL
     */
    protected $api;

    /**
     * Add Button
     */
    protected $add = NULL;
    protected $addDesc = NULL;

    /**
     * Actions Button
     */
    protected $actions = FALSE;


    /**
     * Paginate Numbers
     */
    public $paginate = 20;


	/**
	 * Generate Columns For Table
	 *
	 * @param array $columns
	 *
	 **/
	public function setColumns(Array $columns)
	{
		$this->columns = $columns;
	}


	/**
	 * Generate Data Model
	 *
	 * @param Illuminate\Database\Eloquent\Builder $model
	 * @param array $columns
	 * 
	 **/
	public function setModel($model,Array $columns = [])
	{
		$this->columns = (empty($columns)) ? $this->columns  : $columns;

		$this->items = $model;


	}

	/**
	 * URI for Data API
	 *
	 * @param string $url
	 **/
	public function apiUrl(String $url)
	{
		$this->api = $url;
	}

	/**
	 * Edit action
	 *
	 * @param string $url
	 **/
	public function action(Array $actions)
	{
		$this->actions = $actions;
	}

	/**
	 * TODO : checboxes
	 *
	 * @return void
	 * @author 
	 **/
	public function checkboxes()
	{
	}

	/**
	 * Add action
	 *
	 * @param string $url
	 **/
	public function add(String $url, String $urlDesc = NULL)
	{
		$this->add = $url;
		$this->addDesc = $urlDesc;
	}

	/**
	 * Build And Generate Data grid Table
	 *
	 * @return void
	 **/
	public function build()
	{

		if(!is_null($this->items)):
			$items = $this->buildPaginators($this->items);
		endif;

		JavaScript::put([
	        'column' => $this->columns,
	        'api' => $this->api,
	        'add' => $this->add,
	        'addDesc' => $this->addDesc,
	        'actions' => $this->actions,
	       	'data' => (!is_null($this->items)) ? $items->items() : [],
	        'pagination' => [
	            'total_item' => (!is_null($this->items)) ? $items->total() : 0,
	            'per_page' => (!is_null($this->items)) ? $items->perPage() : 20,
	            'current_page' => (!is_null($this->items)) ? $items->currentPage() : 1,
	            'last_page' => (!is_null($this->items)) ? $items->lastPage() : 1,
	            'from' => (!is_null($this->items)) ? $items->firstItem() : 1,
	            'to' => (!is_null($this->items)) ? $items->lastItem() : 1
	        ]
	    ]);




	    return view('threef/entree::entree.datagrid.datagrid');
	}



} // END class VueDatagrid 