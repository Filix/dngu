<?php
namespace Dngu\UserBundle\Util;

use Dngu\UserBundle\Entity\Oauth;

abstract  class BaseSnsService
{
    abstract function getAuthorizeURL();
    
    abstract function getAccessToken($code);
    
    abstract function getUserInfo(Oauth $oauth);
}
