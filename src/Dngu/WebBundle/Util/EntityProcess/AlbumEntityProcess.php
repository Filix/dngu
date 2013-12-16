<?php
namespace Dngu\WebBundle\Util\EntityProcess;

use Dngu\WebBundle\Authority\AlbumAuthority;
use Dngu\WebBundle\Util\EntityProcess\BaseEntityProcessService;

class AlbumEntityProcess extends BaseEntityProcessService
{
    protected function setAuthority()
    {
        $this->authority = new AlbumAuthority($this->container);
    }
    
    public function preWork()
    {
        $this->authority->setObject($this->getParameter('album'));
        $this->authority->setOperator($this->getParameter('operator'));
    }

    
}
