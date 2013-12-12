<?php
namespace Dngu\WebBundle\Util\EntityProcess;

abstract class BaseEntityProcessService
{
    protected $container;
    
    protected $validator;
    
    protected $authority;
    
    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = $this->container->get('validator');
        $this->setAuthority();
    }
    
    protected abstract function setAuthority();
    
    public function work($object, $action){
        $this->authority->setObject($object);
        if(!$this->authority->hasAuthority($action)){
            throw new AccessDeniedHttpException($this->authority->getError());
        }
    }
    
    
}
