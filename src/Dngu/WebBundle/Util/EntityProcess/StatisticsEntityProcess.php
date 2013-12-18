<?php
namespace Dngu\WebBundle\Util\EntityProcess;

use Dngu\WebBundle\Authority\StatisticsAuthority;

class StatisticsEntityProcess extends BaseEntityProcessService
{
    protected function setAuthority()
    {
        $this->authority = new StatisticsAuthority($this->container);
    }

    public function setValidator()
    {
        $this->validator = $this->getContainer()->get('entity_validator');
    }
    
     public function init()
    {
        $this->authority->setObject($this->getParameter('statistics'));
        $this->authority->setOperator($this->getParameter('operator'));
        $this->validator->setObject($this->getParameter('statistics'));
    }
    
    public function doCreate(){
        $this->getDoctrineManager()->persist($this->getParameter('statistics'));
        $this->getDoctrineManager()->flush();
        return true;
    }
    
    public function doUpdate(){
        $this->getDoctrineManager()->persist($this->getParameter('statistics'));
        $this->getDoctrineManager()->flush();
        return true;
    }

}
