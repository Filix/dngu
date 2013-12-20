<?php

namespace Dngu\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dngu\UserBundle\Entity\Oauth;

class LoginController extends SecurityController
{

    public function weiboLoginAction()
    {
//        if($this->container->get('security.context')->isGranted('ROLE_USER')){
//            $url = $this->container->get('router')->generate('homepage', array('uid' => $this->container->get('security.context')->getToken()->getUser()->getId()));
//            return new RedirectResponse($url);
//        }
        $v = $this->container->get('validator');
        $url = $this->container->get('dngu.weibo.oauth')->getAuthorizeURL();
        return new RedirectResponse($url);
    }

    public function weiboCallbackAction()
    {
        $code = $this->container->get('request')->query->get('code');
        $token = $this->container->get('dngu.weibo.oauth')->getAccessToken($code);
        return $this->processToken($token);
    }
    
    public function tqqLoginAction()
    {
        $url = $this->container->get('dngu.tqq.oauth')->getAuthorizeURL();
        return new RedirectResponse($url);
    }

    public function tqqCallbackAction()
    {
        $code = $this->container->get('request')->query->get('code');
        $token = $this->container->get('dngu.tqq.oauth')->getAccessToken($code);
        return $this->processToken($token);
    }
    
    protected function processToken($token){
        if (isset($token['access_token'])) {
            $em = $this->container->get('doctrine')->getManager();
            $oauth = $this->container->get('doctrine')
                    ->getRepository('DnguUserBundle:Oauth')
                    ->getOneByAccessTokenAndType($token['access_token'], $token['type']);
            if(!$oauth || !$oauth->getUser()){  //未注册
                if(!$oauth){
                    $oauth = new Oauth();
                    $oauth->update($token);
                    $em->persist($oauth);
                    $em->flush();
                }
                return new RedirectResponse($this->container->get('router')->generate('weibo_register', array('oauth' => $oauth->getId())));
            }else{
                $user = $oauth->getUser();
                $oauth->update($token);
                $em->flush();
                $this->container->get('fos_user.security.login_manager')
                        ->loginUser(
                         $this->container->getParameter('fos_user.firewall_name'), 
                         $user
                );
                return new RedirectResponse($this->container->get('router')->generate('homepage', array('uid' => $user->getId())));
            }
        } else {
            exit('认证失败，请重新尝试');
        }
    }

}
