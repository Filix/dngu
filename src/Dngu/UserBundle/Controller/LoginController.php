<?php

namespace Dngu\UserBundle\Controller;

use Dngu\WebBundle\Controller\BaseController;

class LoginController extends BaseController
{
    public function loginAction()
    {
        return $this->render('DnguUserBundle:Login:login.html.twig');
    }
    
    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        $process = $formHandler->process($confirmationEnabled);
        
        if ($process) {
            $user = $form->getData();
            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->getRouter()->generate($route);
            var_dump($url);exit;
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }
            return $response;
        }

        return $this->render('DnguUserBundle:Login:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
