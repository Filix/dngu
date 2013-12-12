<?php

namespace Dngu\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dngu\UserBundle\Entity\Oauth;

class RegisterController extends RegistrationController
{

    public function snsAction()
    {
        $oauth_id = $this->container->get('request')->query->get('oauth');
        $oauth = $this->container->get('doctrine')
                ->getRepository('DnguUserBundle:Oauth')
                ->find($oauth_id);
        if (!$oauth) {
            return new RedirectResponse($this->container->get('router')->generate('index'));
        }
        if ($user = $oauth->getUser()) {
            $response = new RedirectResponse($this->container->get('router')->generate('homepage', array('uid' => $user->getId())));
            $this->authenticateUser($user, $response);
            return $response;
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

}
