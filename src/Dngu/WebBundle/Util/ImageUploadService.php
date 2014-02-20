<?php
namespace Dngu\WebBundle\Util;

use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Description of ImageUploadService
 *
 * @author Filix
 */
class ImageUploadService
{
    const MIME_TYPES = 'image/gif|image/jpeg|image/png';
    
    const MAX_SIZE = 5242880; //5MB
    
    const DEPTH = 4; //子目录深度
    
    protected $error;
    
    protected $absolute_path;
    
    protected $relative_path;


    protected $name;
    
    protected $uploads_dir;
    
    

    public function __construct($appkernel_root_dir)
    {
        $this->uploads_dir = $appkernel_root_dir . '/../web/uploads/images/';
    }

    public function upload(UploadedFile $file, $parent_dir, $name = null){
        if(!$file->isValid()){
            $this->setError($file->getErrorMessage());
            return false;
        }
        if($file->getSize() > self::MAX_SIZE){
            $this->setError('图片最大支持5M');
            return false;
        }
        $mime = strtolower($file->getMimeType());
        
        if(strpos(self::MIME_TYPES, $mime) === false){
            $this->setError('只支持gif，jpg和png格式');
            return false;
        }
        
        $this->name = $name ? : md5($file->getBasename().uniqid()).date('YmdHis') . '.' . $this->getExtension($mime);
        $sub_dir = $this->name[0] . '/' . $this->name[1] . '/' . $this->name[2] . '/' .$this->name[3] . '/';
        $this->relative_path = 'uploads/images/' . trim($parent_dir, '/') . '/' . $sub_dir;
        $this->absolute_path = $this->uploads_dir . trim($parent_dir, '/') . '/' . $sub_dir;
        try{
            $file->move($this->absolute_path, $this->name);
        } catch (\Exception $ex) {
            $this->setError($ex->getMessage());
            return false;
        }
        return true;
    }
    
    public function getAbsolutePath(){
        return $this->absolute_path;
    }
    
    public function getRelativePath(){
        return $this->relative_path;
    }
    
    public function getName(){
        return $this->name;
    }
    
    protected function getExtension($mime){
        switch ($mime){
            case 'image/gif':
                $ex = 'gif';
                break;
            case 'image/png':
                $ex = 'png';
                break;
            default :
                $ex = 'jpg';
        }
        return $ex;
    }
    
    protected function setError($error){
        $this->error = $error;
    }
    
    public function getError(){
        return $this->error;
    }
}
