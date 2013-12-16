<?php

namespace Dngu\WebBundle\Controller;

use Dngu\WebBundle\Controller\BaseController;

class StaticsController extends BaseController
{
    public function indexAction()
    {
        $process = $this->get('ablum_process');
        $album = $this->getAlbumRepository()->find(1);
        $process->setParameters(array('album' => $album, 'operator' => $this->getUser()));
        $process->work('create');
        return new \Symfony\Component\HttpFoundation\Response('<h1>index page</h1>');
    }
}
