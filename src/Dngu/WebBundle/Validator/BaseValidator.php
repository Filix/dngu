<?php
namespace Dngu\WebBundle\Validator;

abstract class BaseValidator
{
    protected $container;
    
    protected $errors = array();
    
    protected $parameters;
    
    public function __construct($container)
    {
        $this->container = $container;
        $this->init();
    }
    
    protected function init(){
        
    }
    
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameter($key, $default = null)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }
    
    abstract function validator();
    
    
    
}
