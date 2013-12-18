<?php

namespace Dngu\WebBundle\Validator;

class EntityValidator extends BaseValidator
{

    public function validate()
    {
        $errors = $this->getEntityValidator()->validate($this->getObject());
        if (count($errors) > 0) {
            $e = array();
            foreach($errors as $error){
                $e[] = $error->getMessage();
            }
            $this->setErrors($e);
            return false;
        }
        return true;
    }

}
