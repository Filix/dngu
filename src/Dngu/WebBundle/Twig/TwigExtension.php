<?php

namespace Dngu\WebBundle\Twig;

use Dngu\UserBundle\Entity\User;

class TwigExtension extends \Twig_Extension{
    
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mailhost', array($this, 'mailhostFilter')),
        );
    }
    
    public function getFunctions(){
        return array(
            'user_home' => new \Twig_Function_Method($this, 'getUserHomeUrl'),
            'user_albums' => new \Twig_Function_Method($this, 'getUserAlbumsUrl'),
        );
    }

    public function mailhostFilter($email)
    {
        $domain = substr(strstr($email, '@'), 1);
        return $domain != 'gmail.com' ? "http://mail." . $domain : 'http://mail.google.com/mail';
    }
    
    public function getName() 
    {
        return 'web_twig_extension';
    }
    
    public function getUserHomeUrl(User $user, $absolute = false){
        return $this->container->get('dngu.user.router')->getHomeUrl($user, $absolute);
    }
    
    public function getUserAlbumsUrl(User $user, $page = 1, $absolute = false){
        return $this->container->get('router')->generate('album_list', array('uid' => $user->getSlugOrId(), 'page' => $page), $absolute);
    }

}
