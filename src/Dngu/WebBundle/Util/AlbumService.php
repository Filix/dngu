<?php
namespace Dngu\WebBundle\Util;

use Dngu\WebBundle\Entity\Album;

class AlbumService extends CURDService
{
    protected function doCreate()
    {
//        $name = $this->getParameter('name');
//        $description = $this->getParameter('description');
//        $creator_id = $this->getParameter('user_id');
//        $is_system = $this->getParameter('is_system', false);
//        if(!$name){
//            $this->setError("相册名太长");
//            return false;
//        }
//        if(!$creator_id){
//            $this->setError("创建者不能为空");
//            return false;
//        }
//        if(!$creator = $this->getRepository('DnguUserBundle:User')->find($creator_id)){
//            $this->setError("创建者不能为空");
//            return false;
//        }
//        $album = new Album();
//        $album->setName($name);
//        $album->setIsSystem($is_system);
//        $album->setDescription($description);
//        $album->setUser($creator);
        
    }

    protected function doDelete()
    {
        
    }

    protected function doUpdate()
    {
        
    }

}
