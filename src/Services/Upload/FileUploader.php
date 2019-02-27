<?php

namespace Joesama\Entree\Services\Upload;

use Illuminate\Http\UploadedFile;
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
    protected $thumb;
    protected $file;
    protected $path;
    protected $origin;
    protected $filename;

    public function __construct(UploadedFile $file, $origin)
    {
        $this->path = $this->upload($file, $this->guessExtensionName(get_class($origin)));
    }

    /**
     * Upload File To Specific Path.
     *
     * @param Illuminate\Http\UploadedFile $file , String $dest
     *
     * @return string
     **/
    protected function upload($file, $dest)
    {
        $this->getDirectory($dest);
        
        $this->getThumbDirectory($dest);

        $this->file = $file;

        $orderedId = Str::uuid();

        $this->filename = Str::studly(Str::slug($orderedId,'_')).'.'.$file->getClientOriginalExtension();

        $file->move($this->publicPath(), $this->filename);

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
        return public_path().$this->directory;
    }

    /**
     * Get Thumbnail Public Path.
     **/
    protected function thumbPath($name = null)
    {
        $path = public_path().$this->thumb;

        if (!is_dir($path)):
            mkdir($path, 0777, true);
        endif;

        return $path.$name;
    }

    /**
     * Get File Directory.
     **/
    protected function getDirectory($dest)
    {
        $this->directory = strtolower('/'.self::SERVICES.'/'.$dest.'/'.date('Ymd'));
    }

    /**
     * Get Thumbnail Directory.
     **/
    protected function getThumbDirectory($dest)
    {
        $this->thumb = strtolower('/'.self::SERVICES.'/'.$dest.'/'.date('Ymd').'/thumbs/');
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
