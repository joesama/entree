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
	 * undocumented function
	 *
	 * @param string $url
	 **/
	public function apiUrl(String $url)
	{
		$this->api = $url;
	}

	/**
	 * Build And Generate Data grid Table
	 *
	 * @return void
	 **/
	public function build()
	{

		JavaScript::put([
	        'column' => $this->columns,
	        'data' => $this->items->items(),
	        'api' => $this->api,
	        'pagination' => [
	            'total' => $this->items->total(),
	            'per_page' => $this->items->perPage(),
	            'current_page' => $this->items->currentPage(),
	            'last_page' => $this->items->lastPage(),
	            'from' => $this->items->firstItem(),
	            'to' => $this->items->lastItem()
	        ]
	    ]);

	    return view('threef/entree::entree.datagrid.datagrid');
	}



} // END class VueDatagrid 