<?php

namespace Dngu\WebBundle\Controller;

use Dngu\WebBundle\Controller\BaseController;

class StaticsController extends BaseController
{
    public function indexAction()
    {
//        $process = $this->get('album_process');
//        $album = new \Dngu\WebBundle\Entity\Album();
//        $album->setDescription('...dddd');
//        $album->setName(\Dngu\WebBundle\Entity\Album::DIARY_ALBUM_NAME);
//        $album->setUser($this->getUser());
//        $process->setParameters(array('album' => $album, 'operator' => $this->getUser()));
//        $process->init();
//        $result = $process->work('create');
//        if($result){
//            return new \Symfony\Component\HttpFoundation\Response('<h1>success</h1>');
//        }else{
//            ldd($process->getErrors());
//        }
        return new \Symfony\Component\HttpFoundation\Response('<h1>success</h1>');
    }
}
