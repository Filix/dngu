<?php

namespace Dngu\WebBundle\Util\CURD;

abstract class BaseCURDService
{

    public $parameters = array();
    public $error;
    public $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

//    public function setParameters(array $parameters)
//    {
//        $this->parameters = $parameters;
//    }
//
//    public function getParameters()
//    {
//        return $this->parameters;
//    }
//
//    public function getParameter($key, $default = null)
//    {
//        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
//    }

//    public function getError()
//    {
//        return $this->error;
//    }
//
//    public function setError($error)
//    {
//        $this->error = $error;
//    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getDoctrineManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

    public function getRepository($respository)
    {
        return $this->getContainer()->get('doctrine')->getRepository($respository);
    }

    public function create($object)
    {
        $this->preCreate($object);
        $this->getDoctrineManager()->persist($object);
        $this->postCreate($object);
        $this->getDoctrineManager()->flush();
    }

    public function preCreate($object)
    {
        
    }

    public function postCreate($object)
    {
        
    }

    public function update($object)
    {
        $this->preUpdate($object);
        $this->getDoctrineManager()->persist($object);
        $this->postUpdate($object);
        $this->getDoctrineManager()->flush();
    }

    public function preUpdate($object)
    {
        
    }

    public function postUpdate($object)
    {
        
    }

    public function delete($object)
    {
        $this->preDelete($object);
        $object->delete();
        $this->getDoctrineManager()->persist($object);
        $this->postDelete($object);
        $this->getDoctrineManager()->flush();
    }

    public function preDelete($object)
    {
        
    }

    public function postDelete($object)
    {
        
    }
}
