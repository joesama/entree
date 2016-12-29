<?php 
namespace Threef\Entree\Services\Upload;

use Illuminate\Http\UploadedFile;

/**
 * File Uploader Services
 *
 * @package Threef/Entree
 * @author joharijumali@gmail.com
 **/
class FileUploader 
{

	const SERVICES = 'uploads';

	protected $path;

	public function __construct(UploadedFile $file , $origin)
	{
		$this->path = $this->upload($file, $this->guessExtensionName(get_class($origin)));

	}

	/**
	 * Upload File To Specific Path
	 *
	 * @return String 
	 * @param Illuminate\Http\UploadedFile $file , String $dest
	 **/
	protected function upload($file, $dest)
	{
		$directory = strtolower('/' . self::SERVICES . '/' . $dest . '/' . date('Ymd'));
		$path = public_path() . $directory;

		$file->move($path, $file->getClientOriginalName());

		return $directory .'/'. $file->getClientOriginalName();
	}


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

	/**
	 * Return Destination Upload Path
	 *
	 * @return String
	 *  
	 **/
	public function destination()
	{
		return  $this->path;
	}

} // END class FileUploader 