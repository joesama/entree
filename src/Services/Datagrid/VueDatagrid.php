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
    protected $simple = FALSE;

    /**
     * Search Display
     */
    protected $search = TRUE;

    /**
     * Data Filtering
     */
    protected $autoFilter = FALSE;


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
	public function setModel($model, $columns = [])
	{
		$this->columns = (empty($columns)) ? $this->columns  : $columns;

		$this->items = $model;


	}

	/**
	 * URI for Data API
	 *
	 * @param string $url
	 **/
	public function apiUrl($url)
	{
		$this->api = $url;
	}

	/**
	 * Edit action
	 *
	 * @param array $actions
	 **/
	public function action($actions, $simple = FALSE)
	{
		$this->actions = $actions;
		$this->simple = $simple;
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
	 * Display Search Function
	 *
	 * @return void
	 * @author 
	 **/
	public function showSearch($okay = TRUE)
	{
		$this->search = $okay;
	}

	/**
	 * Auto Filter Function
	 *
	 * @return void
	 * @author 
	 **/
	public function autoFilter($okay = TRUE)
	{
		$this->autoFilter = $okay;
	}

	/**
	 * Add action
	 *
	 * @param string $url
	 **/
	public function add($url,$urlDesc = NULL)
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
			'swalert' => [
				'confirm' => [
					'title' => trans('threef/entree::datagrid.delete.confirm.title'),
					'text' => trans('threef/entree::datagrid.delete.confirm.text'),
					'proceed' => trans('threef/entree::datagrid.delete.confirm.proceed')
				],
				'cancel' => [
					'title' => trans('threef/entree::datagrid.delete.cancel.title'),
					'text' => trans('threef/entree::datagrid.delete.cancel.text')
				]
			],
			'autoFilter' => $this->autoFilter,
			'search' => $this->search,
	        'column' => $this->columns,
	        'api' => $this->api,
	        'add' => $this->add,
	        'addDesc' => $this->addDesc,
	        'actions' => $this->actions,
	        'simple' => $this->simple,
	       	'data' => (!is_null($this->items)) ? $items->items() : [],
	        'pagination' => [
	            'total' => (!is_null($this->items)) ? $items->total() : 0,
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