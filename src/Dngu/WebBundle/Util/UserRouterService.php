<?php
namespace Dngu\WebBundle\Util;

use Dngu\UserBundle\Entity\User;

class UserRouterService 
{
    protected $router;
    
    public function __construct($router)
    {
        $this->router = $router;
    }
    
    public function getHomeUrl(User $user, $absolute = false){
        return $this->router->generate('homepage', array('uid' => $user->getId()), $absolute);
    }
}
