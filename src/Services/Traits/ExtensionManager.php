<?php
namespace Threef\Entree\Services\Traits;


/**
 * Trait for extension matters
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
trait ExtensionManager 
{

	/**
	 * Get Origin Extension Namespace
	 *
	 * @return String
	 *
	 **/
	protected function guessExtensionName($origin)
	{
		$origin = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $origin);
        $fragment = explode(DIRECTORY_SEPARATOR, $origin);

        return strtolower(implode(DIRECTORY_SEPARATOR, [ $fragment[0], $fragment[1] ]));
	}	
	
} // END trait ExtensionManager 