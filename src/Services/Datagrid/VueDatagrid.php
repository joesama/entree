<?php 
namespace Threef\Entree\Services\DataGrid;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Threef\Entree\Services\DataGrid\Traits\DataModeller;
use JavaScript;

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
    protected $items;

    /**
     * Data API Path URL
     */
    protected $api;

    /**
     * Add Button
     */
    protected $add = FALSE;

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
	public function setColumns(array $columns)
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
	public function setModel($model,array $columns = [])
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
	public function add(String $url)
	{
		$this->add = $url;
	}

	/**
	 * Build And Generate Data grid Table
	 *
	 * @return void
	 **/
	public function build()
	{
		$items = $this->buildPaginators($this->items);

		JavaScript::put([
	        'column' => $this->columns,
	        'data' => $items->items(),
	        'api' => $this->api,
	        'add' => $this->add,
	        'actions' => $this->actions,
	        'pagination' => [
	            'total' => $items->total(),
	            'per_page' => $items->perPage(),
	            'current_page' => $items->currentPage(),
	            'last_page' => $items->lastPage(),
	            'from' => $items->firstItem(),
	            'to' => $items->lastItem()
	        ]
	    ]);

	    return view('threef/entree::entree.datagrid.datagrid');
	}



} // END class VueDatagrid 