<?php
namespace Dngu\WebBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AlbumController extends BaseController
{
    /**
     * @Template()
     */
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
        $albums = $pager->paginate($query, $page, 20);
        return array(
            'user' => $user,
            'albums' => $albums
        );
    }
    
    /**
     * @Template()
     */
    public function detailAction($uid, $id, $page){
        if($this->getUser() == null || $uid != $this->getUser()->getId()){
            $user = $this->getUserRepository()->find($uid);
            if(!$user){
                throw new NotFoundHttpException('请求的页面不存在');
            }
        }else{
            $user = $this->getUser();
        }
        if(!$album = $this->getAlbumRepository()->find($id)){
            throw new NotFoundHttpException('请求的页面不存在');
        }
        $query = $this->getPictureRepository()->getAlbumPicturesQuery($album);
        $pictures = $this->get('knp_paginator')->paginate($query, $page, 20);
        return array(
            'user' => $user,
            'album' => $album,
            'pictures' => $pictures
        );
    }
}
