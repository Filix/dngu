<?php

namespace Dngu\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return new \Symfony\Component\HttpFoundation\Response('<h1>index page</h1>');
    }
}
