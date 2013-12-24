<?php

namespace Dngu\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dngu\UserBundle\Entity\Oauth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegisterController extends RegistrationController
{
    
//    public function confirmAction($token){
//        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);
//
//        if (null === $user) {
//            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
//        }
//
//        $user->setConfirmationToken(null);
//        $user->setEnabled(true);
//        $user->setLastLogin(new \DateTime());
//
//        $this->container->get('fos_user.user_manager')->updateUser($user);
//        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_registration_confirmed'));
//        $this->authenticateUser($user, $response);
//        
//        $process = $this->container->get('album_process');
//        $album = new \Dngu\WebBundle\Entity\Album();
//        $album->setIsSystem(true);
//        $album->setName(\Dngu\WebBundle\Entity\Album::DIARY_ALBUM_NAME);
//        $process->setParameters(array('album' => $album, 'operator' => $user));
//        
//        return $response;
//        
//    }

    public function snsAction($oauth)
    {
        $oauth_id = $oauth;
        $oauth = $this->container->get('doctrine')
                ->getRepository('DnguUserBundle:Oauth')
                ->find($oauth_id);
        if (!$oauth) {
            throw new NotFoundHttpException('请求的页面不存在');
        }
        if ($user = $oauth->getUser()) {
            if($user->isEnabled()){
                $response = new RedirectResponse($this->container->get('router')->generate('homepage', array('uid' => $user->getId())));
                $this->authenticateUser($user, $response);
                return $response;
            }
            //邮箱未认证，重新填写用户信息
            return new RedirectResponse($this->container->get('router')->generate('register_complete', array('user_id' => $user->getId(), 'oauth_id'=>$oauth_id)));
            
        }
        if ($oauth->getType() == Oauth::WEIBO_TYPE) {
            $oauth_handler = $this->container->get('dngu.weibo.oauth');
        } else if ($oauth->getType() == Oauth::TQQ_TYPE) {
            $oauth_handler = $this->container->get('dngu.tqq.oauth');
        } else {
            return new RedirectResponse($this->container->get('router')->generate('index'));
        }
        $info = $oauth_handler->getUserInfo($oauth);
        $name = $info['nickname'];
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();
            $name = $user->getUsername();
            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }
            $oauth->setUser($user);
            $em = $this->container->get('doctrine')->getManager();
            $em->persist($oauth);
            $em->flush();
            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }
            return $response;
        }

        return $this->container->get('templating')->renderResponse('DnguUserBundle:Register:sns.html.' . $this->getEngine(), array(
                    'form' => $form->createView(),
                    'oauth' => $oauth_id,
                    'name' => $name
        ));
    }
    
    /*
     * 使用第三方注册未激活的用户，再次注册时完成注册
     */
    public function completeAction($user_id, $oauth_id){
        $user = $this->container->get('doctrine')
                ->getRepository('DnguUserBundle:User')
                ->find($user_id);
        $oauth = $this->container->get('doctrine')
                ->getRepository('DnguUserBundle:Oauth')
                ->find($oauth_id);
        if(!$user || !$oauth || !$oauth->getUser() || $oauth->getUser()->getId() != $user->getId()){
            throw new NotFoundHttpException('请求的页面不存在');
        }
        $form = $this->container->get('fos_user.registration.form');
        $form->setData($user);
        $request = $this->container->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if($form->isValid()){
                $this->container->get('fos_user.user_manager')->updateUser($user);
                $authUser = false;
                $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
                if ($confirmationEnabled) {
                    $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                    $route = 'fos_user_registration_check_email';
                } else {
                    $authUser = true;
                    $route = 'fos_user_registration_confirmed';
                }
                $this->setFlash('fos_user_success', 'registration.flash.user_created');
                $url = $this->container->get('router')->generate($route);
                $response = new RedirectResponse($url);

                if ($authUser) {
                    $this->authenticateUser($user, $response);
                }
                return $response;
            }
        }
       return $this->container->get('templating')->renderResponse('DnguUserBundle:Register:complete.html.' . $this->getEngine(), array(
                    'form' => $form->createView(),
                    'oauth' => $oauth,
                    'user' => $user,
                    'name' => $user->getUsername()
        ));
    }

}
