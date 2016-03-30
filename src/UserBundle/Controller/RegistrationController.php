<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegistrationController extends BaseController
{
  public function registerAction()
  {
    $form = $this->container->get('fos_user.registration.form');
    $formHandler = $this->container->get('fos_user.registration.form.handler');
    $userManager = $this->container->get('fos_user.user_manager');
    $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

    $process = $formHandler->process($confirmationEnabled);
    if ($process) {
      $user = $form->getData();

      $file = $user->getAvatar()->getPath();

      // Generate a unique name for the file before saving it
      $fileName = md5(uniqid()).'.'.$file->guessExtension();

      // Move the file to the directory where poster are stored
      $avatarDir = $this->container->getParameter('kernel.root_dir').'/../web/images/avatar';
      $file->move($avatarDir, $fileName);


      // Update the 'avatar' property to store the file name
      // instead of its contents
      $user->getAvatar()->setPath($fileName);

      $userManager->updateUser($user);

      $authUser = false;
      if ($confirmationEnabled) {
        $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
        $route = 'fos_user_registration_check_email';
      } else {
        $authUser = true;
        $route = 'serie_homepage';
      }

      $this->setFlash('fos_user_success', 'registration.flash.user_created');
      $url = $this->container->get('router')->generate($route);
      $response = new RedirectResponse($url);

      if ($authUser) {
        $this->authenticateUser($user, $response);
      }

      return $response;
    }

    return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
        'form' => $form->createView(),
    ));

  }
}