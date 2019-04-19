<?php

namespace Joesama\Entree\Services\Upload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Joesama\Entree\Services\Traits\ExtensionManager;

/**
 * File Uploader Services.
 *
 * @author joharijumali@gmail.com
 **/
class FileUploader
{
    use ExtensionManager;

    const SERVICES = 'uploads';

    protected $directory;
    protected $storage;
    protected $thumb;
    protected $file;
    protected $path;
    protected $origin;
    protected $filename;

    public function __construct(UploadedFile $file, $origin, $public = true)
    {
        $this->storage = ($public) ? Storage::disk('public') : Storage::disk('local');      

        $this->path = $this->upload($file, $this->guessExtensionName(get_class($origin)));

        if ($public) {
            $this->path = 'storage' . $this->path;
        }
    }

    /**
     * Upload File To Specific Path.
     * 
     * @param  UploadedFile $file   Uploaded File
     * @param  string       $dest   Upload destination
     * @return string
     */
    protected function upload(UploadedFile $file, string $dest): string
    {
        $this->getDirectory($dest);
        
        $this->getThumbDirectory($dest);

        $this->file = $file;

        $orderedId = Str::uuid();

        $this->filename = Str::studly(Str::slug($orderedId,'_')).'.'.$file->getClientOriginalExtension();

        $this->storage->putFileAs($this->directory, $file, $this->filename, 'public');

        return $this->directory.'/'.$this->filename;
    }

    /**
     * Get Thumbnail Image.
     *
     **/
    public function thumbnail($width = 750, $height = 150, $pos = 'top-left')
    {
        $image = new ImageManager();

        $origin = $image->make($this->file);

        $thumbName = $width.$height.$this->filename;

        $origin->fit($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        }, $pos)->save($this->thumbPath($thumbName));

        return $this->thumb.'/'.$thumbName;
    }

    /**
     * Get Directory Public Path.
     **/
    protected function publicPath()
    {
        return $this->directory;
    }

    /**
     * Get Thumbnail Public Path.
     **/
    protected function thumbPath($name = null)
    {
        return $this->thumb.$name;
    }

    /**
     * Get File Directory.
     **/
    protected function getDirectory($dest)
    {
        $this->directory = strtolower('/'.self::SERVICES.'/'.$dest.'/'.date('Ymd'));

        if(!is_dir($this->directory)){
            $this->storage->makeDirectory($this->directory);
        }

    }

    /**
     * Get Thumbnail Directory.
     **/
    protected function getThumbDirectory($dest)
    {
        $this->thumb = strtolower('/'.self::SERVICES.'/'.$dest.'/'.date('Ymd').'/thumbs/');

        if(!is_dir($this->thumb)){
            $this->storage->makeDirectory($this->thumb);
        }

    }

    /**
     * Return Destination Upload Path.
     *
     * @return string
     *
     **/
    public function destination()
    {
        return  $this->path;
    }
} // END class FileUploader
