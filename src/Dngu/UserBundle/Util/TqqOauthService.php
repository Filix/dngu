<?php

/*
 * qq微博api操作服务
 */

namespace Dngu\UserBundle\Util;

use Dngu\UserBundle\Util\Libs\Tqq\Oauth;
use Dngu\UserBundle\Util\Libs\Tqq\Client;
use Dngu\UserBundle\Util\Libs\Tqq\Http;
use Dngu\UserBundle\Entity\Oauth as OauthEntity;

class TqqOauthService extends BaseSnsService{
    
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
        $this->callback = $router->generate('tqq_callback', array(), true);
        $this->param = $param['tqq'];
        Oauth::init($this->param['key'], $this->param['secret']);
    }
    
    public function getApi($access_token, $t_openid, $command, $params = array(), $method = 'GET', $multi = false){
        Client::$access_token = $access_token;
        Client::$t_openid = $t_openid;
        return json_decode(Client::api($command, $params, $method, $multi), true);
    }
    
    public function getAuthorizeURL(){
        return Oauth::getAuthorizeURL($this->callback, 'code');
    }
    
    public function getAccessToken($code){
        $url = Oauth::getAccessToken($code, $this->callback);
        $r = Http::request($url);
        @parse_str($r, $token);
        if (isset($token['access_token'])) {
            $t = array();
            $t['access_token'] = $token['access_token'];
            $t['expires_in'] = $token['expires_in'];
            $t['refresh_token'] = $token['refresh_token'];
            $t['uid'] = $token['openid'];
            $t['data'] = $token;
            $t['type'] = OauthEntity::TQQ_TYPE;
            return $t;
        }
        return array();
    }
    
    
    public function getUserInfo(OauthEntity $oauth){
        $user = $this->getApi($oauth->getAccessToken(), $oauth->getUid(), 'user/info');
        $return = array();
        $return['nickname'] = $user['data']['nick'];
        $return['avatar'] = $user['data']['head'];
        $return['sex'] = $user['data']['sex'];
        return $return;
    }

}