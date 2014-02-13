<?php

namespace Dngu\WebBundle\Controller;

use Dngu\WebBundle\Controller\BaseController;

class UserController extends BaseController
{

    public function homepageAction($uid)
    {
        if ($this->container->get('security.context')->isGranted('ROLE_USER')) {
            ldd($this->getUser());
        } else {
            ldd('not login');
        }
    }

}
