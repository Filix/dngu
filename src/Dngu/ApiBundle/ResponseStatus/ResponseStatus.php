<?php
namespace Dngu\ApiBundle\ResponseStatus;
/**
 * Description of ResponseStatus
 *
 * @author Filix
 */
class ResponseStatus
{
    /*
     * 用户相关
     */
    #用户未登录
    const USER_NOT_LOGIN = 10001;
    
    /*
     * 相册相关
     */
    #创建失败
    const ALBUM_CREATE_FAILED = 20001;
    
    #相册不存在
    const ALBUM_NOT_FOUND = 20002;
    
    #图片上传失败
    const ALBUM_UPLOAD_FAILED = 20003;
}
