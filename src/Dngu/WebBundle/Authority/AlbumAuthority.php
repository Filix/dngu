<?php

namespace Dngu\WebBundle\Authority;

use Dngu\WebBundle\Entity\Album;

class AlbumAuthority extends BaseAuthority
{
    public function hasCreateAuthority()
    {
        return true;
    }

    public function hasDeleteAuthority()
    {
        return false;
    }

    public function hasUpdateAuthority()
    {
        return true;
    }

    public function setObject($object)
    {
        if(!$object instanceof Album){
            throw new \Exception('You must give a Album Object');
        }
        parent::setObject($object);
    }
}
