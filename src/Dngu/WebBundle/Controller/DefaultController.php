<?php

namespace Dngu\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DnguWebBundle:Default:index.html.twig', array('name' => $name));
    }
}
