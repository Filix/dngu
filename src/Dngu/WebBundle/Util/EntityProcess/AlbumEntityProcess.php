<?php
namespace Dngu\WebBundle\Util\EntityProcess;

use Dngu\WebBundle\Util\Authority\AlbumAuthorityService;

class AlbumEntityProcess extends BaseEntityProcessService
{
    protected function setAuthority()
    {
        $this->authority = new AlbumAuthorityService();
    }

}
