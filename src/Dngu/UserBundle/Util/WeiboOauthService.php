<?php

/*
 * 新浪微博api操作服务
 */

namespace Dngu\UserBundle\Util;

use Dngu\UserBundle\Util\Libs\Weibo\Oauth;
use Dngu\UserBundle\Util\Libs\Weibo\Client;
use Dngu\UserBundle\Entity\Oauth as OauthEntity;

class WeiboOauthService extends BaseSnsService {
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
        $this->param = $param['weibo'];
        $this->authorization = new Oauth($this->param['key'], $this->param['secret']);
    }
    
    public function getClient($access_token){
        if(!$this->client){
            $this->client = new Client($this->param['key'], $this->param['secret'], $access_token);
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
            $t = array();
            $t['access_token'] = $token['access_token'];
            $t['expires_in'] = $token['expires_in'];
            $t['uid'] = $token['uid'];
            $t['data'] = $token;
            $t['type'] = OauthEntity::WEIBO_TYPE;
            return $t;
        }
        return array();
    }
    
    public function getUserInfo(OauthEntity $oauth){
        $user = $this->getClient($oauth->getAccessToken())->show_user_by_id($oauth->getUid());
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
        return $return;
    }
    

}