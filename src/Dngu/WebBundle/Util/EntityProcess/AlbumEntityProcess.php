<?php

namespace Dngu\WebBundle\Util\EntityProcess;

use Dngu\WebBundle\Authority\AlbumAuthority;
use Dngu\WebBundle\Util\EntityProcess\BaseEntityProcessService;
use Dngu\WebBundle\Validator\EntityValidator;
use Dngu\WebBundle\Entity\Statistics;

class AlbumEntityProcess extends BaseEntityProcessService
{

    protected function setAuthority()
    {
        $this->authority = new AlbumAuthority($this->container);
    }

    public function setValidator()
    {
        $this->validator = $this->getContainer()->get('entity_validator');
    }
    
    public function init()
    {
        $this->authority->setObject($this->getParameter('album'));
        $this->authority->setOperator($this->getParameter('operator'));
        $this->validator->setObject($this->getParameter('album'));
    }
    
    public function doUpdate(){
        $this->getDoctrineManager()->persist($this->getParameter('album'));
        $this->getDoctrineManager()->flush();
        return true;
    }
    
    public function doCreate(){
        $statistics = new Statistics();
        $statistics->setType(Statistics::ALBUM_TYPE);
        $statistics_process = $this->getContainer()->get('statistics_process');
        $statistics_process->setParameters(array('statistics' => $statistics, 'operator' => $this->getParameter('operator')));
        if(!$statistics_process->work('create')){
            $this->addError('创建失败');
            return false;
        }
        $this->getDoctrineManager()->persist($statistics);
        $this->getDoctrineManager()->flush();
        $album =  $this->getParameter('album');
        $album->setStatistics($statistics);
        $this->getDoctrineManager()->persist($album);
        $this->getDoctrineManager()->flush();
        $statistics->setObjectId($album->getId());
        $this->getDoctrineManager()->flush();
        return true;
    }
    
    public function doDelete(){
        $this->getParameter('album')->setIsDelete(true);
        $this->getDoctrineManager()->persist($this->getParameter('album'));
        $this->getDoctrineManager()->flush();
        return true;
    }

}
