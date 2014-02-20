<?php
namespace Dngu\ApiBundle\Controller;

use Dngu\WebBundle\Entity\Album;
use Dngu\ApiBundle\ResponseStatus\ResponseStatus;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/album")
 */
class AlbumController extends BaseController
{
    /**
     * 创建相册
     * @Route("/create", name="dngu_api_album_create")
     * @ApiDoc(
     *  resource=true,
     *  description="用户创建相册",
     *  section="Album",
     *  filters={
     *      {"name"="name", "dataType"="string", "desc"="create album"},
     *      {"name"="description", "dataType"="string", "desc"="description of the album"}
     *  }
     * )
     * @Method({"POST"})
     */
    public function createAction()
    {
        if(!$this->isLogin()){
            return $this->noLogin();
        }
        $name = $this->getRequest()->get('name');
        $desc = $this->getRequest()->get('description');
        $service = $this->get('album_process');
        $album = new Album();
        $album->setName($name);
        $album->setDescription($desc);
        $album->setUser($this->getUser());
        $service->setParameters(array('album' => $album, 'operator' => $this->getUser()));
        if($result = $service->work('create')){
            return $this->success('相册创建成功', $this->formatAlbum($album));
        }
        return $this->errorResponse(ResponseStatus::ALBUM_CREATE_FAILED, $service->shiftError());
    }
    
    /**
     * 相册上传图片
     * @Route("/pic/upload", name="dngu_api_album_pic_upload")
     * @ApiDoc(
     *  resource=true,
     *  description="相册上传图片",
     *  section="Album",
     *  filters={
     *      {"name"="image", "dataType"="file", "desc"="image"}
     *  }
     * )
     * @Method({"POST"})
     */
    public function uploadAction()
    {
        if(!$this->isLogin()){
            return $this->noLogin();
        }
//        $id = $this->get('request')->get('album_id');
//        if(!$album = $this->getAlbumRepository()->find($id) || $album->getIsDeleted() || $album->getUser()->getId() != $this->getUser()->getId()){
//            return $this->errorResponse(ResponseStatus::ALBUM_NOT_FOUND, "相册不存在");
//        }
        $image = $this->get('request')->files->get('image');
        $service = $this->get('dngu.image.upload');
        $result = $service->upload($image, $this->getContainer()->getParameter('album_upload_dir'));
        if($result){
            return $this->success("图片上传成功", array('name' => $service->getName(), 'path' => $service->getRelativePath() . $service->getName()));
        }
        return $this->errorResponse(ResponseStatus::ALBUM_UPLOAD_FAILED, $service->getError());
    }
}
