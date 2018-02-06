<?php 
namespace Threef\Entree\Services\Pdf;

use Threef\Entree\Services\Traits\ExtensionManager;
use Knp\Snappy\Pdf;

/**
 * Service for pdf maker class
 *
 * Pre-requisite :
 * 1. Install wkhtmltopdf binary
 * 2. Install xvfb for headless execution
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
class PdfMaker 
{
	use ExtensionManager;

	public function __construct($view)
	{
		$this->view = $view;
		$this->pdf = new Pdf($this->getBinary());
	}


	/**
	 * Generate PDF Then output the pdf
	 *
	 **/
	public function generatePdf($name = 'PdfMaker', $attributes = [])
	{
		$path = $this->getDirectory() . $name .'.pdf';

		$this->pdf->setOption('header-font-size',12);
		$this->pdf->setOption('header-font-name','Arial');
		$this->pdf->setOption('page-size', 'Letter');
		$this->pdf->setOption('margin-right', 10);
		$this->pdf->setOption('margin-left', 10);
		$this->pdf->setOption('user-style-sheet', public_path().'/packages/threef/entree/css/bootstrap.css');

		foreach($attributes as $key => $value){
			$this->pdf->setOption($key, $value);
		}

		$this->pdf->generateFromHtml($this->view, $path);

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . str_replace('/','_',basename($path)));   
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");            
		header("Content-Length: " . filesize($path));
		flush(); // this doesn't really matter.
		$fp = fopen($path, "r");
		while (!feof($fp))
		{
		    echo fread($fp, 65536);
		    flush(); // this is essential for large downloads
		} 
		fclose($fp); 

		if(is_file($path)):
            unlink($path);
            // rmdir(realpath($this->getDirectory()));
        endif;

	}


	/**
	 * Set File Directory
	 *
	 **/
	protected function getDirectory()
	{

		$dir = strtolower('/' . $this->guessExtensionName(get_called_class()) . '/pdf/' . date('Ymd') . '/');

		$path = storage_path() . $dir ;

		if(!is_dir($path)):
			mkdir($path, 0777, true);
		endif;

		return $path;
	}


	/**
	 * Retrieve Binary 
	 *
	 **/
	protected function getBinary()
	{
		if(substr_count(strtolower(php_uname()),'ubuntu') > 0):
			return 'xvfb-run -a /usr/bin/wkhtmltopdf';
		else:
			return '/usr/bin/wkhtmltopdf';
		endif;
	}

} // END class PdfMaker 