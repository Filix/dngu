<?php

namespace Dngu\WebBundle\Util\EntityProcess;

use Dngu\WebBundle\Validator;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class BaseEntityProcessService
{

    protected $container;

    /*
     * Dngu\WebBundle\Validator
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
        $this->setValidator();
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
    
    abstract function setValidator();

    protected abstract function setAuthority();

    public function work($action)
    {
        if(!$this->validator->validator()){
            
        }
        if (!$this->authority->hasAuthority($action)) {
            throw new AccessDeniedHttpException('没有权限进行此操作');
        }
        $pre_action = 'pre' . ucfirst($action) . 'Work';
        if(method_exists($this, $pre_action)){
            $this->$pre_action();
        }
        $do_action = 'do' . ucfirst($action) . 'Work';
        if(!method_exists($this, $do_action)){
            throw new \Exception('你必须定义一个' . $do_action.'()方法');
        }
        $this->$do_action();
        $post_action = 'post' . ucfirst($action) . 'Work';
        if(method_exists($this, $post_action)){
            $this->$post_action();
        }
    }
}
