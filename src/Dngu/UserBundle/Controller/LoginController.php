<?php

namespace Dngu\UserBundle\Controller;

use Dngu\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends BaseController
{
    public function loginAction()
    {
        return $this->render('DnguUserBundle:Login:login.html.twig');
    }
    
    public function registerAction()
    {
        $form = $this->getContainer()->get('fos_user.registration.form');
        $formHandler = $this->getContainer()->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->getContainer()->getParameter('fos_user.registration.confirmation.enabled', true);
        $confirmationEnabled = true;
        $process = $formHandler->process($confirmationEnabled);
        
        if ($process) {
            $user = $form->getData();
            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->getRouter()->generate($route);
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
    
    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface        $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }
}
