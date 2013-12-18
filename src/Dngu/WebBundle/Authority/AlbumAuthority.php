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
        return $this->getObject()->getUser()->getId() == $this->getOperator()->getId() ? true : false;
    }

    public function hasUpdateAuthority()
    {
        return $this->getObject()->getUser()->getId() == $this->getOperator()->getId() ? true : false;
    }

    public function setObject($object)
    {
        if(!$object instanceof Album){
            throw new \Exception('You must give a Album Object');
        }
        parent::setObject($object);
    }
}
