<?php
namespace Dngu\WebBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /*
     * 
     */
    protected function getContainer(){
        return $this->container;
    }


    /**
     * 
     */
    protected function getRouter()
    {
        return $this->getContainer()->get('router');
    }
    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->getFlash()->set($action, $value);
    }
    
    /**
     * @return FlashBagInterface
     */
    protected function getFlash()
    {
        return $this->getContainer()->get('session')->getFlashBag();
    }
}
