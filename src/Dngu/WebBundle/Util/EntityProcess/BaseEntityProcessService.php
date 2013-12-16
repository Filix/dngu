<?php
namespace Dngu\WebBundle\Util\EntityProcess;

use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class BaseEntityProcessService
{
    protected $container;
    
    /*
     * Symfony\Component\Validator\ValidatorInterface
     */
    protected $validator;
    
    /*
     * 
     */
    protected $authority;
    
    protected $parameters;


    public function __construct($container)
    {
        $this->container = $container;
        $this->configure();
    }
    
    public function configure()
    {
        $this->setValidation();
        $this->setAuthority();
    }
    
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }
    
    public function getParameter($key, $default = null)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }
    
    public function setValidation()
    {
        $this->setValidator($this->container->get('validator'));
    }
    
    protected abstract function setAuthority();
    
    public function preWork(){
        
    }
    
    public function work($action)
    {
        $this->preWork();
        if(!$this->authority->hasAuthority($action)){
            throw new AccessDeniedHttpException('没有权限进行此操作');
        }
    }
    
    public function setValidator(ValidatorInterface $validator){
        $this->validator = $validator;
    }
    
    
}
