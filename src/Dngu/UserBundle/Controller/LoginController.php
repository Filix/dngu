<?php

namespace Dngu\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dngu\UserBundle\Entity\Oauth;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends SecurityController
{
    
    public function loginAction()
    {
        if($this->container->get('security.context')->isGranted('ROLE_USER')){
            $url = $this->container->get('dngu.user.router')->getHomeUrl($this->container->get('security.context')->getToken()->getUser());
            return new RedirectResponse($url);
        }
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    public function weiboLoginAction()
    {
        if($this->container->get('security.context')->isGranted('ROLE_USER')){
            $url = $this->container->get('dngu.user.router')->getHomeUrl($this->container->get('security.context')->getToken()->getUser());
            return new RedirectResponse($url);
        }
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
        if($this->container->get('security.context')->isGranted('ROLE_USER')){
            $url = $this->container->get('dngu.user.router')->getHomeUrl($this->container->get('security.context')->getToken()->getUser());
            return new RedirectResponse($url);
        }
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
                return new RedirectResponse($this->container->get('router')->generate('sns_register', array('oauth' => $oauth->getId())));
            }else{
                $user = $oauth->getUser();
                $oauth->update($token);
                $em->flush();
                if(!$user->isEnabled()){
                    //邮箱未认证，重新填写用户信息
                     return new RedirectResponse($this->container->get('router')->generate('register_complete', array('user_id' => $user->getId(), 'oauth_id'=>$oauth->getId())));
                }
                $this->container->get('fos_user.security.login_manager')
                        ->loginUser(
                         $this->container->getParameter('fos_user.firewall_name'), 
                         $user
                );
                return new RedirectResponse($this->container->get('dngu.user.router')->getHomeUrl($user));
            }
        } else {
            exit('认证失败，请重新尝试');
        }
    }

}
