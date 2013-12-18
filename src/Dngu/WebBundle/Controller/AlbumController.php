<?php
namespace Dngu\WebBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlbumController extends BaseController
{
    public function listAction($uid, $page){
        if($this->getUser() == null || $uid != $this->getUser()->getId()){
            $user = $this->getUserRepository()->find($uid);
            if(!$user){
                throw new NotFoundHttpException('请求的页面不存在');
            }
        }else{
            $user = $this->getUser();
        }
        $pager = $this->get('knp_paginator');
        $query = $this->getAlbumRepository()->getUserAlbumsQuery($user);
        
    }
}
