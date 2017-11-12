<?php 
namespace Threef\Entree\Services\Upload;

use Illuminate\Http\UploadedFile;
use Threef\Entree\Services\Traits\ExtensionManager;
use Intervention\Image\ImageManager;

/**
 * File Uploader Services
 *
 * @package Threef/Entree
 * @author joharijumali@gmail.com
 **/
class FileUploader 
{
	use ExtensionManager;

	const SERVICES = 'uploads';

	protected $directory,$thumb,$file,$path,$origin;

	public function __construct(UploadedFile $file , $origin)
	{
		$this->image = new ImageManager(array('driver' => 'gd'));
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
		$this->getDirectory($dest);
		$this->getThumbDirectory($dest);

		$this->file = $file;
		$this->origin = $this->image->make($file);

		$file->move($this->publicPath(), $file->getClientOriginalName());

		return $this->directory.'/'. $this->file->getClientOriginalName();

	}


	/**
	 * Get Thumbnail Image
	 *
	 **/
	public function thumbnail($width = 750, $height = 150 , $pos = 'top-left')
	{
		$this->origin->fit($width , $height , function ($constraint) {
		    $constraint->aspectRatio();
		},$pos)->save($this->thumbPath($this->file->getClientOriginalName()));

		return $this->thumb.'/'. $this->file->getClientOriginalName();

	}


	/**
	 * Get Directory Public Path
	 **/
	protected function publicPath()
	{
		return public_path() . $this->directory;
	}


	/**
	 * Get Thumbnail Public Path
	 **/
	protected function thumbPath($name = NULL)
	{
		$path = public_path() . $this->thumb ;

		if(!is_dir($path)):
			mkdir($path, 0777, true);
		endif;

		return $path . $name;
	}

	/**
	 * Get File Directory
	 **/
	protected function getDirectory($dest)
	{
		$this->directory = strtolower('/' . self::SERVICES . '/' . $dest . '/' . date('Ymd'));
	}

	/**
	 * Get Thumbnail Directory
	 **/
	protected function getThumbDirectory($dest)
	{
		$this->thumb = strtolower('/' . self::SERVICES . '/' . $dest . '/' . date('Ymd') . '/thumbs/');
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