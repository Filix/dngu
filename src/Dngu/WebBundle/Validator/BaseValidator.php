<?php

namespace Dngu\WebBundle\Validator;

abstract class BaseValidator
{

    protected $container;
    protected $object;
    protected $entity_validator;
    protected $errors = array();
    protected $parameters;

    public function __construct($container)
    {
        $this->container = $container;
        $this->entity_validator = $this->container->get('validator');
        $this->init();
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getEntityValidator()
    {
        return $this->entity_validator;
    }

    protected function init()
    {
        
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameter($key, $default = null)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }

    abstract function validate();

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

}
