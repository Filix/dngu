<?php

/*
 * 新浪微博api操作服务
 */

namespace Dngu\UserBundle\Util;

use Dngu\UserBundle\Util\Libs\Weibo\Oauth;
use Dngu\UserBundle\Util\Libs\Weibo\Client;
//use Dngu\WebBundle\Entity\Oauth as OauthEntity;

class WeiboOauthService {
    
   
    /*
     * api操作类
     */

    protected $client;

    /*
     * 授权操作类
     */
    protected $authorization;

    /*
     * app_key app_secret
     */
    protected $param;
    
    protected $router;
    
    /*
     * callback url
     */
    protected $callback;

    public function __construct(\Symfony\Bundle\FrameworkBundle\Routing\Router $router, Array $param) {
        $this->router = $router;
        $this->callback = $router->generate('weibo_callback', array(), true);
        $this->param = $param;
        var_dump($param);
        exit;
        $this->authorization = new Oauth($this->param['app_key'], $this->param['app_secret']);
    }
    
    public function getClient(){
        if(!$this->client){
            $this->client = new Client($this->authorization);
        }
        return $this->client;
    }
    
    public function getAuthorizeURL(){
        return $this->authorization->getAuthorizeURL($this->callback);
    }
    
    public function getAccessToken($code){
        $keys = array(
            'code' => $code,
            'redirect_uri' => $this->callback,
        );
        $token = @$this->authorization->getAccessToken( 'code', $keys) ;
        if(isset($token['access_token'])){
            $token['identity'] = $token['uid'];
            $token['type'] = OauthEntity::WEIBO_TYPE;
            return $token;
        }
        return array();
    }
    
    public function getUserInfo(OauthEntity $oauth){
        $user = $this->getClient()->show_user_by_id($oauth->getIdentity());
        $return = array();
        $return ['nickname'] = $user['name'];
        $return ['avatar'] = $user['profile_image_url'];
        $sex = 0;
        if($user['gender'] == 'f'){
            $sex = 2;
        }elseif($user['gender']=='m'){
            $sex = 1;
        }
        $return ['sex'] = $sex;
        $return ['birthday'] = '';
        return $return;
    }
    

}