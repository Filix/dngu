<?php

namespace Dngu\WebBundle\Authority;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Dngu\UserBundle\Entity\User;

abstract class BaseAuthority
{

    protected $container;
    protected $object;
    protected $operator;
    private $operations = array('create', 'update', 'delete');

    public function __construct($container)
    {
        $this->container = $container;
//        $this->setObject($object);
//        $this->setOperator($operator);
        $this->configure();
    }
    
    public function configure()
    {
        
    }
    

    public function setObject($object)
    {
        $this->object = $object;
    }
    
    public function setOperator(User $user)
    {
        $this->operator = $user;
    }

    public function hasAuthority($action)
    {
        if (!in_array($action, $this->operations)) {
            throw new AccessDeniedHttpException('没有权限进行此操作，操作仅限：' . implode(',', $this->operations));
        }
        $action = 'has' . ucfirst($action) . 'Authority';
        return $this->$action();
    }

    abstract function hasCreateAuthority();

    abstract function hasUpdateAuthority();

    abstract function hasDeleteAuthority();
}
