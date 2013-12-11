<?php

namespace Dngu\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends SecurityController
{

    public function weiboLoginAction()
    {
        $url = $this->container->get('dngu.weibo.oauth')->getAuthorizeURL();
        return new RedirectResponse($url);
    }

    public function weiboCallbackAction()
    {
        
    }

}
