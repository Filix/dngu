<?php

namespace Dngu\WebBundle\Twig;

class TwigExtension extends \Twig_Extension{
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mailhost', array($this, 'mailhostFilter')),
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

}
