<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class SecurityController extends Controller {
    public function loginAction() {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($error) {
            $this->addFlash('warning', $error->getMessageKey());
        }
        return $this->render(
            'login.html.twig', array('last_username' => $lastUsername)
        );
    }
}