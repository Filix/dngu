<?php
namespace Dngu\WebBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Dngu\WebBundle\Entity\Album;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        $albums = $pager->paginate($query, $page, 12);
        return array(
            'user' => $user,
            'albums' => $albums,
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
    
    /**
     * @Template()
     */
    public function createAction(){
        if(!$this->isLogin()){
            $url = $this->generateUrl('login', array('_target' => $this->generateUrl('album_create', array(), true)));
            return new RedirectResponse($url);
        }
        $error = null;
        if($this->getRequest()->isMethod('post')){
            $name = $this->getRequest()->get('name');
            $description = $this->getRequest()->get('description');
            $service = $this->get('album_process');
            $album = new Album();
            $album->setName($name);
            $album->setDescription($description);
            $album->setUser($this->getUser());
            $service->setParameters(array('album' => $album, 'operator' => $this->getUser()));
            if($result = $service->work('create')){
                $url = $this->generateUrl('album_detail', array('uid' => $this->getUser()->getSlugOrId(), 'id' => $album->getId()));
                return new RedirectResponse($url);
            }
            $error = $service->shiftError();
        }
        return array(
            'error' => $error
        );
    }
    
}
