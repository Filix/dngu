<?php

namespace Dngu\WebBundle\Util\EntityProcess;

use Dngu\WebBundle\Validator;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class BaseEntityProcessService
{

    protected $container;
    
    /*
     * Doctrine Manager
     */
    protected $dm;

    /*
     * Dngu\WebBundle\Validator
     */
    protected $validator;

    /*
     * Dngu\WebBundle\Authority
     */
    protected $authority;
    protected $parameters;
    
    protected $errors = array();

    public function __construct($container)
    {
        $this->container = $container;
        $this->dm = $this->getContainer()->get('doctrine')->getManager();
        $this->setValidator();
        $this->setAuthority();
    }

    public function init()
    {
        
    }

    public function getContainer()
    {
        return $this->container;
    }
    
    public function getDoctrineManager(){
        return $this->dm;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameter($key, $default = null)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }

    abstract function setValidator();

    protected abstract function setAuthority();

    public function work($action)
    {
        $this->init();
        if (!$this->validator->validate()) {
            $this->setErrors($this->validator->getErrors());
            return false;
        }
        if (!$this->authority->hasAuthority($action)) {
            $this->addError('没有权限进行此操作');
            return false;
        }
        $pre_action = 'pre' . ucfirst($action);
        if (method_exists($this, $pre_action)) {
            if(!$this->$pre_action()){
                return false;
            }
        }
        $do_action = 'do' . ucfirst($action);
        if (!method_exists($this, $do_action)) {
            throw new \Exception('你必须定义一个' . $do_action . '()方法');
        }
        if(!$this->$do_action()){
            return false;
        }
        $post_action = 'post' . ucfirst($action);
        if (method_exists($this, $post_action)) {
            if(!$this->$post_action()){
                return false;
            }
        }
        return true;
    }
    
    public function getErrors(){
        return $this->errors;
    }
    
    public function setErrors(array $errors){
        $this->errors = $errors;
    }
    
    public function addError($error){
        $this->errors[] = $error;
    }
    
    public function shiftError(){
        return isset($this->errors[0]) ? $this->errors[0] : '';
    }
}
