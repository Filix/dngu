<?php
namespace Dngu\ApiBundle\Controller;

use Dngu\WebBundle\Controller\BaseController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dngu\ApiBundle\ResponseStatus\ResponseStatus;
use Dngu\WebBundle\Entity\Album;

/**
 * Description of BaseController
 *
 * @author Filix
 */
class BaseController extends Controller
{
    public function noLogin(){
        return $this->errorResponse(ResponseStatus::USER_NOT_LOGIN, '您还未登录');
    }
    
    public function errorResponse($error, $message){
        return new JsonResponse(array('code' => $error, 'message' => $message));
    }
    
    public function success($message, $data = array()){
        return new JsonResponse(array('code' => 200, 'message' => $message, 'data' => $data));
    }
    
    public function formatAlbum(Album $album){
        return array(
            'id' => $album->getId(),
            'name' => $album->getName(),
            'description' => $album->getDescription()
        );
    }
}
