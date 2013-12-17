<?php

namespace Dngu\WebBundle\Controller;

use Dngu\WebBundle\Controller\BaseController;

class StaticsController extends BaseController
{
    public function indexAction()
    {
        $process = $this->get('ablum_process');
        $album = $this->getAlbumRepository()->find(1);
        if(!$album){
            $album = new \Dngu\WebBundle\Entity\Album();
            $album->setName(\Dngu\WebBundle\Entity\Album::DIARY_ALBUM_NAME);
            $album->setDescription('...');
            $album->setIsDelete(false);
            $album->setIsSystem(false);
            $album->setUser($this->getUser());
            $album->setUpdatedAt(new \DateTime);
            $dm = $this->getDoctrineManager();
            $dm->persist($album);
            $dm->flush();
        }
        $process->setParameters(array('album' => $album, 'operator' => $this->getUser()));
        $process->work('create');
        return new \Symfony\Component\HttpFoundation\Response('<h1>index page</h1>');
    }
}
