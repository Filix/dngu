<?php

namespace Dngu\WebBundle\Util\Authority;

use Dngu\WebBundle\Entity\Album;

class AlbumAuthorityService extends BaseAuthorityService
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

    public function setObject(Album $object)
    {
        parent::setObject($object);
    }
}
