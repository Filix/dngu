<?php
namespace Dngu\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OauthRepository extends EntityRepository
{
    public function getOneByAccessTokenAndType($access_token, $type)
    {
        return $this->findOneBy(array('access_token' => $access_token, 'type' => $type));
    }
}
