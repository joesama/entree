<?php 
namespace Threef\Entree\Services\DataGrid\Traits;

use Carbon\Carbon;

/**
 * 
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
trait DataModeller 
{

	/**
	 * undocumented function
	 *
	 * @param void
	 * @author 
	 **/
	public function builderMixer($builder, $columns)
	{
		return $builder->paginate(100);
	}


} // END class Elequent 