<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthController extends AbstractController
{
  private $session;
  public function __construct(SessionInterface $session)
  {
    $this->session = $session;
  }

  /**
   * @Route("/auth/logout", name="auth.logout")
   */
  public function logout()
  {
    $this->session->set('userEmail', null);
    return $this->redirectToRoute('users.login');
  }
}
